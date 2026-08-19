@extends('admin.layouts.app')

@section('title', 'Detail User')

@section('content')

    <div class="page-header">

        <h1>Detail User</h1>

        <p>Informasi lengkap akun {{ $user->name }}.</p>

    </div>


    <div class="stats-grid" style="margin-bottom: 20px;">

        <div class="stat-card">

            <div class="stat-top">

                <div>

                    <div class="stat-label">Saldo</div>

                    <div class="stat-number">
                        {{ number_format($user->balance, 0, ',', '.') }}
                    </div>

                </div>

                <div class="stat-icon">💰</div>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-top">

                <div>

                    <div class="stat-label">Transaksi</div>

                    <div class="stat-number">
                        {{ $user->transactions->count() }}
                    </div>

                </div>

                <div class="stat-icon">🔁</div>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-top">

                <div>

                    <div class="stat-label">Topup</div>

                    <div class="stat-number">
                        {{ $user->topups->count() }}
                    </div>

                </div>

                <div class="stat-icon">⬆️</div>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-top">

                <div>

                    <div class="stat-label">Redemption</div>

                    <div class="stat-number">
                        {{ $user->redemptions->count() }}
                    </div>

                </div>

                <div class="stat-icon">🎁</div>

            </div>

        </div>

    </div>


    <div class="card">

        <div class="card-header">

            <div>

                <div class="card-title">
                    Informasi Akun
                </div>

            </div>

            <div style="display: flex; gap: 8px;">

                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                    Edit
                </a>

                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

            </div>

        </div>

        <div class="card-body">

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px;">

                <div>

                    <div class="form-label" style="color: #64748b;">Nama</div>

                    <div>{{ $user->name }}</div>

                </div>


                <div>

                    <div class="form-label" style="color: #64748b;">Email</div>

                    <div>{{ $user->email }}</div>

                </div>


                <div>

                    <div class="form-label" style="color: #64748b;">Role</div>

                    <div>

                        @if($user->role === 'admin')

                            <span class="badge badge-info">Admin</span>

                        @else

                            <span class="badge badge-info" style="background: rgba(148,163,184,.12); color: #cbd5e1;">
                                User
                            </span>

                        @endif

                    </div>

                </div>


                <div>

                    <div class="form-label" style="color: #64748b;">Status</div>

                    <div>

                        @if($user->status === 'active')

                            <span class="badge badge-success">Aktif</span>

                        @elseif($user->status === 'inactive')

                            <span class="badge badge-warning">Nonaktif</span>

                        @else

                            <span class="badge badge-danger">Suspended</span>

                        @endif

                    </div>

                </div>


                <div>

                    <div class="form-label" style="color: #64748b;">Bergabung</div>

                    <div>{{ $user->created_at->format('d M Y, H:i') }}</div>

                </div>


                <div>

                    <div class="form-label" style="color: #64748b;">Terakhir Diperbarui</div>

                    <div>{{ $user->updated_at->format('d M Y, H:i') }}</div>

                </div>

            </div>

        </div>

    </div>


    <div class="card" style="margin-top: 20px;">

        <div class="card-header">

            <div class="card-title">
                Riwayat Transaksi Terbaru
            </div>

        </div>

        <div class="card-body">

            <div class="table-wrapper">

                <table class="table">

                    <thead>

                        <tr>

                            <th>Tanggal</th>

                            <th>Jenis</th>

                            <th>Jumlah</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($user->transactions->take(10) as $trx)

                            <tr>

                                <td>{{ $trx->created_at->format('d M Y, H:i') }}</td>

                                <td>{{ $trx->type ?? '-' }}</td>

                                <td>{{ number_format($trx->amount ?? 0, 0, ',', '.') }}</td>

                                <td>{{ $trx->status ?? '-' }}</td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" style="text-align: center; color: #64748b; padding: 24px;">
                                    Belum ada transaksi.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection
