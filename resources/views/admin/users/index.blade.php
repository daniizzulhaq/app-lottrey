@extends('admin.layouts.app')

@section('title', 'Kelola User')

@section('content')

    <div class="page-header">

        <h1>Kelola User</h1>

        <p>Daftar seluruh user terdaftar pada sistem.</p>

    </div>


    <div class="card">

        <div class="card-header">

            <div>

                <div class="card-title">
                    Daftar User
                </div>

                <div class="card-description">
                    Total {{ $users->total() }} user
                </div>

            </div>

            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                + Tambah User
            </a>

        </div>

        <div class="card-body">

            <form method="GET" action="{{ route('admin.users.index') }}" style="margin-bottom: 18px;">

                <input
                    type="text"
                    name="search"
                    class="form-input"
                    placeholder="Cari nama atau email..."
                    value="{{ request('search') }}"
                >

            </form>


            <div class="table-wrapper">

                <table class="table">

                    <thead>

                        <tr>

                            <th>Nama</th>

                            <th>Email</th>

                            <th>Role</th>

                            <th>Status</th>

                            <th>Bergabung</th>

                            <th></th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($users as $user)

                            <tr>

                                <td>{{ $user->name }}</td>

                                <td>{{ $user->email }}</td>

                                <td>

                                    @if($user->role === 'admin')

                                        <span class="badge badge-info">Admin</span>

                                    @else

                                        <span class="badge badge-info" style="background: rgba(148,163,184,.12); color: #cbd5e1;">
                                            User
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    @if($user->status === 'active')

                                        <span class="badge badge-success">Aktif</span>

                                    @elseif($user->status === 'inactive')

                                        <span class="badge badge-warning">Nonaktif</span>

                                    @else

                                        <span class="badge badge-danger">Suspended</span>

                                    @endif

                                </td>

                                <td>{{ $user->created_at->format('d M Y') }}</td>

                                <td>

                                    <div style="display: flex; gap: 8px;">

                                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary">
                                            Detail
                                        </a>

                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-secondary">
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.users.destroy', $user) }}"
                                            onsubmit="return confirm('Hapus user {{ $user->name }}?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger">
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" style="text-align: center; color: #64748b; padding: 30px;">
                                    Belum ada data user.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <div style="margin-top: 20px;">
                {{ $users->links() }}
            </div>

        </div>

    </div>

@endsection
