<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameBet;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $games = Game::where('status', 'active')
            ->latest()
            ->get();

        $recentBets = GameBet::with([
                'game',
                'draw'
            ])
            ->where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        $recentTransactions = Transaction::where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('user.dashboard', compact(
            'user',
            'games',
            'recentBets',
            'recentTransactions'
        ));
    }
}
