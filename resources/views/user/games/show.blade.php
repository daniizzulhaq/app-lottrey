@extends('user.layouts.app')

@section('content')

<div style="
    min-height:100vh;
    background:#071426;
    color:#fff;
    font-family:Arial,sans-serif;
    padding-bottom:160px;
">

    {{-- =========================================================
         TOP BAR
    ========================================================== --}}

    <div style="
        height:44px;
        background:#0b1a2d;
        display:flex;
        align-items:center;
        justify-content:space-between;
        padding:0 18px;
        box-sizing:border-box;
    ">

        <a href="{{ route('dashboard') }}"
           style="
                color:white;
                text-decoration:none;
                font-size:18px;
           ">
            🏠
        </a>

        <div style="
            font-size:14px;
            font-weight:bold;
        ">
            balance:
            <span id="userBalance" style="color:#00b9e8;">
                {{ number_format(auth()->user()->balance, 2) }}
            </span>
        </div>

        <div style="
            font-size:12px;
            font-weight:bold;
        ">
            more ▼
        </div>

    </div>


    {{-- =========================================================
         GAME HEADER
    ========================================================== --}}

    <div style="
        margin:8px;
        background:#0d1d31;
        border-radius:8px;
        padding:10px;
    ">

        <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
        ">

            {{-- Recent Draw --}}

            <div style="
                flex:1;
                min-width:250px;
                text-align:center;
            ">

                <div style="
                    font-size:14px;
                    font-weight:bold;
                    margin-bottom:7px;
                ">
                    Recent draws
                </div>

                <div style="
                    display:flex;
                    justify-content:center;
                    gap:4px;
                ">

                    @forelse($recentDraws->first()?->result ?? [] as $number)

                        <span style="
                            width:25px;
                            height:25px;
                            background:#0799bd;
                            border-radius:50%;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            font-size:13px;
                            font-weight:bold;
                        ">
                            {{ $number }}
                        </span>

                    @empty

                        @for($i = 0; $i < 5; $i++)

                            <span style="
                                width:25px;
                                height:25px;
                                background:#0799bd;
                                border-radius:50%;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                            ">
                                -
                            </span>

                        @endfor

                    @endforelse

                </div>

            </div>


            {{-- Draw Information --}}

            <div style="
                min-width:250px;
                padding:8px 20px;
            ">

                <div style="
                    color:#8da1b8;
                    font-size:13px;
                ">
                    {{ $draw?->draw_number ?? '-' }}
                </div>

                <div id="countdown"
                     style="
                        color:#00b9e8;
                        font-size:18px;
                        font-weight:bold;
                        margin-top:3px;
                     ">
                    00:00:00
                </div>

            </div>

        </div>

        <div style="
            text-align:center;
            color:#fff;
            margin-top:8px;
            font-size:18px;
        ">
            ⌄
        </div>

    </div>


    {{-- =========================================================
         GAME AREA
    ========================================================== --}}

    <form
        id="gameForm"
        action="{{ route('games.play', $game) }}"
        method="POST"
        style="
            padding-bottom:160px;
            box-sizing:border-box;
        "
    >

        @csrf


        {{-- Draw ID --}}

        <input
            type="hidden"
            name="draw_id"
            id="drawId"
            value="{{ $draw?->id }}"
        >


        {{-- Selection JSON --}}

        <input
            type="hidden"
            name="selection_json"
            id="selectionJson"
        >


        {{-- =====================================================
             BALL SECTIONS
        ====================================================== --}}

        @php

            $sections = [
                'first_ball'  => 'First ball',
                'second_ball' => 'Second ball',
                'third_ball'  => 'Third ball',
                'fourth_ball' => 'Fourth ball',
                'fifth_ball'  => 'Fifth ball',
                'sum'         => 'SUM',
            ];

        @endphp


        @foreach($sections as $key => $title)

            <div
                class="bet-section"
                data-section="{{ $key }}"
                style="
                    margin:8px;
                    background:#0d1d31;
                    border-radius:8px;
                    padding:8px;
                "
            >

                <div style="
                    text-align:center;
                    color:#a9b8ca;
                    font-size:14px;
                    margin-bottom:8px;
                ">
                    {{ $title }}
                </div>


                {{-- 4 PILIHAN --}}

                <div style="
                    display:grid;
                    grid-template-columns:repeat(4,1fr);
                    gap:8px;
                ">

                    @foreach(['big','small','single','double'] as $option)

                        <button
                            type="button"
                            class="bet-option"
                            data-section="{{ $key }}"
                            data-option="{{ $option }}"
                            onclick="selectBet(this)"
                            style="
                                min-height:44px;
                                border:0;
                                border-radius:5px;
                                background:#455269;
                                color:white;
                                cursor:pointer;
                                font-weight:bold;
                                font-size:17px;
                            "
                        >

                            <div>
                                {{ $option }}
                            </div>

                            <small
                                class="rate"
                                style="
                                    color:#b8c5d4;
                                    font-size:11px;
                                "
                            >
                                1.98
                            </small>

                        </button>

                    @endforeach

                </div>

            </div>

        @endforeach


        {{-- =====================================================
             BET SUMMARY
        ====================================================== --}}

        <div style="
            margin:8px;
            background:#0d1d31;
            border-radius:8px;
            padding:15px;
        ">

            <div style="
                display:flex;
                justify-content:space-between;
                margin-bottom:10px;
                color:#b9c6d5;
            ">

                <span>
                    Selected
                </span>

                <strong id="selectedCount">
                    0
                </strong>

            </div>


            <div style="
                display:flex;
                justify-content:space-between;
                margin-bottom:10px;
            ">

                <span>
                    Total Bet
                </span>

                <strong
                    id="totalBet"
                    style="color:#00b9e8;"
                >
                    0
                </strong>

            </div>

        </div>


        {{-- =====================================================
             AMOUNT BAR
        ====================================================== --}}

        <div style="
            position:fixed;
            bottom:68px;
            left:8px;
            right:8px;
            min-height:58px;
            background:#07111f;
            border:1px solid #26364c;
            border-radius:10px;
            display:flex;
            align-items:center;
            gap:6px;
            padding:6px;
            box-sizing:border-box;
            z-index:900;
            box-shadow:0 -4px 15px rgba(0,0,0,.35);
        ">


            {{-- Amount Input --}}

            <input
                type="number"
                id="amount"
                name="amount"
                min="1"
                placeholder="amount"
                style="
                    width:60px;
                    height:30px;
                    box-sizing:border-box;
                    border:1px solid #aaa;
                    border-radius:3px;
                    padding:5px;
                    font-size:12px;
                "
            >


            {{-- Amount Buttons --}}

            @foreach([10,50,100,500,1000,5000] as $value)

                <button
                    type="button"
                    onclick="setAmount({{ $value }})"
                    style="
                        width:38px;
                        height:38px;
                        border-radius:50%;
                        border:2px solid #ddd;
                        background:#e5e7eb;
                        color:#111;
                        font-size:10px;
                        font-weight:bold;
                        cursor:pointer;
                    "
                >

                    @if($value >= 1000)

                        {{ $value / 1000 }}K

                    @else

                        {{ $value }}

                    @endif

                </button>

            @endforeach


            <div style="flex:1;"></div>


            {{-- Empty --}}

            <button
                type="button"
                onclick="clearBets()"
                style="
                    height:32px;
                    background:#354459;
                    color:white;
                    border:0;
                    border-radius:4px;
                    padding:0 8px;
                    font-size:11px;
                    cursor:pointer;
                "
            >
                empty
            </button>


            {{-- Determine --}}

            <button
                type="submit"
                id="determineButton"
                style="
                    height:32px;
                    background:#0799bd;
                    color:white;
                    border:0;
                    border-radius:4px;
                    padding:0 9px;
                    font-size:11px;
                    font-weight:bold;
                    cursor:pointer;
                "
            >
                determine
            </button>

        </div>

    </form>

