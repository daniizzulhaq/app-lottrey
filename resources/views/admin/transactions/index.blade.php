@extends('admin.layouts.app')

@section('title', 'Kelola Transaksi')

@section('content')

    <div class="page-header">

        <h1>Kelola Transaksi</h1>

        <p>Daftar seluruh transaksi virtual credit.</p>

    </div>


    <div class="card">

        <div class="card-header">

            <div>

                <div class="card-title">
                    Daftar Transaksi
                </div>

                <div class="card-description">
                    Total {{ $transactions->total() }} transaksi
                </div>

            </div>

        </div>

        <div class="card-body">

            <form method="GET" action="{{ route('admin.transactions.index') }}" style="margin-bottom: 18px; display: flex; gap: 12px; flex-wrap: wrap;">

                <select
                    name="type"
                    class="form-select"
                    onchange="this.form.submit()"
                    style="max-width: 220px;"
                >

                    <option value="">Semua Jenis</option>

                    <option value="TOPUP" {{ request('type') === 'TOPUP' ? 'selected' : '' }}>
                        Top Up
                    </option>

                    <option value="WIN" {{ request('type') === 'WIN' ? 'selected' : '' }}>
                        Win
                    </option>

                    <option value="REFUND" {{ request('type') === 'REFUND' ? 'selected' : '' }}>
                        Refund
                    </option>

                    <option value="BET" {{ request('type') === 'BET' ? 'selected' : '' }}>
                        Bet
                    </option>

                </select>


                <select
                    name="user_id"
                    class="form-select"
                    onchange="this.form.submit()"
                    style="max-width: 260px;"
                >

                    <option value="">Semua User</option>

                    @foreach($users as $user)

                        <option
                            value="{{ $user->id }}"
                            {{ (string) request('user_id') === (string) $user->id ? 'selected' : '' }}
                        >
                            {{ $user->name }}
                        </option>

                    @endforeach

                </select>

            </form>


            <div class="table-wrapper">

                <table class="table">

                    <thead>

                        <tr>

                            <th>User</th>

                            <th>Jenis</th>

                            <th>Jumlah</th>

                            <th>Saldo Sebelum</th>

                            <th>Saldo Sesudah</th>

                            <th>Tanggal</th>

                            <th></th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($transactions as $transaction)

                            <tr>

                                <td>{{ $transaction->user->name ?? '-' }}</td>

                                <td>

                                    @if($transaction->type === 'TOPUP')

                                        <span class="badge badge-success">Top Up</span>

                                    @elseif($transaction->type === 'WIN')

                                        <span class="badge badge-info">Win</span>

                                    @elseif($transaction->type === 'REFUND')

                                        <span class="badge badge-warning">Refund</span>

                                    @else

                                        <span class="badge badge-info" style="background: rgba(148,163,184,.12); color: #cbd5e1;">
                                            {{ $transaction->type }}
                                        </span>

                                    @endif

                                </td>

                                <td>{{ number_format($transaction->amount, 0, ',', '.') }}</td>

                                <td>{{ number_format($transaction->balance_before, 0, ',', '.') }}</td>

                                <td>{{ number_format($transaction->balance_after, 0, ',', '.') }}</td>

                                <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>

                                <td>

                                    <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn btn-secondary">
                                        Detail
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" style="text-align: center; color: #64748b; padding: 30px;">
                                    Belum ada data transaksi.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <div style="margin-top: 20px;">
                {{ $transactions->links() }}
            </div>

        </div>

    </div>

@endsection
