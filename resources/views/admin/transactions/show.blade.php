@extends('admin.layouts.app')

@section('title', 'Detail Transaksi')

@section('content')

    <div class="page-header">

        <h1>Detail Transaksi</h1>

        <p>Transaksi milik {{ $transaction->user->name ?? '-' }}.</p>

    </div>


    <div class="card">

        <div class="card-header">

            <div>

                <div class="card-title">
                    Informasi Transaksi
                </div>

            </div>

            <div style="display: flex; gap: 8px; align-items: center;">

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

                <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

            </div>

        </div>

        <div class="card-body">

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px;">

                <div>

                    <div class="form-label" style="color: #64748b;">User</div>

                    <div>{{ $transaction->user->name ?? '-' }}</div>

                </div>


                <div>

                    <div class="form-label" style="color: #64748b;">Email</div>

                    <div>{{ $transaction->user->email ?? '-' }}</div>

                </div>


                <div>

                    <div class="form-label" style="color: #64748b;">Jumlah</div>

                    <div>{{ number_format($transaction->amount, 0, ',', '.') }}</div>

                </div>


                <div>

                    <div class="form-label" style="color: #64748b;">Tanggal</div>

                    <div>{{ $transaction->created_at->format('d M Y, H:i') }}</div>

                </div>


                <div>

                    <div class="form-label" style="color: #64748b;">Saldo Sebelum</div>

                    <div>{{ number_format($transaction->balance_before, 0, ',', '.') }}</div>

                </div>


                <div>

                    <div class="form-label" style="color: #64748b;">Saldo Sesudah</div>

                    <div>{{ number_format($transaction->balance_after, 0, ',', '.') }}</div>

                </div>


                @if($transaction->reference_type)

                    <div>

                        <div class="form-label" style="color: #64748b;">Referensi</div>

                        <div>{{ class_basename($transaction->reference_type) }} #{{ $transaction->reference_id }}</div>

                    </div>

                @endif


                <div style="grid-column: 1 / -1;">

                    <div class="form-label" style="color: #64748b;">Deskripsi</div>

                    <div>{{ $transaction->description ?: '-' }}</div>

                </div>

            </div>

        </div>

    </div>

@endsection
