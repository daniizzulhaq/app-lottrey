@extends('admin.layouts.app')

@section('title', 'Tambah User')

@section('content')

    <div class="page-header">

        <h1>Tambah User</h1>

        <p>Buat akun user baru.</p>

    </div>


    <div class="card">

        <div class="card-header">

            <div>

                <div class="card-title">
                    Form User Baru
                </div>

            </div>

            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                Kembali
            </a>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('admin.users.store') }}">

                @csrf

                <div class="form-group">

                    <label class="form-label">Nama</label>

                    <input
                        type="text"
                        name="name"
                        class="form-input"
                        value="{{ old('name') }}"
                        required
                    >

                </div>


                <div class="form-group">

                    <label class="form-label">Email</label>

                    <input
                        type="email"
                        name="email"
                        class="form-input"
                        value="{{ old('email') }}"
                        required
                    >

                </div>


                <div class="form-group">

                    <label class="form-label">Password</label>

                    <input
                        type="password"
                        name="password"
                        class="form-input"
                        required
                    >

                </div>


                <div class="form-group">

                    <label class="form-label">Konfirmasi Password</label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-input"
                        required
                    >

                </div>


                <div class="form-group">

                    <label class="form-label">Role</label>

                    <select name="role" class="form-select" required>

                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>
                            User
                        </option>

                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label class="form-label">Status</label>

                    <select name="status" class="form-select" required>

                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>
                            Nonaktif
                        </option>

                        <option value="suspended" {{ old('status') === 'suspended' ? 'selected' : '' }}>
                            Suspended
                        </option>

                    </select>

                </div>


                <div style="display: flex; gap: 10px; margin-top: 24px;">

                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>

                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        Batal
                    </a>

                </div>

            </form>

        </div>

    </div>

@endsection
