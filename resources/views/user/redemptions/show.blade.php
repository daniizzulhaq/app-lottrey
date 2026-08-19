@extends('user.layouts.app')

@section('title', 'Detail Redeem')

@section('content')

<div class="section" style="margin-top:10px;">

    <div class="section-header">

        <div class="section-title">
            Detail Redeem
        </div>

        <a
            href="{{ route('redeem.history') }}"
            class="btn btn-secondary">

            Kembali

        </a>

    </div>


    <div class="card">

        <div style="
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:20px;
        ">

            <div>

                <div style="
                    color:#64748b;
                    font-size:11px;
                ">
                    ID
                </div>

                <div style="margin-top:5px;">
                    #{{ $redemption->id }}
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

                    @if($redemption->status === 'pending')

                        <span class="badge badge-warning">
                            Pending
                        </span>

                    @elseif(
                        $redemption->status === 'approved'
                        ||
                        $redemption->status === 'completed'
                    )

                        <span class="badge badge-success">
                            Completed
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
                    Amount
                </div>

                <div style="
                    margin-top:5px;
                    font-size:22px;
                    font-weight:700;
                ">

                    {{ number_format(
                        $redemption->amount,
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

            </div>


            <div>

                <div style="
                    color:#64748b;
                    font-size:11px;
                ">
                    Destination
                </div>

                <div style="
                    margin-top:5px;
                    font-size:13px;
                ">

                    {{ $redemption->destination }}

                </div>

            </div>

        </div>


        @if($redemption->rejection_reason)

            <div style="
                margin-top:25px;
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

                    {{ $redemption->rejection_reason }}

                </div>

            </div>

        @endif

    </div>

</div>

@endsection