</div>


{{-- =============================================================
     JAVASCRIPT
============================================================= --}}

<script>

    /*
    |--------------------------------------------------------------------------
    | Game Configuration
    |--------------------------------------------------------------------------
    */

    const gameConfiguration =
        @json($game->configuration ?? []);


    const normalRate =
        Number(
            gameConfiguration.normal_rate ?? 1.98
        );


    const specialRate =
        Number(
            gameConfiguration.special_rate ?? 2.10
        );


    const specialTimes =
        gameConfiguration.special_times ?? [
            '14:30',
            '20:00'
        ];


    const specialDuration =
        Number(
            gameConfiguration.special_duration ?? 15
        );


    const minimumBet =
        Number(
            gameConfiguration.minimum_bet ?? 10
        );


    const maximumBet =
        Number(
            gameConfiguration.maximum_bet ?? 1000000
        );


    /*
    |--------------------------------------------------------------------------
    | Selected Bets
    |--------------------------------------------------------------------------
    */

    let selectedBets = {};


    /*
    |--------------------------------------------------------------------------
    | Select Bet
    |--------------------------------------------------------------------------
    */

    function selectBet(button)
    {
        const section =
            button.dataset.section;

        const option =
            button.dataset.option;

        const key =
            section + '_' + option;


        /*
        |--------------------------------------------------------------------------
        | Jika sudah dipilih,
        | klik lagi untuk membatalkan.
        |--------------------------------------------------------------------------
        */

        if (selectedBets[key]) {

            delete selectedBets[key];

            button.style.background =
                '#455269';

        } else {

            selectedBets[key] = {

                section:
                    section,

                option:
                    option,

                amount:
                    0,

            };


            button.style.background =
                '#0799bd';
        }


        updateSummary();
    }


    /*
    |--------------------------------------------------------------------------
    | Amount
    |--------------------------------------------------------------------------
    */

    function setAmount(value)
    {
        document.getElementById('amount').value =
            value;

        updateSummary();
    }


    /*
    |--------------------------------------------------------------------------
    | Clear
    |--------------------------------------------------------------------------
    */

    function clearBets()
    {
        selectedBets = {};

        document
            .querySelectorAll('.bet-option')
            .forEach(button => {

                button.style.background =
                    '#455269';

            });


        document.getElementById('amount').value =
            '';

        updateSummary();
    }


    /*
    |--------------------------------------------------------------------------
    | Update Summary
    |--------------------------------------------------------------------------
    */

    function updateSummary()
    {
        const amount =
            Number(
                document.getElementById('amount').value
            ) || 0;


        const selected =
            Object.keys(selectedBets);


        /*
        |--------------------------------------------------------------------------
        | Set amount ke setiap pilihan.
        |--------------------------------------------------------------------------
        */

        selected.forEach(key => {

            selectedBets[key].amount =
                amount;

        });


        /*
        |--------------------------------------------------------------------------
        | Total bet.
        |--------------------------------------------------------------------------
        */

        const total =
            selected.length * amount;


        document.getElementById(
            'selectedCount'
        ).innerText =
            selected.length;


        document.getElementById(
            'totalBet'
        ).innerText =
            total.toLocaleString('id-ID');
    }


    /*
    |--------------------------------------------------------------------------
    | Rate Mode
    |--------------------------------------------------------------------------
    */

    function isSpecialTime()
    {
        const now =
            new Date();


        const currentMinutes =
            now.getHours() * 60 +
            now.getMinutes();


        for (const time of specialTimes) {

            const parts =
                time.split(':');


            const hour =
                Number(parts[0]);


            const minute =
                Number(parts[1]);


            const start =
                hour * 60 +
                minute;


            const end =
                start +
                specialDuration;


            if (
                currentMinutes >= start &&
                currentMinutes < end
            ) {

                return true;

            }

        }


        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | Update Rate
    |--------------------------------------------------------------------------
    */

    function updateRate()
    {
        const special =
            isSpecialTime();


        const rate =
            special
                ? specialRate
                : normalRate;


        /*
        |--------------------------------------------------------------------------
        | Update semua rate
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll('.rate')
            .forEach(element => {

                element.innerText =
                    rate.toFixed(2);

            });


        /*
        |--------------------------------------------------------------------------
        | PENTING
        |
        | Semua pilihan selalu ditampilkan:
        |
        | Big
        | Small
        | Single
        | Double
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll('.bet-option')
            .forEach(button => {

                button.style.display =
                    'block';

            });


        /*
        |--------------------------------------------------------------------------
        | Tidak ada lagi penghapusan single/double
        |--------------------------------------------------------------------------
        */

        updateSummary();
    }


    /*
    |--------------------------------------------------------------------------
    | Countdown Draw
    |--------------------------------------------------------------------------
    */

    function updateCountdown()
    {
        @if($draw)

            const endTime =
                new Date(
                    "{{ $draw->end_time->format('Y-m-d H:i:s') }}"
                );


            /*
            |--------------------------------------------------------------------------
            | Laravel time dianggap local.
            |--------------------------------------------------------------------------
            */

            const now =
                new Date();


            const diff =
                endTime.getTime() -
                now.getTime();


            if (diff <= 0) {

                document.getElementById(
                    'countdown'
                ).innerText =
                    '00:00:00';


                document.getElementById(
                    'determineButton'
                ).disabled =
                    true;


                return;
            }


            const totalSeconds =
                Math.floor(
                    diff / 1000
                );


            const hours =
                Math.floor(
                    totalSeconds / 3600
                );


            const minutes =
                Math.floor(
                    (totalSeconds % 3600) / 60
                );


            const seconds =
                totalSeconds % 60;


            document.getElementById(
                'countdown'
            ).innerText =

                String(hours).padStart(2,'0')
                + ':'
                +
                String(minutes).padStart(2,'0')
                + ':'
                +
                String(seconds).padStart(2,'0');

        @else

            document.getElementById(
                'countdown'
            ).innerText =
                'NO DRAW';

        @endif
    }


    /*
    |--------------------------------------------------------------------------
    | Submit
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('gameForm')
        .addEventListener(
            'submit',
            function(event) {

                const drawId =
                    document.getElementById(
                        'drawId'
                    )?.value;


                if (!drawId) {

                    event.preventDefault();

                    alert(
                        'Draw belum tersedia. Silakan refresh halaman.'
                    );

                    return;
                }


                const amount =
                    Number(
                        document.getElementById(
                            'amount'
                        ).value
                    ) || 0;


                const selected =
                    Object.values(
                        selectedBets
                    );


                if (selected.length === 0) {

                    event.preventDefault();

                    alert(
                        'Please select the bet content'
                    );

                    return;
                }


                if (amount <= 0) {

                    event.preventDefault();

                    alert(
                        'Please set the bet amount'
                    );

                    return;
                }


                if (amount < minimumBet) {

                    event.preventDefault();

                    alert(
                        'Minimum bet: ' +
                        minimumBet
                    );

                    return;
                }


                if (amount > maximumBet) {

                    event.preventDefault();

                    alert(
                        'Maximum bet: ' +
                        maximumBet
                    );

                    return;
                }


                const total =
                    selected.length *
                    amount;


                const balance =
                    Number(
                        "{{ auth()->user()->balance }}"
                    );


                if (total > balance) {

                    event.preventDefault();

                    alert(
                        'Insufficient account balance'
                    );

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Buat selection.
                |--------------------------------------------------------------------------
                */

                const selection = {};


                selected.forEach(bet => {

                    /*
                    |--------------------------------------------------------------------------
                    | Jika ada lebih dari satu pilihan pada section yang sama,
                    | gunakan array.
                    |--------------------------------------------------------------------------
                    */

                    if (!selection[bet.section]) {

                        selection[bet.section] =
                            bet.option;

                    } else {

                        if (
                            !Array.isArray(
                                selection[bet.section]
                            )
                        ) {

                            selection[bet.section] = [
                                selection[bet.section]
                            ];

                        }

                        selection[bet.section].push(
                            bet.option
                        );

                    }

                });


                /*
                |--------------------------------------------------------------------------
                | Input selection untuk controller.
                |--------------------------------------------------------------------------
                */

                let selectionInput =
                    document.querySelector(
                        'input[name="selection"]'
                    );


                if (!selectionInput) {

                    selectionInput =
                        document.createElement(
                            'input'
                        );


                    selectionInput.type =
                        'hidden';


                    selectionInput.name =
                        'selection';


                    this.appendChild(
                        selectionInput
                    );
                }


                selectionInput.value =
                    JSON.stringify(
                        selection
                    );


                /*
                |--------------------------------------------------------------------------
                | Backup selection_json.
                |--------------------------------------------------------------------------
                */

                const selectionJson =
                    document.getElementById(
                        'selectionJson'
                    );


                if (selectionJson) {

                    selectionJson.value =
                        JSON.stringify(
                            selection
                        );

                }

            }
        );


    /*
    |--------------------------------------------------------------------------
    | Amount Change
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('amount')
        .addEventListener(
            'input',
            updateSummary
        );


    /*
    |--------------------------------------------------------------------------
    | Start
    |--------------------------------------------------------------------------
    */

    updateRate();

    updateCountdown();


    /*
    |--------------------------------------------------------------------------
    | Interval Countdown
    |--------------------------------------------------------------------------
    */

    setInterval(
        updateCountdown,
        1000
    );


    /*
    |--------------------------------------------------------------------------
    | Interval Rate
    |--------------------------------------------------------------------------
    */

    setInterval(
        updateRate,
        1000
    );

</script>

@endsection
