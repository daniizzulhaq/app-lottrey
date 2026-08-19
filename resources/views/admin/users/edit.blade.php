@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')

    <div class="page-header">

        <h1>Edit User</h1>

        <p>Perbarui data user {{ $user->name }}.</p>

    </div>


    <div class="card">

        <div class="card-header">

            <div>

                <div class="card-title">
                    Form Edit User
                </div>

            </div>

            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                Kembali
            </a>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('admin.users.update', $user) }}">

                @csrf
                @method('PUT')

                <div class="form-group">

                    <label class="form-label">Nama</label>

                    <input
                        type="text"
                        name="name"
                        class="form-input"
                        value="{{ old('name', $user->name) }}"
                        required
                    >

                </div>


                <div class="form-group">

                    <label class="form-label">Email</label>

                    <input
                        type="email"
                        name="email"
                        class="form-input"
                        value="{{ old('email', $user->email) }}"
                        required
                    >

                </div>


                <div class="form-group">

                    <label class="form-label">Role</label>

                    <select name="role" class="form-select" required>

                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>
                            User
                        </option>

                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label class="form-label">Status</label>

                    <select name="status" class="form-select" required>

                        <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>
                            Nonaktif
                        </option>

                        <option value="suspended" {{ old('status', $user->status) === 'suspended' ? 'selected' : '' }}>
                            Suspended
                        </option>

                    </select>

                </div>


                <div style="display: flex; gap: 10px; margin-top: 24px;">

                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        Batal
                    </a>

                </div>

            </form>

        </div>

    </div>

@endsection
