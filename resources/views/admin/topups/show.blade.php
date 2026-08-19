@extends('admin.layouts.app')

@section('title', 'Detail Top Up')

@section('content')

    <div class="page-header">

        <h1>Detail Top Up</h1>

        <p>Permintaan top up dari {{ $topup->user->name ?? '-' }}.</p>

    </div>


    {{-- =========================================================
         INFORMASI TOP UP
    ========================================================== --}}

    <div class="card" style="margin-bottom: 20px;">

        <div class="card-header">

            <div>

                <div class="card-title">
                    Informasi Top Up
                </div>

            </div>

            <div style="
                display:flex;
                gap:8px;
                align-items:center;
            ">

                @if($topup->status === 'pending')

                    <span class="badge badge-warning">
                        Pending
                    </span>

                @elseif($topup->status === 'approved')

                    <span class="badge badge-success">
                        Approved
                    </span>

                @else

                    <span class="badge badge-danger">
                        Rejected
                    </span>

                @endif


                <a
                    href="{{ route('admin.topups.index') }}"
                    class="btn btn-secondary"
                >
                    Kembali
                </a>

            </div>

        </div>


        <div class="card-body">

            <div style="
                display:grid;
                grid-template-columns:repeat(2, 1fr);
                gap:18px;
            ">

                {{-- USER --}}

                <div>

                    <div
                        class="form-label"
                        style="color:#64748b;"
                    >
                        User
                    </div>

                    <div>
                        {{ $topup->user->name ?? '-' }}
                    </div>

                </div>


                {{-- EMAIL --}}

                <div>

                    <div
                        class="form-label"
                        style="color:#64748b;"
                    >
                        Email
                    </div>

                    <div>
                        {{ $topup->user->email ?? '-' }}
                    </div>

                </div>


                {{-- JUMLAH --}}

                <div>

                    <div
                        class="form-label"
                        style="color:#64748b;"
                    >
                        Jumlah
                    </div>

                    <div>
                        Rp {{ number_format($topup->amount, 0, ',', '.') }}
                    </div>

                </div>


                {{-- PAYMENT METHOD --}}

                <div>

                    <div
                        class="form-label"
                        style="color:#64748b;"
                    >
                        Metode Pembayaran
                    </div>

                    <div>
                        {{ $topup->payment_method ?? '-' }}
                    </div>

                </div>


                {{-- DIAJUKAN --}}

                <div>

                    <div
                        class="form-label"
                        style="color:#64748b;"
                    >
                        Diajukan
                    </div>

                    <div>
                        {{ $topup->created_at->format('d M Y, H:i') }}
                    </div>

                </div>


                {{-- DIPROSES OLEH --}}

                @if($topup->status !== 'pending')

                    <div>

                        <div
                            class="form-label"
                            style="color:#64748b;"
                        >
                            Diproses Oleh
                        </div>

                        <div>
                            {{ $topup->approver->name ?? '-' }}
                        </div>

                    </div>


                    {{-- DIPROSES PADA --}}

                    <div>

                        <div
                            class="form-label"
                            style="color:#64748b;"
                        >
                            Diproses Pada
                        </div>

                        <div>
                            {{
                                $topup->approved_at
                                    ? \Carbon\Carbon::parse($topup->approved_at)->format('d M Y, H:i')
                                    : '-'
                            }}
                        </div>

                    </div>

                @endif


                {{-- =====================================================
                     BUKTI TRANSFER
                ====================================================== --}}

                <div style="
                    grid-column:1 / -1;
                    margin-top:10px;
                ">

                    <div
                        class="form-label"
                        style="
                            color:#64748b;
                            margin-bottom:10px;
                        "
                    >
                        Bukti Transfer
                    </div>


                    @if($topup->proof)

                        <div style="
                            background:#f8fafc;
                            border:1px solid #e2e8f0;
                            border-radius:10px;
                            padding:15px;
                            display:inline-block;
                        ">

                            <a
                                href="{{ asset('storage/' . $topup->proof) }}"
                                target="_blank"
                                title="Klik untuk melihat bukti transfer"
                            >

                                <img
                                    src="{{ asset('storage/' . $topup->proof) }}"
                                    alt="Bukti Transfer"
                                    style="
                                        display:block;
                                        max-width:450px;
                                        max-height:500px;
                                        width:auto;
                                        height:auto;
                                        object-fit:contain;
                                        border-radius:6px;
                                        cursor:pointer;
                                    "
                                >

                            </a>

                            <div style="
                                margin-top:8px;
                                color:#64748b;
                                font-size:12px;
                                text-align:center;
                            ">
                                Klik gambar untuk melihat ukuran penuh
                            </div>

                        </div>

                    @else

                        <div style="
                            padding:20px;
                            background:#f8fafc;
                            border:1px solid #e2e8f0;
                            border-radius:8px;
                            color:#64748b;
                        ">
                            Bukti transfer belum tersedia.
                        </div>

                    @endif

                </div>


                {{-- ALASAN PENOLAKAN --}}

                @if(
                    $topup->status === 'rejected' &&
                    $topup->rejection_reason
                )

                    <div style="
                        grid-column:1 / -1;
                    ">

                        <div
                            class="form-label"
                            style="color:#64748b;"
                        >
                            Alasan Penolakan
                        </div>

                        <div>
                            {{ $topup->rejection_reason }}
                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- =========================================================
         PROSES TOP UP
    ========================================================== --}}

    @if($topup->status === 'pending')

        <div class="card">

            <div class="card-header">

                <div class="card-title">
                    Proses Top Up
                </div>

            </div>


            <div class="card-body">

                <div style="
                    display:flex;
                    gap:20px;
                    flex-wrap:wrap;
                ">


                    {{-- APPROVE --}}

                    <form
                        method="POST"
                        action="{{ route('admin.topups.approve', $topup) }}"
                        onsubmit="return confirm('Approve top up ini? Saldo user akan langsung bertambah.');"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="btn btn-success"
                        >
                            Approve Top Up
                        </button>

                    </form>


                    {{-- REJECT --}}

                    <form
                        method="POST"
                        action="{{ route('admin.topups.reject', $topup) }}"
                        style="
                            flex:1;
                            min-width:280px;
                        "
                    >

                        @csrf

                        <div style="
                            display:flex;
                            gap:10px;
                        ">

                            <input
                                type="text"
                                name="rejection_reason"
                                class="form-input"
                                placeholder="Alasan penolakan"
                                required
                            >

                            <button
                                type="submit"
                                class="btn btn-danger"
                            >
                                Tolak
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    @endif

@endsection
