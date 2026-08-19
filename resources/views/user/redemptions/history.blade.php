@extends('user.layouts.app')

@section('title', 'Redeem History')

@section('content')

<div class="section" style="margin-top:10px;">

    <div class="section-header">

        <div>

            <div class="section-title">
                Riwayat Redeem
            </div>

        </div>

        <a
            href="{{ route('redeem.create') }}"
            class="btn btn-primary">

            + Redeem

        </a>

    </div>


    <div class="card">

        <div class="table-wrapper">

            <table class="table">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Amount</th>
                        <th>Destination</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th></th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($redemptions ?? [] as $redeem)

                        <tr>

                            <td>
                                #{{ $redeem->id }}
                            </td>

                            <td>
                                <strong>
                                    {{ number_format(
                                        $redeem->amount,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </strong>
                            </td>

                            <td>
                                {{ $redeem->destination }}
                            </td>

                            <td>

                                @if($redeem->status === 'pending')

                                    <span class="badge badge-warning">
                                        Pending
                                    </span>

                                @elseif(
                                    $redeem->status === 'approved'
                                    ||
                                    $redeem->status === 'completed'
                                )

                                    <span class="badge badge-success">
                                        Completed
                                    </span>

                                @else

                                    <span class="badge badge-danger">
                                        Rejected
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ $redeem->created_at?->format(
                                    'd/m/Y H:i'
                                ) }}
                            </td>

                            <td>

                                <a
                                    href="{{ route(
                                        'redeem.show',
                                        $redeem
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

                                Belum ada riwayat redeem.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
