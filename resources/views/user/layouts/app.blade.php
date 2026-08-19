<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Lottery')
    </title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #020617;
            color: #f8fafc;
            min-height: 100vh;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button,
        input,
        select,
        textarea {
            font-family: inherit;
        }


        /* =================================
           APP CONTAINER
        ================================= */

        .user-app {
            min-height: 100vh;
            padding-bottom: 80px;
        }

        .user-container {
            width: 100%;
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }


        /* =================================
           HEADER
        ================================= */

        .user-navbar {
            height: 70px;
            background: #0f172a;
            border-bottom: 1px solid #1e293b;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 20px;

            position: sticky;
            top: 0;

            z-index: 100;
        }

        .logo {
            font-size: 20px;
            font-weight: 700;
        }

        .logo span {
            color: #3b82f6;
        }

        .profile-area {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 38px;
            height: 38px;

            border-radius: 50%;

            background: #2563eb;

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: 700;
        }

        .profile-name {
            font-size: 13px;
            font-weight: 600;
        }

        .profile-role {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
        }


        /* =================================
           BALANCE CARD
        ================================= */

        .balance-card {
            margin-top: 10px;

            background:
                linear-gradient(
                    135deg,
                    #1d4ed8,
                    #2563eb,
                    #1e40af
                );

            border-radius: 20px;

            padding: 25px;

            position: relative;

            overflow: hidden;
        }

        .balance-card::after {
            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            border-radius: 50%;

            background: rgba(255,255,255,.08);

            right: -50px;
            top: -70px;
        }

        .balance-label {
            font-size: 13px;
            color: #dbeafe;
        }

        .balance-value {
            margin-top: 8px;

            font-size: 32px;
            font-weight: 700;
        }

        .balance-credit {
            font-size: 12px;
            color: #dbeafe;
            margin-top: 5px;
        }


        /* =================================
           QUICK ACTION
        ================================= */

        .quick-actions {

            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 12px;

            margin-top: 15px;
        }

        .quick-btn {

            background: #0f172a;

            border: 1px solid #1e293b;

            border-radius: 14px;

            padding: 16px;

            display: flex;
            align-items: center;

            gap: 12px;

            transition: .2s;
        }

        .quick-btn:hover {

            border-color: #3b82f6;

            transform: translateY(-2px);

        }

        .quick-icon {

            width: 40px;
            height: 40px;

            border-radius: 10px;

            background: #1e293b;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 18px;

        }

        .quick-title {

            font-size: 13px;

            font-weight: 600;

        }

        .quick-description {

            margin-top: 3px;

            font-size: 10px;

            color: #64748b;

        }


        /* =================================
           SECTION
        ================================= */

        .section {

            margin-top: 30px;

        }

        .section-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 14px;

        }

        .section-title {

            font-size: 18px;

            font-weight: 700;

        }

        .section-link {

            color: #60a5fa;

            font-size: 12px;

        }


        /* =================================
           GAME GRID
        ================================= */

        .game-grid {

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 14px;

        }

        .game-card {

            background: #0f172a;

            border: 1px solid #1e293b;

            border-radius: 16px;

            overflow: hidden;

            transition: .2s;

        }

        .game-card:hover {

            transform: translateY(-3px);

            border-color: #2563eb;

        }

        .game-image {

            height: 130px;

            background:
                linear-gradient(
                    135deg,
                    #172554,
                    #1e3a8a
                );

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 45px;

        }

        .game-content {

            padding: 14px;

        }

        .game-name {

            font-size: 14px;

            font-weight: 600;

        }

        .game-description {

            margin-top: 5px;

            color: #64748b;

            font-size: 10px;

            line-height: 1.5;

        }

        .game-btn {

            display: block;

            text-align: center;

            margin-top: 12px;

            background: #2563eb;

            color: white;

            padding: 9px;

            border-radius: 8px;

            font-size: 12px;

            font-weight: 600;

        }


        /* =================================
           RECENT HISTORY
        ================================= */

        .history-card {

            background: #0f172a;

            border: 1px solid #1e293b;

            border-radius: 15px;

            overflow: hidden;

        }

        .history-item {

            padding: 15px;

            border-bottom: 1px solid #1e293b;

            display: flex;

            justify-content: space-between;

            align-items: center;

        }

        .history-item:last-child {

            border-bottom: 0;

        }

        .history-name {

            font-size: 13px;

            font-weight: 600;

        }

        .history-date {

            margin-top: 4px;

            font-size: 10px;

            color: #64748b;

        }

        .win {

            color: #34d399;

        }

        .lose {

            color: #f87171;

        }


        /* =================================
           CARD
        ================================= */

        .card {

            background: #0f172a;

            border: 1px solid #1e293b;

            border-radius: 16px;

            padding: 20px;

        }


        /* =================================
           FORM
        ================================= */

        .form-group {

            margin-bottom: 18px;

        }

        .form-label {

            display: block;

            margin-bottom: 7px;

            font-size: 13px;

            font-weight: 600;

        }

        .form-input,
        .form-select,
        .form-textarea {

            width: 100%;

            background: #020617;

            border: 1px solid #334155;

            color: white;

            padding: 11px 13px;

            border-radius: 9px;

            outline: none;

        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {

            border-color: #3b82f6;

        }

        .form-textarea {

            min-height: 100px;

            resize: vertical;

        }


        /* =================================
           BUTTON
        ================================= */

        .btn {

            border: 0;

            border-radius: 9px;

            padding: 11px 16px;

            font-size: 13px;

            font-weight: 600;

            cursor: pointer;

            display: inline-block;

        }

        .btn-primary {

            background: #2563eb;

            color: white;

        }

        .btn-success {

            background: #059669;

            color: white;

        }

        .btn-danger {

            background: #dc2626;

            color: white;

        }

        .btn-secondary {

            background: #1e293b;

            color: #cbd5e1;

        }


        /* =================================
           BADGE
        ================================= */

        .badge {

            display: inline-block;

            padding: 5px 10px;

            border-radius: 999px;

            font-size: 10px;

            font-weight: 600;

        }

        .badge-success {

            background: rgba(16,185,129,.12);

            color: #34d399;

        }

        .badge-warning {

            background: rgba(245,158,11,.12);

            color: #fbbf24;

        }

        .badge-danger {

            background: rgba(239,68,68,.12);

            color: #f87171;

        }


        /* =================================
           TABLE
        ================================= */

        .table-wrapper {

            overflow-x: auto;

        }

        .table {

            width: 100%;

            border-collapse: collapse;

        }

        .table th {

            padding: 13px;

            background: #111827;

            color: #64748b;

            font-size: 10px;

            text-align: left;

        }

        .table td {

            padding: 14px 13px;

            border-top: 1px solid #1e293b;

            font-size: 12px;

            white-space: nowrap;

        }


        /* =================================
           BOTTOM NAV
        ================================= */

        .bottom-nav {

            position: fixed;

            bottom: 0;

            left: 0;

            right: 0;

            height: 68px;

            background: rgba(15,23,42,.97);

            border-top: 1px solid #1e293b;

            z-index: 500;

            display: flex;

            align-items: center;

            justify-content: center;

        }

        .bottom-nav-inner {

            width: 100%;

            max-width: 700px;

            display: grid;

            grid-template-columns:
                repeat(5, 1fr);

        }

        .bottom-item {

            text-align: center;

            color: #64748b;

            font-size: 10px;

            padding: 8px;

        }

        .bottom-item.active {

            color: #60a5fa;

        }

        .bottom-icon {

            display: block;

            font-size: 18px;

            margin-bottom: 3px;

        }


        /* =================================
           ALERT
        ================================= */

        .alert {

            padding: 13px 15px;

            border-radius: 10px;

            margin-bottom: 20px;

            font-size: 12px;

        }

        .alert-success {

            background: rgba(16,185,129,.1);

            color: #34d399;

            border: 1px solid rgba(16,185,129,.2);

        }

        .alert-danger {

            background: rgba(239,68,68,.1);

            color: #f87171;

            border: 1px solid rgba(239,68,68,.2);

        }


        /* =================================
           RESPONSIVE
        ================================= */

        @media(max-width: 900px) {

            .game-grid {

                grid-template-columns:
                    repeat(3, 1fr);

            }

        }

        @media(max-width: 650px) {

            .user-container {

                padding: 14px;

            }

            .game-grid {

                grid-template-columns:
                    repeat(2, 1fr);

            }

            .game-image {

                height: 110px;

            }

            .balance-value {

                font-size: 27px;

            }

            .profile-name {

                display: none;

            }

        }

    </style>

    @stack('styles')

</head>


<body>

<div class="user-app">

    @include('user.layouts.navbar')


    <main class="user-container">

        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif


        @if(session('error'))

            <div class="alert alert-danger">
                {{ session('error') }}
            </div>

        @endif


        @if($errors->any())

            <div class="alert alert-danger">

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        @yield('content')

    </main>


    @include('user.layouts.bottom-nav')

</div>


@stack('scripts')

</body>

</html>
