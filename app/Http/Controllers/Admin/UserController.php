<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Daftar user.
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->when(
                $request->filled('search'),
                function ($query) use ($request) {

                    $search = $request->search;

                    $query->where(function ($q) use ($search) {

                        $q->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        );

                        $q->orWhere(
                            'email',
                            'like',
                            '%' . $search . '%'
                        );

                    });
                }
            )
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view(
            'admin.users.index',
            compact('users')
        );
    }


    /**
     * Form tambah user.
     */
    public function create()
    {
        return view('admin.users.create');
    }


    /**
     * Simpan user baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                Rule::in([
                    'user',
                    'admin',
                ]),
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                    'suspended',
                ]),
            ],
        ]);


        User::create([

            'name' =>
                $validated['name'],

            'email' =>
                $validated['email'],

            'password' =>
                Hash::make(
                    $validated['password']
                ),

            'balance' =>
                0,

            'role' =>
                $validated['role'],

            'status' =>
                $validated['status'],
        ]);


        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'User berhasil dibuat.'
            );
    }


    /**
     * Detail user.
     */
    public function show(User $user)
    {
        $user->load([
            'transactions',
            'topups',
            'redemptions',
        ]);

        return view(
            'admin.users.show',
            compact('user')
        );
    }


    /**
     * Form edit user.
     */
    public function edit(User $user)
    {
        return view(
            'admin.users.edit',
            compact('user')
        );
    }


    /**
     * Update user.
     */
    public function update(
        Request $request,
        User $user
    ) {
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],

            'role' => [
                'required',
                Rule::in([
                    'user',
                    'admin',
                ]),
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                    'suspended',
                ]),
            ],

            /*
             * Password boleh kosong ketika edit.
             */
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);


        $data = [

            'name' =>
                $validated['name'],

            'email' =>
                $validated['email'],

            'role' =>
                $validated['role'],

            'status' =>
                $validated['status'],
        ];


        /*
         * Hanya update password
         * jika admin mengisinya.
         */
        if (
            !empty(
                $validated['password']
            )
        ) {

            $data['password'] =
                Hash::make(
                    $validated['password']
                );
        }


        $user->update($data);


        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'User berhasil diperbarui.'
            );
    }


    /**
     * Hapus user.
     */
    public function destroy(User $user)
    {
        /*
         * Admin tidak boleh
         * menghapus akun sendiri.
         */
        if (
            auth()->check() &&
            $user->id === auth()->id()
        ) {

            return back()->with(
                'error',
                'Anda tidak dapat menghapus akun sendiri.'
            );
        }


        $user->delete();


        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'User berhasil dihapus.'
            );
    }
}
