@extends('admin.layouts.app')

@section('content')

<div style="padding:24px;">

    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:24px;
        gap:15px;
        flex-wrap:wrap;
    ">
        <div>
            <h1 style="margin:0;color:#fff;font-size:26px;">
                Game Management
            </h1>

            <p style="color:#94a3b8;margin-top:6px;">
                Kelola game lottery virtual credit.
            </p>
        </div>

        <a href="{{ route('admin.games.create') }}"
           style="
                background:#2563eb;
                color:white;
                padding:11px 18px;
                border-radius:10px;
                text-decoration:none;
                font-weight:600;
           ">
            + Tambah Game
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

    <div style="
        background:#111827;
        border-radius:16px;
        overflow:hidden;
        border:1px solid #1e293b;
    ">

        <div style="overflow-x:auto;">

            <table style="
                width:100%;
                border-collapse:collapse;
                min-width:850px;
            ">

                <thead>
                    <tr style="background:#1e293b;color:#cbd5e1;">
                        <th style="padding:15px;text-align:left;">Game</th>
                        <th style="padding:15px;text-align:left;">Slug</th>
                        <th style="padding:15px;text-align:left;">Status</th>
                        <th style="padding:15px;text-align:left;">Created</th>
                        <th style="padding:15px;text-align:right;">Action</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($games as $game)

                    <tr style="border-top:1px solid #1e293b;color:#e2e8f0;">

                        <td style="padding:15px;">

                            <div style="
                                display:flex;
                                align-items:center;
                                gap:12px;
                            ">

                                @if($game->icon)

                                    <img
                                        src="{{ asset('storage/'.$game->icon) }}"
                                        style="
                                            width:45px;
                                            height:45px;
                                            object-fit:cover;
                                            border-radius:10px;
                                        "
                                    >

                                @else

                                    <div style="
                                        width:45px;
                                        height:45px;
                                        border-radius:10px;
                                        background:#1e3a8a;
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        font-weight:bold;
                                    ">
                                        {{ strtoupper(substr($game->name,0,1)) }}
                                    </div>

                                @endif

                                <div>
                                    <strong>{{ $game->name }}</strong>

                                    <div style="
                                        color:#64748b;
                                        font-size:12px;
                                        margin-top:3px;
                                    ">
                                        ID #{{ $game->id }}
                                    </div>
                                </div>

                            </div>

                        </td>

                        <td style="padding:15px;">
                            {{ $game->slug }}
                        </td>

                        <td style="padding:15px;">

                            @if($game->status === 'active')

                                <span style="
                                    background:#064e3b;
                                    color:#6ee7b7;
                                    padding:6px 10px;
                                    border-radius:20px;
                                    font-size:12px;
                                ">
                                    ACTIVE
                                </span>

                            @else

                                <span style="
                                    background:#3f3f46;
                                    color:#d4d4d8;
                                    padding:6px 10px;
                                    border-radius:20px;
                                    font-size:12px;
                                ">
                                    INACTIVE
                                </span>

                            @endif

                        </td>

                        <td style="padding:15px;color:#94a3b8;">
                            {{ $game->created_at?->format('d M Y H:i') }}
                        </td>

                        <td style="padding:15px;text-align:right;">

                            <div style="
                                display:flex;
                                justify-content:flex-end;
                                gap:7px;
                            ">

                                <a href="{{ route('admin.games.show',$game) }}"
                                   style="
                                        background:#1e40af;
                                        color:#fff;
                                        padding:7px 11px;
                                        border-radius:7px;
                                        text-decoration:none;
                                   ">
                                    Detail
                                </a>

                                <a href="{{ route('admin.games.edit',$game) }}"
                                   style="
                                        background:#854d0e;
                                        color:#fff;
                                        padding:7px 11px;
                                        border-radius:7px;
                                        text-decoration:none;
                                   ">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.games.destroy',$game) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus game ini?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        style="
                                            background:#991b1b;
                                            color:white;
                                            border:0;
                                            padding:7px 11px;
                                            border-radius:7px;
                                            cursor:pointer;
                                        "
                                    >
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td
                            colspan="5"
                            style="
                                padding:40px;
                                text-align:center;
                                color:#64748b;
                            "
                        >
                            Belum ada game.
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div style="margin-top:20px;">
        {{ $games->links() }}
    </div>

</div>

@endsection
