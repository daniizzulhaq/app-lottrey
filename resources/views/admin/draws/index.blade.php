@extends('admin.layouts.app')

@section('content')

<div style="padding:24px;">

    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:25px;
        flex-wrap:wrap;
        gap:15px;
    ">

        <div>

            <h1 style="color:#fff;margin:0;">
                Draw Management
            </h1>

            <p style="color:#64748b;">
                Kelola periode draw setiap game.
            </p>

        </div>

        <a
            href="{{ route('admin.draws.create') }}"
            style="
                background:#2563eb;
                color:#fff;
                padding:11px 17px;
                border-radius:9px;
                text-decoration:none;
                font-weight:bold;
            "
        >
            + Buat Draw
        </a>

    </div>

    @if(session('success'))

        <div style="
            background:#064e3b;
            color:#a7f3d0;
            padding:14px;
            border-radius:10px;
            margin-bottom:20px;
        ">
            {{ session('success') }}
        </div>

    @endif

    @if(session('error'))

        <div style="
            background:#7f1d1d;
            color:#fecaca;
            padding:14px;
            border-radius:10px;
            margin-bottom:20px;
        ">
            {{ session('error') }}
        </div>

    @endif

    {{-- FILTER GAME --}}

    <form method="GET" style="margin-bottom:20px;">

        <select
            name="game_id"
            onchange="this.form.submit()"
            style="
                background:#1e293b;
                color:#fff;
                border:1px solid #334155;
                padding:11px;
                border-radius:8px;
                min-width:220px;
            "
        >

            <option value="">
                Semua Game
            </option>

            @foreach($games as $game)

                <option
                    value="{{ $game->id }}"
                    @selected(request('game_id') == $game->id)
                >
                    {{ $game->name }}
                </option>

            @endforeach

        </select>

    </form>

    <div style="
        background:#111827;
        border-radius:16px;
        overflow:hidden;
    ">

        <div style="overflow-x:auto;">

            <table style="
                width:100%;
                border-collapse:collapse;
                min-width:900px;
            ">

                <thead>

                    <tr style="
                        background:#1e293b;
                        color:#cbd5e1;
                    ">

                        <th style="padding:14px;text-align:left;">
                            Draw ID
                        </th>

                        <th style="padding:14px;text-align:left;">
                            Game
                        </th>

                        <th style="padding:14px;text-align:left;">
                            Start
                        </th>

                        <th style="padding:14px;text-align:left;">
                            End
                        </th>

                        <th style="padding:14px;text-align:left;">
                            Status
                        </th>

                        <th style="padding:14px;text-align:left;">
                            Result
                        </th>

                        <th style="padding:14px;text-align:right;">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody>

                @forelse($draws as $draw)

                    <tr style="
                        border-top:1px solid #1e293b;
                        color:#e2e8f0;
                    ">

                        <td style="padding:14px;">

                            <a
                                href="{{ route('admin.draws.show',$draw) }}"
                                style="
                                    color:#60a5fa;
                                    text-decoration:none;
                                    font-weight:bold;
                                "
                            >
                                {{ $draw->draw_number }}
                            </a>

                        </td>

                        <td style="padding:14px;">
                            {{ $draw->game->name }}
                        </td>

                        <td style="padding:14px;">
                            {{ $draw->start_time }}
                        </td>

                        <td style="padding:14px;">
                            {{ $draw->end_time }}
                        </td>

                        <td style="padding:14px;">

                            @php
                                $statusColors = [
                                    'upcoming' => ['#422006','#fcd34d'],
                                    'open' => ['#064e3b','#6ee7b7'],
                                    'closed' => ['#3f3f46','#d4d4d8'],
                                    'completed' => ['#1e3a8a','#93c5fd'],
                                ];

                                $color = $statusColors[$draw->status] ?? ['#1e293b','#fff'];
                            @endphp

                            <span style="
                                background:{{ $color[0] }};
                                color:{{ $color[1] }};
                                padding:6px 10px;
                                border-radius:20px;
                                font-size:12px;
                            ">
                                {{ strtoupper($draw->status) }}
                            </span>

                        </td>

                        <td style="padding:14px;">

                            @if(is_array($draw->result))

                                {{ implode(' - ',$draw->result) }}

                            @elseif($draw->result)

                                {{ $draw->result }}

                            @else

                                -

                            @endif

                        </td>

                        <td style="padding:14px;text-align:right;">

                            <a
                                href="{{ route('admin.draws.show',$draw) }}"
                                style="
                                    background:#1e40af;
                                    color:#fff;
                                    padding:7px 11px;
                                    border-radius:7px;
                                    text-decoration:none;
                                "
                            >
                                Detail
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="7"
                            style="
                                padding:40px;
                                text-align:center;
                                color:#64748b;
                            "
                        >
                            Belum ada draw.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div style="margin-top:20px;">
        {{ $draws->links() }}
    </div>

</div>

@endsection
