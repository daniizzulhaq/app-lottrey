@extends('admin.layouts.app')

@section('content')

<div style="padding:24px;">

    {{-- HEADER --}}

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
                Draw {{ $draw->draw_number }}
            </h1>

            <p style="color:#64748b;">
                {{ $draw->game->name }}
            </p>

        </div>

        <a
            href="{{ route('admin.draws.index') }}"
            style="
                background:#334155;
                color:#fff;
                padding:10px 15px;
                border-radius:8px;
                text-decoration:none;
            "
        >
            ← Kembali
        </a>

    </div>


    {{-- SUCCESS --}}

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


    {{-- ERROR --}}

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


    {{-- VALIDATION ERROR --}}

    @if($errors->any())

        <div style="
            background:#7f1d1d;
            color:#fecaca;
            padding:14px;
            border-radius:10px;
            margin-bottom:20px;
        ">

            <ul style="
                margin:0;
                padding-left:20px;
            ">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- GRID --}}

    <div style="
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:20px;
    ">


        {{-- DRAW INFORMATION --}}

        <div style="
            background:#111827;
            padding:25px;
            border-radius:16px;
        ">

            <h2 style="
                color:#fff;
                margin-top:0;
            ">
                Draw Information
            </h2>


            <div style="margin-bottom:15px;">

                <span style="color:#64748b;">
                    Game
                </span>

                <div style="
                    color:#fff;
                    margin-top:5px;
                ">
                    {{ $draw->game->name }}
                </div>

            </div>


            <div style="margin-bottom:15px;">

                <span style="color:#64748b;">
                    Draw Number
                </span>

                <div style="
                    color:#fff;
                    margin-top:5px;
                ">
                    {{ $draw->draw_number }}
                </div>

            </div>


            <div style="margin-bottom:15px;">

                <span style="color:#64748b;">
                    Start
                </span>

                <div style="
                    color:#fff;
                    margin-top:5px;
                ">
                    {{ $draw->start_time }}
                </div>

            </div>


            <div style="margin-bottom:15px;">

                <span style="color:#64748b;">
                    End
                </span>

                <div style="
                    color:#fff;
                    margin-top:5px;
                ">
                    {{ $draw->end_time }}
                </div>

            </div>


            <div style="margin-bottom:20px;">

                <span style="color:#64748b;">
                    Status
                </span>

                <div style="
                    color:#60a5fa;
                    margin-top:5px;
                    font-weight:bold;
                ">
                    {{ strtoupper($draw->status) }}
                </div>

            </div>


            {{-- ACTION --}}

            <div style="
                display:flex;
                gap:10px;
                flex-wrap:wrap;
            ">

                @if($draw->status === 'upcoming')

                    <form
                        action="{{ route('admin.draws.open',$draw) }}"
                        method="POST"
                    >

                        @csrf

                        <button
                            type="submit"
                            style="
                                background:#059669;
                                color:#fff;
                                border:0;
                                padding:11px 18px;
                                border-radius:8px;
                                cursor:pointer;
                                font-weight:bold;
                            "
                        >
                            Open Draw
                        </button>

                    </form>

                @endif


                @if($draw->status === 'open')

                    <form
                        action="{{ route('admin.draws.close',$draw) }}"
                        method="POST"
                    >

                        @csrf

                        <button
                            type="submit"
                            style="
                                background:#dc2626;
                                color:#fff;
                                border:0;
                                padding:11px 18px;
                                border-radius:8px;
                                cursor:pointer;
                                font-weight:bold;
                            "
                        >
                            Close Draw
                        </button>

                    </form>

                @endif

            </div>

        </div>


        {{-- RESULT --}}

        <div style="
            background:#111827;
            padding:25px;
            border-radius:16px;
        ">

            <h2 style="
                color:#fff;
                margin-top:0;
            ">
                Draw Result
            </h2>


            @if($draw->result)

                @php

                    $numbers = is_array($draw->result)
                        ? array_map('intval', $draw->result)
                        : [];

                    $total = array_sum($numbers);

                    /*
                     * BIG / SMALL
                     */
                    $sizeResult =
                        $total >= 23
                            ? 'BIG'
                            : 'SMALL';

                    /*
                     * SINGLE / DOUBLE
                     */
                    $parityResult =
                        $total % 2 === 0
                            ? 'DOUBLE'
                            : 'SINGLE';

                @endphp


                {{-- 5 ANGKA --}}

                <div style="
                    display:flex;
                    gap:10px;
                    margin-bottom:20px;
                    flex-wrap:wrap;
                ">

                    @foreach($numbers as $number)

                        <div style="
                            width:55px;
                            height:55px;
                            border-radius:50%;
                            background:#1d4ed8;
                            color:#fff;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            font-size:22px;
                            font-weight:bold;
                        ">
                            {{ $number }}
                        </div>

                    @endforeach

                </div>


                {{-- TOTAL --}}

                <div style="
                    background:#1e293b;
                    padding:15px;
                    border-radius:10px;
                    margin-bottom:12px;
                ">

                    <div style="
                        color:#64748b;
                        font-size:13px;
                    ">
                        Total
                    </div>

                    <div style="
                        color:#fff;
                        font-size:25px;
                        font-weight:bold;
                        margin-top:5px;
                    ">
                        {{ $total }}
                    </div>

                </div>


                {{-- 4 RESULT --}}

                <div style="
                    display:grid;
                    grid-template-columns:1fr 1fr;
                    gap:12px;
                ">

                    {{-- BIG --}}

                    <div style="
                        background:#1e293b;
                        padding:15px;
                        border-radius:10px;
                    ">

                        <div style="
                            color:#64748b;
                            font-size:13px;
                        ">
                            Big
                        </div>

                        <div style="
                            color:#6ee7b7;
                            font-size:22px;
                            font-weight:bold;
                            margin-top:5px;
                        ">
                            {{ $sizeResult === 'BIG' ? '✓ MENANG' : '✗ KALAH' }}
                        </div>

                    </div>


                    {{-- SMALL --}}

                    <div style="
                        background:#1e293b;
                        padding:15px;
                        border-radius:10px;
                    ">

                        <div style="
                            color:#64748b;
                            font-size:13px;
                        ">
                            Small
                        </div>

                        <div style="
                            color:#fcd34d;
                            font-size:22px;
                            font-weight:bold;
                            margin-top:5px;
                        ">
                            {{ $sizeResult === 'SMALL' ? '✓ MENANG' : '✗ KALAH' }}
                        </div>

                    </div>


                    {{-- SINGLE --}}

                    <div style="
                        background:#1e293b;
                        padding:15px;
                        border-radius:10px;
                    ">

                        <div style="
                            color:#64748b;
                            font-size:13px;
                        ">
                            Single
                        </div>

                        <div style="
                            color:#60a5fa;
                            font-size:22px;
                            font-weight:bold;
                            margin-top:5px;
                        ">
                            {{ $parityResult === 'SINGLE' ? '✓ MENANG' : '✗ KALAH' }}
                        </div>

                    </div>


                    {{-- DOUBLE --}}

                    <div style="
                        background:#1e293b;
                        padding:15px;
                        border-radius:10px;
                    ">

                        <div style="
                            color:#64748b;
                            font-size:13px;
                        ">
                            Double
                        </div>

                        <div style="
                            color:#c084fc;
                            font-size:22px;
                            font-weight:bold;
                            margin-top:5px;
                        ">
                            {{ $parityResult === 'DOUBLE' ? '✓ MENANG' : '✗ KALAH' }}
                        </div>

                    </div>

                </div>


                {{-- KETERANGAN --}}

                <div style="
                    background:#0f172a;
                    padding:15px;
                    border-radius:10px;
                    margin-top:15px;
                    color:#94a3b8;
                    font-size:13px;
                    line-height:1.7;
                ">

                    <div>
                        Total:
                        <strong style="color:#fff;">
                            {{ $total }}
                        </strong>
                    </div>

                    <div>
                        Size:
                        <strong style="color:#6ee7b7;">
                            {{ $sizeResult }}
                        </strong>
                    </div>

                    <div>
                        Parity:
                        <strong style="color:#60a5fa;">
                            {{ $parityResult }}
                        </strong>
                    </div>

                </div>


                <div style="
                    color:#6ee7b7;
                    margin-top:15px;
                ">
                    Result sudah diproses dan bet sudah diselesaikan.
                </div>


            @else

                {{-- FORM INPUT RESULT --}}

                <form
                    action="{{ route('admin.draws.result',$draw) }}"
                    method="POST"
                >

                    @csrf


                    <p style="color:#94a3b8;">
                        Masukkan 5 angka hasil draw.
                    </p>


                    <div style="
                        display:grid;
                        grid-template-columns:repeat(5,1fr);
                        gap:10px;
                        margin-bottom:20px;
                    ">

                        @for($i = 0; $i < 5; $i++)

                            <input
                                type="number"
                                name="result[]"
                                min="0"
                                max="9"
                                required
                                placeholder="{{ $i + 1 }}"
                                value="{{ old('result.' . $i) }}"
                                style="
                                    width:100%;
                                    padding:15px 5px;
                                    text-align:center;
                                    background:#1e293b;
                                    color:#fff;
                                    border:1px solid #334155;
                                    border-radius:8px;
                                    font-size:20px;
                                "
                            >

                        @endfor

                    </div>


                    {{-- ATURAN --}}

                    <div style="
                        background:#1e293b;
                        color:#94a3b8;
                        padding:12px;
                        border-radius:8px;
                        margin-bottom:20px;
                        font-size:13px;
                        line-height:1.7;
                    ">

                        <strong style="color:#fff;">
                            Aturan Result:
                        </strong>

                        <br>

                        Total 0–22 =
                        <strong style="color:#fcd34d;">
                            SMALL
                        </strong>

                        <br>

                        Total 23–45 =
                        <strong style="color:#6ee7b7;">
                            BIG
                        </strong>

                        <br>

                        Total ganjil =
                        <strong style="color:#60a5fa;">
                            SINGLE
                        </strong>

                        <br>

                        Total genap =
                        <strong style="color:#c084fc;">
                            DOUBLE
                        </strong>

                    </div>


                    @if(
                        in_array(
                            $draw->status,
                            ['open','closed']
                        )
                    )

                        <button
                            type="submit"
                            style="
                                width:100%;
                                background:#2563eb;
                                color:#fff;
                                border:0;
                                padding:13px;
                                border-radius:8px;
                                cursor:pointer;
                                font-weight:bold;
                            "
                        >
                            Simpan & Proses Result
                        </button>

                    @else

                        <div style="
                            background:#422006;
                            color:#fcd34d;
                            padding:12px;
                            border-radius:8px;
                        ">
                            Draw harus Open atau Closed untuk
                            memasukkan result.
                        </div>

                    @endif

                </form>

            @endif

        </div>

    </div>


    {{-- BET LIST --}}

    <div style="
        margin-top:20px;
        background:#111827;
        border-radius:16px;
        padding:20px;
    ">

        <h2 style="color:#fff;">
            Game Bets
        </h2>


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
                            User
                        </th>

                        <th style="padding:12px;text-align:left;">
                            Amount
                        </th>

                        <th style="padding:12px;text-align:left;">
                            Selection
                        </th>

                        <th style="padding:12px;text-align:left;">
                            Status
                        </th>

                        <th style="padding:12px;text-align:left;">
                            Win
                        </th>

                    </tr>

                </thead>


                <tbody>

                @forelse($draw->bets as $bet)

                    <tr style="
                        border-top:1px solid #1e293b;
                        color:#e2e8f0;
                    ">

                        <td style="padding:12px;">
                            {{ $bet->user->name }}
                        </td>


                        <td style="padding:12px;">

                            {{ number_format(
                                $bet->amount,
                                0,
                                ',',
                                '.'
                            ) }}

                        </td>


                        <td style="padding:12px;">

                            @php

                                $selection =
                                    $bet->selection;

                                $selectedType =
                                    is_array($selection)
                                        ? ($selection['type'] ?? '-')
                                        : '-';

                            @endphp

                            <span style="
                                background:#1e3a8a;
                                color:#fff;
                                padding:6px 10px;
                                border-radius:7px;
                                font-weight:bold;
                            ">
                                {{ strtoupper($selectedType) }}
                            </span>

                        </td>


                        <td style="padding:12px;">

                            @if($bet->status === 'won')

                                <span style="
                                    background:#064e3b;
                                    color:#6ee7b7;
                                    padding:6px 10px;
                                    border-radius:7px;
                                ">
                                    WON
                                </span>

                            @elseif($bet->status === 'lost')

                                <span style="
                                    background:#7f1d1d;
                                    color:#fecaca;
                                    padding:6px 10px;
                                    border-radius:7px;
                                ">
                                    LOST
                                </span>

                            @else

                                <span style="
                                    background:#422006;
                                    color:#fcd34d;
                                    padding:6px 10px;
                                    border-radius:7px;
                                ">
                                    PENDING
                                </span>

                            @endif

                        </td>


                        <td style="
                            padding:12px;
                            color:#6ee7b7;
                        ">

                            {{ number_format(
                                $bet->win_amount ?? 0,
                                0,
                                ',',
                                '.'
                            ) }}

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
                            Belum ada bet pada draw ini.
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
