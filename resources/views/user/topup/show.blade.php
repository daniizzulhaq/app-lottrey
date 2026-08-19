@extends('user.layouts.app')

@section('title', 'Detail Top Up')

@section('content')

<div class="section" style="margin-top:10px;">

    <div class="section-header">

        <div>
            <div class="section-title">
                Detail Top Up
            </div>
        </div>

        <a
            href="{{ route('topup.history') }}"
            class="btn btn-secondary">

            Kembali

        </a>

    </div>


    <div class="card">

        <div style="
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:15px;
        ">

            <div>

                <div style="
                    color:#64748b;
                    font-size:11px;
                ">
                    ID Top Up
                </div>

                <div style="
                    margin-top:5px;
                    font-size:14px;
                    font-weight:600;
                ">
                    #{{ $topup->id }}
                </div>

            </div>


            <div>

                <div style="
                    color:#64748b;
                    font-size:11px;
                ">
                    Status
                </div>

                <div style="margin-top:5px;">

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

                </div>

            </div>


            <div>

                <div style="
                    color:#64748b;
                    font-size:11px;
                ">
                    Nominal
                </div>

                <div style="
                    margin-top:5px;
                    font-size:20px;
                    font-weight:700;
                ">

                    ${{ number_format(
                        $topup->amount,
                        2,
                        '.',
                        ','
                    ) }}

                </div>

            </div>


            <div>

                <div style="
                    color:#64748b;
                    font-size:11px;
                ">
                    Metode Pembayaran
                </div>

                <div style="
                    margin-top:5px;
                    font-size:14px;
                ">

                    {{ $topup->payment_method }}

                </div>

            </div>

        </div>


        @if($topup->proof)

            <div style="margin-top:25px;">

                <div style="
                    font-size:13px;
                    font-weight:600;
                    margin-bottom:10px;
                ">

                    Bukti Pembayaran

                </div>

                <img
                    src="{{ Storage::url($topup->proof) }}"
                    style="
                        max-width:350px;
                        max-height:400px;
                        border-radius:12px;
                        border:1px solid #334155;
                    ">

            </div>

        @endif


        @if($topup->rejection_reason)

            <div style="
                margin-top:20px;
                padding:15px;
                border-radius:10px;
                background:rgba(239,68,68,.1);
                color:#f87171;
            ">

                <strong>
                    Alasan Penolakan
                </strong>

                <div style="
                    margin-top:5px;
                    font-size:12px;
                ">

                    {{ $topup->rejection_reason }}

                </div>

            </div>

        @endif

    </div>

</div>

@endsection
