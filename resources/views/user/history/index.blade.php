@extends('user.layouts.app')

@section('title', 'Game History')

@section('content')

<div class="section" style="margin-top:10px;">

    <div class="section-header">

        <div>

            <div class="section-title">
                Game History
            </div>

            <div style="
                color:#64748b;
                font-size:11px;
                margin-top:5px;
            ">

                Riwayat permainan virtual credit.

            </div>

        </div>

    </div>


    <div class="card">

        <div class="table-wrapper">

            <table class="table">

                <thead>

                    <tr>

                        <th>Game</th>
                        <th>Draw</th>
                        <th>Selection</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th></th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($bets ?? [] as $bet)

                        <tr>

                            <td>
                                {{ $bet->game->name ?? '-' }}
                            </td>

                            <td>
                                {{ $bet->draw->draw_number ?? '-' }}
                            </td>

                            <td>
                                {{ is_array($bet->selection)
                                    ? implode(', ', $bet->selection)
                                    : $bet->selection }}
                            </td>

                            <td>
                                {{ number_format(
                                    $bet->amount,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </td>

                            <td>

                                @if($bet->status === 'win')

                                    <span class="badge badge-success">
                                        WIN
                                    </span>

                                @elseif($bet->status === 'lose')

                                    <span class="badge badge-danger">
                                        LOSE
                                    </span>

                                @else

                                    <span class="badge badge-warning">
                                        {{ strtoupper(
                                            $bet->status
                                        ) }}
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ $bet->created_at?->format(
                                    'd/m/Y H:i'
                                ) }}
                            </td>

                            <td>

                                <a
                                    href="{{ route(
                                        'history.show',
                                        $bet
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

                                Belum ada permainan.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
