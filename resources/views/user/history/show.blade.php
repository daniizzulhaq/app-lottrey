@extends('user.layouts.app')

@section('title', 'Game Detail')

@section('content')

<div class="section" style="margin-top:10px;">

    <div class="section-header">

        <div class="section-title">
            Detail Permainan
        </div>

        <a
            href="{{ route('history.index') }}"
            class="btn btn-secondary">

            Kembali

        </a>

    </div>


    <div class="card">

        <div style="
            text-align:center;
            padding:20px;
        ">

            <div style="font-size:50px;">
                🎰
            </div>

            <div style="
                font-size:20px;
                font-weight:700;
                margin-top:10px;
            ">

                {{ $gameBet->game->name ?? '-' }}

            </div>

        </div>


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
                    Draw Number
                </div>

                <div style="margin-top:5px;">
                    {{ $gameBet->draw->draw_number ?? '-' }}
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
                    font-weight:700;
                ">

                    {{ number_format(
                        $gameBet->amount,
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
                    Selection
                </div>

                <div style="
                    margin-top:5px;
                ">

                    @if(is_array($gameBet->selection))

                        {{ implode(
                            ', ',
                            $gameBet->selection
                        ) }}

                    @else

                        {{ $gameBet->selection }}

                    @endif

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

                    @if($gameBet->status === 'win')

                        <span class="badge badge-success">
                            WIN
                        </span>

                    @elseif($gameBet->status === 'lose')

                        <span class="badge badge-danger">
                            LOSE
                        </span>

                    @else

                        <span class="badge badge-warning">
                            {{ strtoupper(
                                $gameBet->status
                            ) }}
                        </span>

                    @endif

                </div>

            </div>

        </div>


        @if($gameBet->result)

            <div style="
                margin-top:25px;
                background:#020617;
                border:1px solid #1e293b;
                border-radius:12px;
                padding:20px;
                text-align:center;
            ">

                <div style="
                    color:#64748b;
                    font-size:11px;
                ">
                    Draw Result
                </div>

                <div style="
                    font-size:28px;
                    font-weight:700;
                    margin-top:8px;
                ">

                    {{ is_array($gameBet->result)
                        ? implode(
                            ' - ',
                            $gameBet->result
                        )
                        : $gameBet->result }}

                </div>

            </div>

        @endif

    </div>

</div>

@endsection
