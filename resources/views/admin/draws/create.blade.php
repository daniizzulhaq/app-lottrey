@extends('admin.layouts.app')

@section('content')

<div style="padding:24px;max-width:800px;margin:auto;">

    <h1 style="color:#fff;margin-bottom:25px;">
        Buat Draw
    </h1>

    @if($errors->any())

        <div style="
            background:#7f1d1d;
            color:#fecaca;
            padding:15px;
            border-radius:10px;
            margin-bottom:20px;
        ">

            <ul style="margin:0;padding-left:20px;">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form
        action="{{ route('admin.draws.store') }}"
        method="POST"
    >

        @csrf

        <div style="
            background:#111827;
            padding:25px;
            border-radius:16px;
        ">

            <div style="margin-bottom:20px;">

                <label style="color:#cbd5e1;">
                    Game
                </label>

                <select
                    name="game_id"
                    required
                    style="
                        width:100%;
                        margin-top:7px;
                        padding:12px;
                        background:#1e293b;
                        color:#fff;
                        border:1px solid #334155;
                        border-radius:8px;
                    "
                >

                    <option value="">
                        Pilih Game
                    </option>

                    @foreach($games as $game)

                        <option
                            value="{{ $game->id }}"
                            @selected(
                                old('game_id',request('game_id'))
                                == $game->id
                            )
                        >
                            {{ $game->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div style="margin-bottom:20px;">

                <label style="color:#cbd5e1;">
                    Draw Number
                </label>

                <input
                    type="text"
                    name="draw_number"
                    value="{{ old('draw_number') }}"
                    placeholder="20260817190"
                    required
                    style="
                        width:100%;
                        margin-top:7px;
                        padding:12px;
                        background:#1e293b;
                        color:#fff;
                        border:1px solid #334155;
                        border-radius:8px;
                    "
                >

            </div>

            <div style="
                display:grid;
                grid-template-columns:1fr 1fr;
                gap:20px;
                margin-bottom:25px;
            ">

                <div>

                    <label style="color:#cbd5e1;">
                        Start Time
                    </label>

                    <input
                        type="datetime-local"
                        name="start_time"
                        value="{{ old('start_time') }}"
                        required
                        style="
                            width:100%;
                            margin-top:7px;
                            padding:12px;
                            background:#1e293b;
                            color:#fff;
                            border:1px solid #334155;
                            border-radius:8px;
                        "
                    >

                </div>

                <div>

                    <label style="color:#cbd5e1;">
                        End Time
                    </label>

                    <input
                        type="datetime-local"
                        name="end_time"
                        value="{{ old('end_time') }}"
                        required
                        style="
                            width:100%;
                            margin-top:7px;
                            padding:12px;
                            background:#1e293b;
                            color:#fff;
                            border:1px solid #334155;
                            border-radius:8px;
                        "
                    >

                </div>

            </div>

            <div style="
                display:flex;
                gap:10px;
            ">

                <button
                    type="submit"
                    style="
                        background:#2563eb;
                        color:white;
                        border:0;
                        padding:12px 20px;
                        border-radius:8px;
                        cursor:pointer;
                        font-weight:bold;
                    "
                >
                    Simpan Draw
                </button>

                <a
                    href="{{ route('admin.draws.index') }}"
                    style="
                        background:#334155;
                        color:#fff;
                        padding:12px 20px;
                        border-radius:8px;
                        text-decoration:none;
                    "
                >
                    Batal
                </a>

            </div>

        </div>

    </form>

</div>

@endsection
