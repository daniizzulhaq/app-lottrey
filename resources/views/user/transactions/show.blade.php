@extends('user.layouts.app')

@section('title', 'Transaction Detail')

@section('content')

<div class="section" style="margin-top:10px;">

    <div class="section-header">

        <div class="section-title">
            Detail Transaction
        </div>

        <a
            href="{{ route('transactions.index') }}"
            class="btn btn-secondary">

            Kembali

        </a>

    </div>


    <div class="card">

        <div style="
            text-align:center;
            padding:10px 0 25px;
        ">

            <div style="
                font-size:45px;
            ">
                💳
            </div>

            <div style="
                font-size:12px;
                color:#64748b;
                margin-top:5px;
            ">

                Transaction #{{ $transaction->id }}

            </div>

            <div style="
                font-size:28px;
                font-weight:700;
                margin-top:8px;
            ">

                {{ number_format(
                    $transaction->amount,
                    0,
                    ',',
                    '.'
                ) }}

            </div>

        </div>


        <div style="
            border-top:1px solid #1e293b;
            padding-top:20px;
        ">


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
                        Type
                    </div>

                    <div style="
                        margin-top:5px;
                        font-weight:600;
                    ">

                        {{ strtoupper(
                            $transaction->type
                        ) }}

                    </div>

                </div>


                <div>

                    <div style="
                        color:#64748b;
                        font-size:11px;
                    ">
                        Date
                    </div>

                    <div style="
                        margin-top:5px;
                    ">

                        {{ $transaction->created_at?->format(
                            'd M Y H:i:s'
                        ) }}

                    </div>

                </div>


                <div>

                    <div style="
                        color:#64748b;
                        font-size:11px;
                    ">
                        Balance Before
                    </div>

                    <div style="
                        margin-top:5px;
                    ">

                        {{ number_format(
                            $transaction->balance_before,
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
                        Balance After
                    </div>

                    <div style="
                        margin-top:5px;
                        color:#34d399;
                        font-weight:700;
                    ">

                        {{ number_format(
                            $transaction->balance_after,
                            0,
                            ',',
                            '.'
                        ) }}

                    </div>

                </div>


                <div style="
                    grid-column:1/-1;
                ">

                    <div style="
                        color:#64748b;
                        font-size:11px;
                    ">
                        Description
                    </div>

                    <div style="
                        margin-top:5px;
                        font-size:13px;
                    ">

                        {{ $transaction->description }}

                    </div>

                </div>


            </div>

        </div>

    </div>

</div>

@endsection
