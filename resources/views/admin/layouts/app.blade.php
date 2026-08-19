<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Admin Panel')
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

        /* ================================
           LAYOUT
        ================================= */

        .admin-wrapper {
            min-height: 100vh;
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }

        .content {
            padding: 30px;
        }


        /* ================================
           SIDEBAR
        ================================= */

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100vh;
            background: #0f172a;
            border-right: 1px solid #1e293b;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .sidebar-logo {
            height: 80px;
            padding: 20px;
            border-bottom: 1px solid #1e293b;
            display: flex;
            align-items: center;
        }

        .sidebar-logo h1 {
            font-size: 20px;
            font-weight: 700;
        }

        .sidebar-logo span {
            color: #3b82f6;
        }

        .sidebar-logo p {
            margin-top: 4px;
            font-size: 11px;
            color: #64748b;
        }

        .sidebar-menu {
            padding: 20px 14px;
            flex: 1;
            overflow-y: auto;
        }

        .menu-title {
            margin: 18px 10px 8px;
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            margin-bottom: 4px;
            border-radius: 10px;
            color: #94a3b8;
            font-size: 14px;
            transition: .2s;
        }

        .menu-item:hover {
            background: #1e293b;
            color: white;
        }

        .menu-item.active {
            background: #2563eb;
            color: white;
        }

        .menu-icon {
            width: 22px;
            text-align: center;
        }

        .sidebar-user {
            padding: 14px;
            border-top: 1px solid #1e293b;
        }

        .sidebar-user-box {
            background: #1e293b;
            padding: 12px;
            border-radius: 10px;
        }

        .sidebar-user-name {
            font-size: 13px;
            font-weight: 600;
            margin-top: 3px;
        }

        .sidebar-user-role {
            font-size: 11px;
            color: #60a5fa;
            margin-top: 3px;
        }


        /* ================================
           NAVBAR
        ================================= */

        .navbar {
            height: 80px;
            background: rgba(2, 6, 23, .95);
            border-bottom: 1px solid #1e293b;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .navbar-title h2 {
            font-size: 18px;
        }

        .navbar-title p {
            margin-top: 4px;
            font-size: 12px;
            color: #64748b;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .admin-name {
            font-size: 13px;
            font-weight: 600;
        }

        .admin-role {
            font-size: 11px;
            color: #64748b;
            margin-top: 3px;
        }

        .logout-btn {
            border: 1px solid #334155;
            background: transparent;
            color: #94a3b8;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 12px;
        }

        .logout-btn:hover {
            border-color: #ef4444;
            color: #ef4444;
        }


        /* ================================
           PAGE HEADER
        ================================= */

        .page-header {
            margin-bottom: 28px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
        }

        .page-header p {
            margin-top: 6px;
            color: #64748b;
            font-size: 14px;
        }


        /* ================================
           STATISTICS
        ================================= */

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .stat-card {
            background: #0f172a;
            border: 1px solid #1e293b;
            border-radius: 16px;
            padding: 20px;
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-label {
            color: #94a3b8;
            font-size: 13px;
        }

        .stat-number {
            margin-top: 8px;
            font-size: 28px;
            font-weight: 700;
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #1e293b;
            border-radius: 12px;
            font-size: 20px;
        }


        /* ================================
           CARDS
        ================================= */

        .card {
            background: #0f172a;
            border: 1px solid #1e293b;
            border-radius: 16px;
            overflow: hidden;
        }

        .card-header {
            padding: 20px;
            border-bottom: 1px solid #1e293b;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
        }

        .card-description {
            margin-top: 4px;
            font-size: 12px;
            color: #64748b;
        }

        .card-body {
            padding: 20px;
        }


        /* ================================
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
            background: #111827;
            color: #64748b;
            font-size: 11px;
            text-transform: uppercase;
            text-align: left;
            padding: 14px 18px;
            white-space: nowrap;
        }

        .table td {
            padding: 15px 18px;
            border-top: 1px solid #1e293b;
            font-size: 13px;
            white-space: nowrap;
        }

        .table tr:hover td {
            background: #111827;
        }


        /* ================================
           BADGE
        ================================= */

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-success {
            background: rgba(16, 185, 129, .12);
            color: #34d399;
        }

        .badge-warning {
            background: rgba(245, 158, 11, .12);
            color: #fbbf24;
        }

        .badge-danger {
            background: rgba(239, 68, 68, .12);
            color: #f87171;
        }

        .badge-info {
            background: rgba(59, 130, 246, .12);
            color: #60a5fa;
        }


        /* ================================
           BUTTON
        ================================= */

        .btn {
            border: 0;
            border-radius: 9px;
            padding: 10px 15px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: inline-block;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
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


        /* ================================
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
            border-radius: 9px;
            padding: 11px 13px;
            outline: none;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: #3b82f6;
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }


        /* ================================
           ALERT
        ================================= */

        .alert {
            padding: 13px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .alert-success {
            background: rgba(16, 185, 129, .1);
            border: 1px solid rgba(16, 185, 129, .2);
            color: #34d399;
        }

        .alert-danger {
            background: rgba(239, 68, 68, .1);
            border: 1px solid rgba(239, 68, 68, .2);
            color: #f87171;
        }


        /* ================================
           RESPONSIVE
        ================================= */

        .mobile-menu-btn {
            display: none;
            border: 0;
            background: #1e293b;
            color: white;
            padding: 9px 12px;
            border-radius: 8px;
            cursor: pointer;
        }

        @media (max-width: 1100px) {

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

        }

        @media (max-width: 768px) {

            .sidebar {
                transform: translateX(-100%);
                transition: .25s;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .content {
                padding: 18px;
            }

            .navbar {
                padding: 0 18px;
            }

            .mobile-menu-btn {
                display: block;
            }

            .navbar-title {
                display: none;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .admin-profile-info {
                display: none;
            }

        }

    </style>

    @stack('styles')
</head>

<body>

<div class="admin-wrapper">

    @include('admin.layouts.sidebar')

    <div class="main-content">

        @include('admin.layouts.navbar')

        <main class="content">

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

                    <ul style="padding-left: 18px;">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            @yield('content')

        </main>

    </div>

</div>

<script>

    function toggleSidebar() {

        const sidebar =
            document.querySelector('.sidebar');

        sidebar.classList.toggle('open');

    }

</script>

@stack('scripts')

</body>
</html>
