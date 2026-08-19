@extends('user.layouts.app')

@section('title', 'Games')

@section('content')

<div class="section" style="margin-top:10px;">

    {{-- HEADER --}}
    <div class="section-header">
        <div>
            <div class="section-title">
                Games
            </div>

            <div style="
                color:#64748b;
                font-size:11px;
                margin-top:5px;
            ">
                Pilih game lottery virtual credit.
            </div>
        </div>

        <div style="
            background:#0f172a;
            border:1px solid #1e293b;
            padding:8px 12px;
            border-radius:10px;
            font-size:11px;
        ">
            💰
            {{ number_format(
                auth()->user()->balance ?? 0,
                0,
                ',',
                '.'
            ) }}
        </div>
    </div>


    {{-- GAME GRID --}}
    <div style="
        display:grid;
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:14px;
    ">

        @forelse($games ?? [] as $game)

            <a
                href="{{ route('games.show', $game) }}"
                style="
                    text-decoration:none;
                    color:white;
                "
            >

                <div style="
                    background:#0f172a;
                    border:1px solid #1e293b;
                    border-radius:16px;
                    overflow:hidden;
                    transition:.2s;
                    height:100%;
                ">

                    {{-- BANNER --}}
                    <div style="
                        height:130px;
                        background:#172554;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        overflow:hidden;
                    ">

                        @if($game->banner)

                            <img
                                src="{{ Storage::url($game->banner) }}"
                                alt="{{ $game->name }}"
                                style="
                                    width:100%;
                                    height:100%;
                                    object-fit:cover;
                                "
                            >

                        @elseif($game->icon)

                            <img
                                src="{{ Storage::url($game->icon) }}"
                                alt="{{ $game->name }}"
                                style="
                                    width:80px;
                                    height:80px;
                                    object-fit:contain;
                                "
                            >

                        @else

                            <div style="
                                font-size:50px;
                            ">
                                🎰
                            </div>

                        @endif

                    </div>


                    {{-- CONTENT --}}
                    <div style="padding:14px;">

                        <div style="
                            display:flex;
                            justify-content:space-between;
                            align-items:center;
                            gap:8px;
                        ">

                            <div style="
                                font-size:14px;
                                font-weight:700;
                            ">

                                {{ $game->name }}

                            </div>


                            @if($game->status === 'active')

                                <span style="
                                    background:rgba(34,197,94,.12);
                                    color:#4ade80;
                                    border-radius:20px;
                                    padding:4px 7px;
                                    font-size:9px;
                                ">
                                    ACTIVE
                                </span>

                            @else

                                <span style="
                                    background:rgba(100,116,139,.12);
                                    color:#94a3b8;
                                    border-radius:20px;
                                    padding:4px 7px;
                                    font-size:9px;
                                ">
                                    OFFLINE
                                </span>

                            @endif

                        </div>


                        <div style="
                            color:#64748b;
                            font-size:10px;
                            line-height:1.5;
                            margin-top:7px;
                            min-height:30px;
                        ">

                            {{ $game->description
                                ? Str::limit(
                                    $game->description,
                                    70
                                )
                                : 'Game lottery virtual credit.' }}

                        </div>


                        <div style="
                            display:flex;
                            justify-content:space-between;
                            align-items:center;
                            margin-top:14px;
                        ">

                            <span style="
                                color:#60a5fa;
                                font-size:10px;
                            ">
                                Play Now
                            </span>

                            <span style="
                                font-size:16px;
                            ">
                                →
                            </span>

                        </div>

                    </div>

                </div>

            </a>

        @empty

            <div style="
                grid-column:1/-1;
                text-align:center;
                padding:60px 20px;
                background:#0f172a;
                border:1px solid #1e293b;
                border-radius:16px;
            ">

                <div style="
                    font-size:45px;
                    margin-bottom:15px;
                ">
                    🎰
                </div>

                <div style="
                    font-size:15px;
                    font-weight:600;
                ">
                    Belum ada game
                </div>

                <div style="
                    color:#64748b;
                    font-size:11px;
                    margin-top:5px;
                ">
                    Admin belum mengaktifkan game.
                </div>

            </div>

        @endforelse

    </div>

</div>


{{-- RESPONSIVE --}}
<style>

@media (min-width: 768px) {

    .section > div:nth-child(2) {
        grid-template-columns:repeat(4,minmax(0,1fr)) !important;
    }

}

</style>

@endsection
