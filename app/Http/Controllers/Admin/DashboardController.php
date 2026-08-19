<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Draw;
use App\Models\Game;
use App\Models\Redemption;
use App\Models\Topup;
use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();

        $activeUsers = User::where(
            'status',
            'active'
        )->count();

        $pendingTopups = Topup::where(
            'status',
            'pending'
        )->count();

        $pendingRedemptions = Redemption::where(
            'status',
            'pending'
        )->count();

        $totalGames = Game::count();

        $activeDraws = Draw::where(
            'status',
            'open'
        )->count();

        $totalTransactions = Transaction::count();

        return view(
            'admin.dashboard',
            compact(
                'totalUsers',
                'activeUsers',
                'pendingTopups',
                'pendingRedemptions',
                'totalGames',
                'activeDraws',
                'totalTransactions'
            )
        );
    }
}
