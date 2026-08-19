@extends('admin.layouts.app')

@section('title', 'Detail Redeem')

@section('content')

    <div class="page-header">

        <h1>Detail Redeem</h1>

        <p>Permintaan redeem dari {{ $redemption->user->name ?? '-' }}.</p>

    </div>


    <div class="card" style="margin-bottom: 20px;">

        <div class="card-header">

            <div>

                <div class="card-title">
                    Informasi Redeem
                </div>

            </div>

            <div style="display: flex; gap: 8px; align-items: center;">

                @if($redemption->status === 'pending')

                    <span class="badge badge-warning">Pending</span>

                @elseif($redemption->status === 'completed')

                    <span class="badge badge-success">Completed</span>

                @else

                    <span class="badge badge-danger">Rejected</span>

                @endif

                <a href="{{ route('admin.redemptions.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

            </div>

        </div>

        <div class="card-body">

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px;">

                <div>

                    <div class="form-label" style="color: #64748b;">User</div>

                    <div>{{ $redemption->user->name ?? '-' }}</div>

                </div>


                <div>

                    <div class="form-label" style="color: #64748b;">Email</div>

                    <div>{{ $redemption->user->email ?? '-' }}</div>

                </div>


                <div>

                    <div class="form-label" style="color: #64748b;">Jumlah</div>

                    <div>{{ number_format($redemption->amount, 0, ',', '.') }}</div>

                </div>


                <div>

                    <div class="form-label" style="color: #64748b;">Diajukan</div>

                    <div>{{ $redemption->created_at->format('d M Y, H:i') }}</div>

                </div>


                @if($redemption->status !== 'pending')

                    <div>

                        <div class="form-label" style="color: #64748b;">Diproses Oleh</div>

                        <div>{{ $redemption->approver->name ?? '-' }}</div>

                    </div>


                    <div>

                        <div class="form-label" style="color: #64748b;">Diproses Pada</div>

                        <div>{{ $redemption->approved_at ? \Carbon\Carbon::parse($redemption->approved_at)->format('d M Y, H:i') : '-' }}</div>

                    </div>

                @endif


                @if($redemption->status === 'rejected' && $redemption->rejection_reason)

                    <div style="grid-column: 1 / -1;">

                        <div class="form-label" style="color: #64748b;">Alasan Penolakan</div>

                        <div>{{ $redemption->rejection_reason }}</div>

                    </div>

                @endif

            </div>


            @if($redemption->status === 'pending')

                <div class="alert" style="background: rgba(59,130,246,.1); border: 1px solid rgba(59,130,246,.2); color: #60a5fa; margin-top: 20px;">
                    Saldo user sudah dipotong saat pengajuan redeem ini. Jika ditolak, virtual credit akan dikembalikan otomatis.
                </div>

            @endif

        </div>

    </div>


    @if($redemption->status === 'pending')

        <div class="card">

            <div class="card-header">

                <div class="card-title">
                    Proses Redeem
                </div>

            </div>

            <div class="card-body">

                <div style="display: flex; gap: 20px; flex-wrap: wrap;">

                    <form
                        method="POST"
                        action="{{ route('admin.redemptions.approve', $redemption) }}"
                        onsubmit="return confirm('Setujui redeem ini?');"
                    >

                        @csrf

                        <button type="submit" class="btn btn-success">
                            Approve Redeem
                        </button>

                    </form>


                    <form
                        method="POST"
                        action="{{ route('admin.redemptions.reject', $redemption) }}"
                        style="flex: 1; min-width: 280px;"
                    >

                        @csrf

                        <div style="display: flex; gap: 10px;">

                            <input
                                type="text"
                                name="rejection_reason"
                                class="form-input"
                                placeholder="Alasan penolakan"
                                required
                            >

                            <button type="submit" class="btn btn-danger">
                                Tolak &amp; Kembalikan Saldo
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    @endif

@endsection
