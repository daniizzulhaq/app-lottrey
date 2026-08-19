@extends('user.layouts.app')

@section('title', 'Top Up History')

@section('content')

<div class="section" style="margin-top:10px;">

    <div class="section-header">

        <div>

            <div class="section-title">
                Riwayat Top Up
            </div>

            <div style="
                color:#64748b;
                font-size:11px;
                margin-top:5px;
            ">
                Daftar pengajuan top up kamu.
            </div>

        </div>

        <a
            href="{{ route('topup.create') }}"
            class="btn btn-primary">

            + Top Up

        </a>

    </div>


    <div class="card">

        <div class="table-wrapper">

            <table class="table">

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th></th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($topups ?? [] as $topup)

                        <tr>

                            <td>
                                #{{ $topup->id }}
                            </td>

                            <td>
                                <strong>
                                    ${{ number_format(
                                        $topup->amount,
                                        2,
                                        '.',
                                        ','
                                    ) }}
                                </strong>
                            </td>

                            <td>
                                {{ $topup->payment_method }}
                            </td>

                            <td>

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

                            </td>

                            <td>
                                {{ $topup->created_at?->format(
                                    'd/m/Y H:i'
                                ) }}
                            </td>

                            <td>

                                <a
                                    href="{{ route(
                                        'topup.show',
                                        $topup
                                    ) }}"
                                    class="btn btn-secondary">

                                    Detail

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                style="
                                    text-align:center;
                                    padding:40px;
                                    color:#64748b;
                                ">

                                Belum ada riwayat top up.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
