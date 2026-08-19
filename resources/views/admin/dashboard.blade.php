@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('page-title', 'Dashboard')

@section('content')

<div class="page-header">

    <h1>
        Dashboard
    </h1>

    <p>
        Kelola sistem virtual credit lottery.
    </p>

</div>


<div class="stats-grid">

    <div class="stat-card">

        <div class="stat-top">

            <div>

                <div class="stat-label">
                    Total User
                </div>

                <div class="stat-number">
                    {{ $totalUsers ?? 0 }}
                </div>

            </div>

            <div class="stat-icon">
                👥
            </div>

        </div>

    </div>


    <div class="stat-card">

        <div class="stat-top">

            <div>

                <div class="stat-label">
                    Active User
                </div>

                <div class="stat-number">
                    {{ $activeUsers ?? 0 }}
                </div>

            </div>

            <div class="stat-icon">
                🟢
            </div>

        </div>

    </div>


    <div class="stat-card">

        <div class="stat-top">

            <div>

                <div class="stat-label">
                    Pending Top Up
                </div>

                <div class="stat-number">
                    {{ $pendingTopups ?? 0 }}
                </div>

            </div>

            <div class="stat-icon">
                💳
            </div>

        </div>

    </div>


    <div class="stat-card">

        <div class="stat-top">

            <div>

                <div class="stat-label">
                    Pending Redeem
                </div>

                <div class="stat-number">
                    {{ $pendingRedemptions ?? 0 }}
                </div>

            </div>

            <div class="stat-icon">
                💰
            </div>

        </div>

    </div>

</div>


<div style="
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:16px;
    margin-top:16px;
">

    <div class="stat-card">

        <div class="stat-label">
            Total Game
        </div>

        <div class="stat-number">
            {{ $totalGames ?? 0 }}
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-label">
            Active Draw
        </div>

        <div class="stat-number">
            {{ $activeDraws ?? 0 }}
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-label">
            Total Transaction
        </div>

        <div class="stat-number">
            {{ $totalTransactions ?? 0 }}
        </div>

    </div>

</div>


<div class="card" style="margin-top:25px;">

    <div class="card-header">

        <div>

            <div class="card-title">
                Recent Top Up
            </div>

            <div class="card-description">
                Top up terbaru dari user
            </div>

        </div>

        <a href="{{ route('admin.topups.index') }}"
           class="btn btn-primary">

            Lihat Semua

        </a>

    </div>


    <div class="table-wrapper">

        <table class="table">

            <thead>

                <tr>

                    <th>
                        User
                    </th>

                    <th>
                        Amount
                    </th>

                    <th>
                        Payment
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Date
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($recentTopups ?? [] as $topup)

                    <tr>

                        <td>

                            <strong>
                                {{ $topup->user->name }}
                            </strong>

                            <div style="
                                color:#64748b;
                                font-size:11px;
                                margin-top:3px;
                            ">

                                {{ $topup->user->email }}

                            </div>

                        </td>


                        <td>

                            <strong>

                                {{ number_format(
                                    $topup->amount,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </strong>

                        </td>


                        <td>
                            {{ $topup->payment_method }}
                        </td>


                        <td>

                            @if($topup->status === 'pending')

                                <span class="badge badge-warning">
                                    Pending
                                </span>

                            @elseif($topup->status === 'approved')

                                <span class="badge badge-success">
                                    Approved
                                </span>

                            @else

                                <span class="badge badge-danger">
                                    Rejected
                                </span>

                            @endif

                        </td>


                        <td style="color:#64748b;">

                            {{ $topup->created_at?->format(
                                'd M Y H:i'
                            ) }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5"
                            style="
                                text-align:center;
                                padding:40px;
                                color:#64748b;
                            ">

                            Belum ada data top up.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
