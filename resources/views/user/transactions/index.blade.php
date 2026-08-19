@extends('user.layouts.app')

@section('title', 'Transactions')

@section('content')

<div class="section" style="margin-top:10px;">

    <div class="section-header">

        <div>

            <div class="section-title">
                Transaction History
            </div>

            <div style="
                color:#64748b;
                font-size:11px;
                margin-top:5px;
            ">

                Semua perubahan virtual credit akun kamu.

            </div>

        </div>

    </div>


    <div class="card">

        <div class="table-wrapper">

            <table class="table">

                <thead>

                    <tr>

                        <th>Type</th>
                        <th>Amount</th>
                        <th>Before</th>
                        <th>After</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th></th>

                    </tr>

                </thead>


                <tbody>

                    @forelse(
                        $transactions ?? []
                        as $transaction
                    )

                        <tr>

                            <td>

                                @php

                                    $type =
                                        strtoupper(
                                            $transaction->type
                                        );

                                @endphp


                                @if(
                                    in_array(
                                        $type,
                                        ['TOPUP', 'WIN', 'REFUND']
                                    )
                                )

                                    <span class="badge badge-success">
                                        {{ $type }}
                                    </span>

                                @else

                                    <span class="badge badge-danger">
                                        {{ $type }}
                                    </span>

                                @endif

                            </td>


                            <td>

                                <strong>

                                    {{ number_format(
                                        $transaction->amount,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </strong>

                            </td>


                            <td>

                                {{ number_format(
                                    $transaction->balance_before,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </td>


                            <td>

                                {{ number_format(
                                    $transaction->balance_after,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </td>


                            <td>

                                {{ $transaction->description }}

                            </td>


                            <td>

                                {{ $transaction->created_at?->format(
                                    'd/m/Y H:i'
                                ) }}

                            </td>


                            <td>

                                <a
                                    href="{{ route(
                                        'transactions.show',
                                        $transaction
                                    ) }}"
                                    class="btn btn-secondary">

                                    Detail

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                style="
                                    text-align:center;
                                    padding:40px;
                                    color:#64748b;
                                ">

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
