@extends('admin.layouts.app')

@section('content')

<div style="padding:24px;">

    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:25px;
    ">

        <div>

            <h1 style="color:#fff;margin:0;">
                {{ $game->name }}
            </h1>

            <p style="color:#64748b;">
                Detail game dan draw.
            </p>

        </div>

        <a
            href="{{ route('admin.games.edit',$game) }}"
            style="
                background:#854d0e;
                color:#fff;
                padding:10px 16px;
                border-radius:8px;
                text-decoration:none;
            "
        >
            Edit Game
        </a>

    </div>

    <div style="
        display:grid;
        grid-template-columns:300px 1fr;
        gap:20px;
    ">

        <div style="
            background:#111827;
            padding:20px;
            border-radius:16px;
        ">

            @if($game->banner)

                <img
                    src="{{ asset('storage/'.$game->banner) }}"
                    style="
                        width:100%;
                        height:150px;
                        object-fit:cover;
                        border-radius:12px;
                        margin-bottom:15px;
                    "
                >

            @endif

            <h2 style="color:#fff;">
                {{ $game->name }}
            </h2>

            <p style="color:#94a3b8;">
                {{ $game->description ?: 'Tidak ada deskripsi.' }}
            </p>

            <div style="margin-top:15px;">

                <span style="color:#64748b;">
                    Status
                </span>

                <br>

                @if($game->status === 'active')

                    <span style="color:#6ee7b7;">
                        ACTIVE
                    </span>

                @else

                    <span style="color:#fca5a5;">
                        INACTIVE
                    </span>

                @endif

            </div>

        </div>

        <div style="
            background:#111827;
            padding:20px;
            border-radius:16px;
        ">

            <div style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                margin-bottom:20px;
            ">

                <h2 style="color:#fff;margin:0;">
                    Draw Game
                </h2>

                <a
                    href="{{ route('admin.draws.create',['game_id'=>$game->id]) }}"
                    style="
                        background:#2563eb;
                        color:#fff;
                        padding:9px 14px;
                        border-radius:8px;
                        text-decoration:none;
                    "
                >
                    + Buat Draw
                </a>

            </div>

            <div style="overflow-x:auto;">

                <table style="
                    width:100%;
                    border-collapse:collapse;
                    min-width:700px;
                ">

                    <thead>

                        <tr style="
                            background:#1e293b;
                            color:#cbd5e1;
                        ">

                            <th style="padding:12px;text-align:left;">
                                Draw
                            </th>

                            <th style="padding:12px;text-align:left;">
                                Start
                            </th>

                            <th style="padding:12px;text-align:left;">
                                End
                            </th>

                            <th style="padding:12px;text-align:left;">
                                Status
                            </th>

                            <th style="padding:12px;text-align:left;">
                                Result
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($game->draws as $draw)

                        <tr style="
                            border-top:1px solid #1e293b;
                            color:#e2e8f0;
                        ">

                            <td style="padding:12px;">

                                <a
                                    href="{{ route('admin.draws.show',$draw) }}"
                                    style="
                                        color:#60a5fa;
                                        text-decoration:none;
                                    "
                                >
                                    {{ $draw->draw_number }}
                                </a>

                            </td>

                            <td style="padding:12px;">
                                {{ $draw->start_time }}
                            </td>

                            <td style="padding:12px;">
                                {{ $draw->end_time }}
                            </td>

                            <td style="padding:12px;">
                                {{ strtoupper($draw->status) }}
                            </td>

                            <td style="padding:12px;">

                                @if(is_array($draw->result))

                                    {{ implode(' - ',$draw->result) }}

                                @elseif($draw->result)

                                    {{ $draw->result }}

                                @else

                                    -

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                style="
                                    padding:30px;
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

    </div>

</div>

@endsection
