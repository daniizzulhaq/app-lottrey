@extends('admin.layouts.app')

@section('content')

<div style="padding:24px;max-width:900px;margin:auto;">

    <h1 style="color:#fff;margin-bottom:25px;">
        Edit Game
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
        action="{{ route('admin.games.update',$game) }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf
        @method('PUT')

        {{-- ========================= --}}
        {{-- INFORMASI GAME --}}
        {{-- ========================= --}}

        <div style="
            background:#111827;
            padding:25px;
            border-radius:16px;
            margin-bottom:20px;
        ">

            <div style="margin-bottom:18px;">

                <label style="color:#cbd5e1;">
                    Nama Game
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name',$game->name) }}"
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

            <div style="margin-bottom:18px;">

                <label style="color:#cbd5e1;">
                    Slug
                </label>

                <input
                    type="text"
                    name="slug"
                    value="{{ old('slug',$game->slug) }}"
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

            <div style="margin-bottom:18px;">

                <label style="color:#cbd5e1;">
                    Deskripsi
                </label>

                <textarea
                    name="description"
                    rows="4"
                    style="
                        width:100%;
                        margin-top:7px;
                        padding:12px;
                        background:#1e293b;
                        color:#fff;
                        border:1px solid #334155;
                        border-radius:8px;
                    "
                >{{ old('description',$game->description) }}</textarea>

            </div>

            <div style="
                display:grid;
                grid-template-columns:1fr 1fr;
                gap:20px;
                margin-bottom:20px;
            ">

                <div>

                    <label style="color:#cbd5e1;">
                        Icon Baru
                    </label>

                    <input
                        type="file"
                        name="icon"
                        accept="image/*"
                        style="
                            width:100%;
                            margin-top:8px;
                            color:#cbd5e1;
                        "
                    >

                    @if($game->icon)

                        <img
                            src="{{ asset('storage/'.$game->icon) }}"
                            style="
                                width:70px;
                                height:70px;
                                object-fit:cover;
                                border-radius:10px;
                                margin-top:10px;
                            "
                        >

                    @endif

                </div>

                <div>

                    <label style="color:#cbd5e1;">
                        Banner Baru
                    </label>

                    <input
                        type="file"
                        name="banner"
                        accept="image/*"
                        style="
                            width:100%;
                            margin-top:8px;
                            color:#cbd5e1;
                        "
                    >

                    @if($game->banner)

                        <img
                            src="{{ asset('storage/'.$game->banner) }}"
                            style="
                                width:180px;
                                height:90px;
                                object-fit:cover;
                                border-radius:10px;
                                margin-top:10px;
                            "
                        >

                    @endif

                </div>

            </div>

            <div>

                <label style="color:#cbd5e1;">
                    Status
                </label>

                <select
                    name="status"
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

                    <option
                        value="active"
                        @selected(old('status',$game->status) === 'active')
                    >
                        Active
                    </option>

                    <option
                        value="inactive"
                        @selected(old('status',$game->status) === 'inactive')
                    >
                        Inactive
                    </option>

                </select>

            </div>

        </div>


        {{-- ========================= --}}
        {{-- GAME CONFIGURATION --}}
        {{-- ========================= --}}

        <div style="
            background:#111827;
            padding:25px;
            border-radius:16px;
            margin-bottom:20px;
        ">

            <h2 style="
                margin-top:0;
                margin-bottom:20px;
                font-size:20px;
                color:#fff;
            ">
                Game Configuration
            </h2>


            {{-- NORMAL RATE --}}
            <div style="margin-bottom:18px;">

                <label style="color:#cbd5e1;">
                    Normal Rate
                </label>

                <input
                    type="number"
                    name="configuration[normal_rate]"
                    value="{{ old(
                        'configuration.normal_rate',
                        $game->configuration['normal_rate'] ?? 1.98
                    ) }}"
                    step="0.01"
                    min="0"
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


            {{-- SPECIAL RATE --}}
            <div style="margin-bottom:18px;">

                <label style="color:#cbd5e1;">
                    Special Rate
                </label>

                <input
                    type="number"
                    name="configuration[special_rate]"
                    value="{{ old(
                        'configuration.special_rate',
                        $game->configuration['special_rate'] ?? 2.10
                    ) }}"
                    step="0.01"
                    min="0"
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


            {{-- SPECIAL TIMES --}}
            <div style="margin-bottom:18px;">

                <label style="color:#cbd5e1;">
                    Jam Special
                </label>

                @php
                    $existingTimes = old(
                        'configuration.special_times',
                        $game->configuration['special_times'] ?? ['14:30','20:00']
                    );
                @endphp

                <div style="
                    display:grid;
                    grid-template-columns:1fr 1fr;
                    gap:12px;
                    margin-top:8px;
                ">

                    <input
                        type="time"
                        name="configuration[special_times][]"
                        value="{{ $existingTimes[0] ?? '' }}"
                        required
                        style="
                            width:100%;
                            padding:12px;
                            background:#1e293b;
                            color:#fff;
                            border:1px solid #334155;
                            border-radius:8px;
                        "
                    >

                    <input
                        type="time"
                        name="configuration[special_times][]"
                        value="{{ $existingTimes[1] ?? '' }}"
                        required
                        style="
                            width:100%;
                            padding:12px;
                            background:#1e293b;
                            color:#fff;
                            border:1px solid #334155;
                            border-radius:8px;
                        "
                    >

                </div>

            </div>


            {{-- SPECIAL DURATION --}}
            <div style="margin-bottom:18px;">

                <label style="color:#cbd5e1;">
                    Durasi Special Window (Menit)
                </label>

                <input
                    type="number"
                    name="configuration[special_duration]"
                    value="{{ old(
                        'configuration.special_duration',
                        $game->configuration['special_duration'] ?? 15
                    ) }}"
                    min="1"
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


            {{-- ROUND DURATION --}}
            <div style="margin-bottom:18px;">

                <label style="color:#cbd5e1;">
                    Durasi 1 Round (Menit)
                </label>

                <input
                    type="number"
                    name="configuration[round_duration]"
                    value="{{ old(
                        'configuration.round_duration',
                        $game->configuration['round_duration'] ?? 5
                    ) }}"
                    min="1"
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


            {{-- MAX ROUND --}}
            <div style="margin-bottom:18px;">

                <label style="color:#cbd5e1;">
                    Maximum Round Special
                </label>

                <input
                    type="number"
                    name="configuration[max_rounds]"
                    value="{{ old(
                        'configuration.max_rounds',
                        $game->configuration['max_rounds'] ?? 3
                    ) }}"
                    min="1"
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


            {{-- MINIMUM BET --}}
            <div style="margin-bottom:18px;">

                <label style="color:#cbd5e1;">
                    Minimum Bet
                </label>

                <input
                    type="number"
                    name="configuration[minimum_bet]"
                    value="{{ old(
                        'configuration.minimum_bet',
                        $game->configuration['minimum_bet'] ?? 10
                    ) }}"
                    min="1"
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


            {{-- MAXIMUM BET --}}
            <div>

                <label style="color:#cbd5e1;">
                    Maximum Bet
                </label>

                <input
                    type="number"
                    name="configuration[maximum_bet]"
                    value="{{ old(
                        'configuration.maximum_bet',
                        $game->configuration['maximum_bet'] ?? 1000000
                    ) }}"
                    min="1"
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
            Update Game
        </button>

    </form>

</div>

@endsection
