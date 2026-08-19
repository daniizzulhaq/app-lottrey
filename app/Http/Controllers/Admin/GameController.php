<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GameController extends Controller
{
    /**
     * Daftar game.
     */
    public function index(Request $request)
    {
        $games = Game::query()
            ->when(
                $request->search,
                function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where(
                            'name',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'slug',
                            'like',
                            "%{$search}%"
                        );
                    });
                }
            )
            ->when(
                $request->status,
                function ($query, $status) {
                    $query->where(
                        'status',
                        $status
                    );
                }
            )
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view(
            'admin.games.index',
            compact('games')
        );
    }


    /**
     * Form tambah game.
     */
    public function create()
    {
        return view(
            'admin.games.create'
        );
    }


    /**
     * Simpan game baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:games,slug',
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],

            'minimum_bet' => [
                'required',
                'numeric',
                'min:1',
            ],

            'maximum_bet' => [
                'required',
                'numeric',
                'gte:minimum_bet',
            ],

            'normal_rate' => [
                'required',
                'numeric',
                'min:0',
            ],

            'special_rate' => [
                'required',
                'numeric',
                'min:0',
            ],

            'special_duration' => [
                'required',
                'integer',
                'min:1',
            ],

            'special_times' => [
                'nullable',
                'string',
            ],

        ]);


        /*
         * Slug otomatis jika kosong.
         */
        $slug = $validated['slug']
            ?: Str::slug($validated['name']);


        /*
         * Pastikan slug unik.
         */
        if (
            Game::where(
                'slug',
                $slug
            )->exists()
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'slug' =>
                        'Slug game sudah digunakan.',
                ]);
        }


        /*
         * Ubah special times menjadi array.
         *
         * Contoh input:
         *
         * 14:30
         * 20:00
         */
        $specialTimes = [];

        if (
            !empty(
                $validated['special_times']
            )
        ) {

            $specialTimes = collect(
                preg_split(
                    '/[\r\n,]+/',
                    $validated['special_times']
                )
            )
                ->map(
                    fn ($time) => trim($time)
                )
                ->filter()
                ->values()
                ->toArray();
        }


        /*
         * Configuration game.
         */
        $configuration = [

            'minimum_bet' =>
                (float) $validated['minimum_bet'],

            'maximum_bet' =>
                (float) $validated['maximum_bet'],

            'normal_rate' =>
                (float) $validated['normal_rate'],

            'special_rate' =>
                (float) $validated['special_rate'],

            'special_duration' =>
                (int) $validated['special_duration'],

            'special_times' =>
                $specialTimes,
        ];


        Game::create([

            'name' =>
                $validated['name'],

            'slug' =>
                $slug,

            'status' =>
                $validated['status'],

            'configuration' =>
                $configuration,

        ]);


        return redirect()
            ->route(
                'admin.games.index'
            )
            ->with(
                'success',
                'Game berhasil dibuat.'
            );
    }


    /**
     * Detail game.
     */
    public function show(Game $game)
    {
        $game->load([
            'draws',
        ]);

        return view(
            'admin.games.show',
            compact('game')
        );
    }


    /**
     * Form edit game.
     */
    public function edit(Game $game)
    {
        return view(
            'admin.games.edit',
            compact('game')
        );
    }


    /**
     * Update game.
     */
    public function update(
        Request $request,
        Game $game
    ) {

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique(
                    'games',
                    'slug'
                )->ignore($game->id),
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],

            'minimum_bet' => [
                'required',
                'numeric',
                'min:1',
            ],

            'maximum_bet' => [
                'required',
                'numeric',
                'gte:minimum_bet',
            ],

            'normal_rate' => [
                'required',
                'numeric',
                'min:0',
            ],

            'special_rate' => [
                'required',
                'numeric',
                'min:0',
            ],

            'special_duration' => [
                'required',
                'integer',
                'min:1',
            ],

            'special_times' => [
                'nullable',
                'string',
            ],

        ]);


        /*
         * Slug otomatis.
         */
        $slug = $validated['slug']
            ?: Str::slug(
                $validated['name']
            );


        /*
         * Cek slug duplicate.
         */
        $slugExists = Game::where(
            'slug',
            $slug
        )
            ->where(
                'id',
                '!=',
                $game->id
            )
            ->exists();


        if ($slugExists) {

            return back()
                ->withInput()
                ->withErrors([
                    'slug' =>
                        'Slug game sudah digunakan.',
                ]);
        }


        /*
         * Special times.
         */
        $specialTimes = [];

        if (
            !empty(
                $validated['special_times']
            )
        ) {

            $specialTimes = collect(
                preg_split(
                    '/[\r\n,]+/',
                    $validated['special_times']
                )
            )
                ->map(
                    fn ($time) => trim($time)
                )
                ->filter()
                ->values()
                ->toArray();
        }


        /*
         * Configuration.
         */
        $configuration = [

            'minimum_bet' =>
                (float) $validated['minimum_bet'],

            'maximum_bet' =>
                (float) $validated['maximum_bet'],

            'normal_rate' =>
                (float) $validated['normal_rate'],

            'special_rate' =>
                (float) $validated['special_rate'],

            'special_duration' =>
                (int) $validated['special_duration'],

            'special_times' =>
                $specialTimes,
        ];


        $game->update([

            'name' =>
                $validated['name'],

            'slug' =>
                $slug,

            'status' =>
                $validated['status'],

            'configuration' =>
                $configuration,

        ]);


        return redirect()
            ->route(
                'admin.games.index'
            )
            ->with(
                'success',
                'Game berhasil diperbarui.'
            );
    }


    /**
     * Hapus game.
     */
    public function destroy(Game $game)
    {
        /*
         * Jangan hapus game jika
         * masih mempunyai draw.
         */
        if (
            $game->draws()->exists()
        ) {

            return back()->with(
                'error',
                'Game tidak dapat dihapus karena sudah memiliki draw.'
            );
        }


        $game->delete();


        return redirect()
            ->route(
                'admin.games.index'
            )
            ->with(
                'success',
                'Game berhasil dihapus.'
            );
    }
}
