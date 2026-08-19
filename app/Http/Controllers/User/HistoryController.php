<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\GameBet;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $bets = GameBet::with([
                'game',
                'draw'
            ])
            ->where(
                'user_id',
                $request->user()->id
            )
            ->latest()
            ->paginate(20);

        return view(
            'user.history.index',
            compact('bets')
        );
    }

    public function show(
        Request $request,
        GameBet $gameBet
    ) {
        abort_unless(
            $gameBet->user_id === $request->user()->id,
            403
        );

        $gameBet->load([
            'game',
            'draw'
        ]);

        return view(
            'user.history.show',
            compact('gameBet')
        );
    }
}
