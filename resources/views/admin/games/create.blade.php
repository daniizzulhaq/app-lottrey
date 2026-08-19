@extends('admin.layouts.app')

@section('content')

<div style="max-width:900px;margin:auto;padding:30px;">

    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.games.index') }}"
           style="color:#38bdf8;text-decoration:none;">
            ← Kembali
        </a>
    </div>

    <h1 style="margin:0 0 25px;font-size:28px;">
        Tambah Game
    </h1>

    {{-- ERROR --}}
    @if($errors->any())

        <div style="
            background:#451a1a;
            border:1px solid #7f1d1d;
            padding:15px;
            border-radius:8px;
            margin-bottom:20px;
        ">

            <strong style="display:block;margin-bottom:8px;">
                Terjadi kesalahan:
            </strong>

            @foreach($errors->all() as $error)
                <div style="margin-bottom:4px;">
                    • {{ $error }}
                </div>
            @endforeach

        </div>

    @endif


    {{-- SUCCESS --}}
    @if(session('success'))

        <div style="
            background:#064e3b;
            border:1px solid #047857;
            padding:15px;
            border-radius:8px;
            margin-bottom:20px;
        ">
            {{ session('success') }}
        </div>

    @endif


    <form
        action="{{ route('admin.games.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf


        {{-- ========================= --}}
        {{-- INFORMASI GAME --}}
        {{-- ========================= --}}

        <div style="
            background:#0b1a2b;
            padding:25px;
            border-radius:12px;
            margin-bottom:20px;
        ">

            <h2 style="
                margin-top:0;
                margin-bottom:20px;
                font-size:20px;
            ">
                Informasi Game
            </h2>


            {{-- NAME --}}
            <label>Nama Game</label>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="5 Points Lottery"
                required
                style="
                    width:100%;
                    padding:12px;
                    margin:8px 0 18px;
                    box-sizing:border-box;
                    background:#07111f;
                    color:white;
                    border:1px solid #334155;
                    border-radius:8px;
                "
            >


            {{-- SLUG --}}
            <label>Slug</label>

            <input
                type="text"
                name="slug"
                value="{{ old('slug') }}"
                placeholder="5-points-lottery"
                style="
                    width:100%;
                    padding:12px;
                    margin:8px 0 18px;
                    box-sizing:border-box;
                    background:#07111f;
                    color:white;
                    border:1px solid #334155;
                    border-radius:8px;
                "
            >


            {{-- DESCRIPTION --}}
            <label>Deskripsi</label>

            <textarea
                name="description"
                rows="4"
                placeholder="Deskripsi game..."
                style="
                    width:100%;
                    padding:12px;
                    margin:8px 0 18px;
                    box-sizing:border-box;
                    background:#07111f;
                    color:white;
                    border:1px solid #334155;
                    border-radius:8px;
                    resize:vertical;
                "
            >{{ old('description') }}</textarea>


            {{-- STATUS --}}
            <label>Status</label>

            <select
                name="status"
                style="
                    width:100%;
                    padding:12px;
                    margin:8px 0 18px;
                    box-sizing:border-box;
                    background:#07111f;
                    color:white;
                    border:1px solid #334155;
                    border-radius:8px;
                "
            >

                <option
                    value="active"
                    {{ old('status', 'active') == 'active' ? 'selected' : '' }}
                >
                    Active
                </option>

                <option
                    value="inactive"
                    {{ old('status') == 'inactive' ? 'selected' : '' }}
                >
                    Inactive
                </option>

            </select>


            {{-- ICON --}}
            <label>Icon Game</label>

            <input
                type="file"
                name="icon"
                accept="image/jpeg,image/png,image/webp"
                style="
                    display:block;
                    margin:8px 0 18px;
                "
            >


            {{-- BANNER --}}
            <label>Banner Game</label>

            <input
                type="file"
                name="banner"
                accept="image/jpeg,image/png,image/webp"
                style="
                    display:block;
                    margin:8px 0 5px;
                "
            >

            <small style="color:#94a3b8;">
                Format JPG, PNG, WEBP.
            </small>

        </div>



        {{-- ========================= --}}
        {{-- GAME CONFIGURATION --}}
        {{-- ========================= --}}

        <div style="
            background:#0b1a2b;
            padding:25px;
            border-radius:12px;
            margin-bottom:20px;
        ">

            <h2 style="
                margin-top:0;
                margin-bottom:8px;
                font-size:20px;
            ">
                Game Configuration
            </h2>

            <p style="
                color:#94a3b8;
                font-size:14px;
                margin-bottom:25px;
            ">
                Pengaturan khusus untuk sistem 5 Points Lottery.
            </p>


            {{-- NORMAL RATE --}}
            <label>Normal Rate</label>

            <input
                type="number"
                name="configuration[normal_rate]"
                value="{{ old('configuration.normal_rate', 1.98) }}"
                step="0.01"
                min="1"
                required
                style="
                    width:100%;
                    padding:12px;
                    margin:8px 0 18px;
                    box-sizing:border-box;
                    background:#07111f;
                    color:white;
                    border:1px solid #334155;
                    border-radius:8px;
                "
            >

            <small style="
                display:block;
                color:#94a3b8;
                margin-top:-12px;
                margin-bottom:18px;
            ">
                Rate normal, contoh: 1.98
            </small>



            {{-- SPECIAL RATE --}}
            <label>Special Rate</label>

            <input
                type="number"
                name="configuration[special_rate]"
                value="{{ old('configuration.special_rate', 2.10) }}"
                step="0.01"
                min="1"
                required
                style="
                    width:100%;
                    padding:12px;
                    margin:8px 0 18px;
                    box-sizing:border-box;
                    background:#07111f;
                    color:white;
                    border:1px solid #334155;
                    border-radius:8px;
                "
            >

            <small style="
                display:block;
                color:#94a3b8;
                margin-top:-12px;
                margin-bottom:18px;
            ">
                Rate khusus saat special window aktif.
            </small>



            {{-- SPECIAL TIME --}}
            <label>Jam Special</label>

            <div style="
                display:grid;
                grid-template-columns:1fr 1fr;
                gap:12px;
                margin-top:8px;
                margin-bottom:10px;
            ">

                <input
                    type="time"
                    name="configuration[special_times][]"
                    value="{{ old(
                        'configuration.special_times.0',
                        '14:30'
                    ) }}"
                    required
                    style="
                        width:100%;
                        padding:12px;
                        box-sizing:border-box;
                        background:#07111f;
                        color:white;
                        border:1px solid #334155;
                        border-radius:8px;
                    "
                >

                <input
                    type="time"
                    name="configuration[special_times][]"
                    value="{{ old(
                        'configuration.special_times.1',
                        '20:00'
                    ) }}"
                    required
                    style="
                        width:100%;
                        padding:12px;
                        box-sizing:border-box;
                        background:#07111f;
                        color:white;
                        border:1px solid #334155;
                        border-radius:8px;
                    "
                >

            </div>

            <small style="
                display:block;
                color:#94a3b8;
                margin-bottom:20px;
            ">
                Contoh: 14:30 dan 20:00 WIB.
            </small>



            {{-- SPECIAL DURATION --}}
            <label>Durasi Special Window (Menit)</label>

            <input
                type="number"
                name="configuration[special_duration]"
                value="{{ old(
                    'configuration.special_duration',
                    15
                ) }}"
                min="1"
                required
                style="
                    width:100%;
                    padding:12px;
                    margin:8px 0 18px;
                    box-sizing:border-box;
                    background:#07111f;
                    color:white;
                    border:1px solid #334155;
                    border-radius:8px;
                "
            >

            <small style="
                display:block;
                color:#94a3b8;
                margin-top:-12px;
                margin-bottom:18px;
            ">
                Special rate aktif selama 15 menit.
            </small>



            {{-- ROUND DURATION --}}
            <label>Durasi 1 Round (Menit)</label>

            <input
                type="number"
                name="configuration[round_duration]"
                value="{{ old(
                    'configuration.round_duration',
                    5
                ) }}"
                min="1"
                required
                style="
                    width:100%;
                    padding:12px;
                    margin:8px 0 18px;
                    box-sizing:border-box;
                    background:#07111f;
                    color:white;
                    border:1px solid #334155;
                    border-radius:8px;
                "
            >

            <small style="
                display:block;
                color:#94a3b8;
                margin-top:-12px;
                margin-bottom:18px;
            ">
                Setiap putaran berlangsung 5 menit.
            </small>



            {{-- MAX ROUND --}}
            <label>Maximum Round Special</label>

            <input
                type="number"
                name="configuration[max_rounds]"
                value="{{ old(
                    'configuration.max_rounds',
                    3
                ) }}"
                min="1"
                required
                style="
                    width:100%;
                    padding:12px;
                    margin:8px 0 18px;
                    box-sizing:border-box;
                    background:#07111f;
                    color:white;
                    border:1px solid #334155;
                    border-radius:8px;
                "
            >

            <small style="
                display:block;
                color:#94a3b8;
                margin-top:-12px;
                margin-bottom:18px;
            ">
                Maksimal 3 round selama special window.
            </small>



            {{-- MINIMUM BET --}}
            <label>Minimum Bet</label>

            <input
                type="number"
                name="configuration[minimum_bet]"
                value="{{ old(
                    'configuration.minimum_bet',
                    10
                ) }}"
                min="1"
                required
                style="
                    width:100%;
                    padding:12px;
                    margin:8px 0 18px;
                    box-sizing:border-box;
                    background:#07111f;
                    color:white;
                    border:1px solid #334155;
                    border-radius:8px;
                "
            >



            {{-- MAXIMUM BET --}}
            <label>Maximum Bet</label>

            <input
                type="number"
                name="configuration[maximum_bet]"
                value="{{ old(
                    'configuration.maximum_bet',
                    1000000
                ) }}"
                min="1"
                required
                style="
                    width:100%;
                    padding:12px;
                    margin:8px 0 25px;
                    box-sizing:border-box;
                    background:#07111f;
                    color:white;
                    border:1px solid #334155;
                    border-radius:8px;
                "
            >


            {{-- SUBMIT --}}
            <button
                type="submit"
                style="
                    width:100%;
                    padding:14px;
                    border:0;
                    border-radius:8px;
                    background:#0ea5e9;
                    color:white;
                    font-size:16px;
                    cursor:pointer;
                "
            >
                Simpan Game
            </button>

        </div>

    </form>

</div>

@endsection
