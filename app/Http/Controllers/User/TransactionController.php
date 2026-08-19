<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::where(
                'user_id',
                $request->user()->id
            )
            ->latest()
            ->paginate(20);

        return view(
            'user.transactions.index',
            compact('transactions')
        );
    }

    public function show(
        Request $request,
        Transaction $transaction
    ) {
        abort_unless(
            $transaction->user_id === $request->user()->id,
            403
        );

        return view(
            'user.transactions.show',
            compact('transaction')
        );
    }
}
