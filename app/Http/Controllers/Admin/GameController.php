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
     * Validasi bersama untuk store & update.
     */
    protected function validatedData(
        Request $request,
        ?Game $game = null
    ) {
        return $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                $game
                    ? Rule::unique('games', 'slug')->ignore($game->id)
                    : 'unique:games,slug',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],

            'icon' => [
                'nullable',
                'image',
                'mimes:jpeg,png,webp',
                'max:2048',
            ],

            'banner' => [
                'nullable',
                'image',
                'mimes:jpeg,png,webp',
                'max:2048',
            ],

            'configuration' => [
                'required',
                'array',
            ],

            'configuration.minimum_bet' => [
                'required',
                'numeric',
                'min:1',
            ],

            'configuration.maximum_bet' => [
                'required',
                'numeric',
                'gte:configuration.minimum_bet',
            ],

            'configuration.normal_rate' => [
                'required',
                'numeric',
                'min:0',
            ],

            'configuration.special_rate' => [
                'required',
                'numeric',
                'min:0',
            ],

            'configuration.special_duration' => [
                'required',
                'integer',
                'min:1',
            ],

            'configuration.round_duration' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'configuration.max_rounds' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'configuration.special_times' => [
                'nullable',
                'array',
            ],

            'configuration.special_times.*' => [
                'nullable',
                'string',
            ],

        ]);
    }


    /**
     * Simpan game baru.
     */
    public function store(Request $request)
    {
        $validated = $this->validatedData($request);


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
         * Bersihkan special times (buang value kosong).
         */
        $specialTimes = collect(
            $validated['configuration']['special_times'] ?? []
        )
            ->map(fn ($time) => trim((string) $time))
            ->filter()
            ->values()
            ->toArray();


        /*
         * Upload icon & banner (jika ada).
         */
        $iconPath = $request->hasFile('icon')
            ? $request->file('icon')->store('games/icons', 'public')
            : null;

        $bannerPath = $request->hasFile('banner')
            ? $request->file('banner')->store('games/banners', 'public')
            : null;


        /*
         * Configuration game.
         */
        $configuration = [

            'minimum_bet' =>
                (float) $validated['configuration']['minimum_bet'],

            'maximum_bet' =>
                (float) $validated['configuration']['maximum_bet'],

            'normal_rate' =>
                (float) $validated['configuration']['normal_rate'],

            'special_rate' =>
                (float) $validated['configuration']['special_rate'],

            'special_duration' =>
                (int) $validated['configuration']['special_duration'],

            'round_duration' =>
                isset($validated['configuration']['round_duration'])
                    ? (int) $validated['configuration']['round_duration']
                    : null,

            'max_rounds' =>
                isset($validated['configuration']['max_rounds'])
                    ? (int) $validated['configuration']['max_rounds']
                    : null,

            'special_times' =>
                $specialTimes,
        ];


        Game::create([

            'name' =>
                $validated['name'],

            'slug' =>
                $slug,

            'description' =>
                $validated['description'] ?? null,

            'status' =>
                $validated['status'],

            'icon' =>
                $iconPath,

            'banner' =>
                $bannerPath,

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

        $validated = $this->validatedData($request, $game);


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
         * Bersihkan special times (buang value kosong).
         */
        $specialTimes = collect(
            $validated['configuration']['special_times'] ?? []
        )
            ->map(fn ($time) => trim((string) $time))
            ->filter()
            ->values()
            ->toArray();


        /*
         * Upload icon & banner (jika ada file baru,
         * kalau tidak, pakai yang lama).
         */
        $iconPath = $request->hasFile('icon')
            ? $request->file('icon')->store('games/icons', 'public')
            : $game->icon;

        $bannerPath = $request->hasFile('banner')
            ? $request->file('banner')->store('games/banners', 'public')
            : $game->banner;


        /*
         * Configuration.
         */
        $configuration = [

            'minimum_bet' =>
                (float) $validated['configuration']['minimum_bet'],

            'maximum_bet' =>
                (float) $validated['configuration']['maximum_bet'],

            'normal_rate' =>
                (float) $validated['configuration']['normal_rate'],

            'special_rate' =>
                (float) $validated['configuration']['special_rate'],

            'special_duration' =>
                (int) $validated['configuration']['special_duration'],

            'round_duration' =>
                isset($validated['configuration']['round_duration'])
                    ? (int) $validated['configuration']['round_duration']
                    : null,

            'max_rounds' =>
                isset($validated['configuration']['max_rounds'])
                    ? (int) $validated['configuration']['max_rounds']
                    : null,

            'special_times' =>
                $specialTimes,
        ];


        $game->update([

            'name' =>
                $validated['name'],

            'slug' =>
                $slug,

            'description' =>
                $validated['description'] ?? null,

            'status' =>
                $validated['status'],

            'icon' =>
                $iconPath,

            'banner' =>
                $bannerPath,

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
