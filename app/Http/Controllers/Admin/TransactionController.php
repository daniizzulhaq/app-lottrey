<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with('user')
            ->when(
                $request->type,
                fn ($query) =>
                    $query->where(
                        'type',
                        $request->type
                    )
            )
            ->when(
                $request->user_id,
                fn ($query) =>
                    $query->where(
                        'user_id',
                        $request->user_id
                    )
            )
            ->latest()
            ->paginate(30)
            ->withQueryString();

        $users = User::orderBy('name')->get();

        return view(
            'admin.transactions.index',
            compact(
                'transactions',
                'users'
            )
        );
    }

    public function show(
        Transaction $transaction
    ) {
        $transaction->load('user');

        return view(
            'admin.transactions.show',
            compact('transaction')
        );
    }
}
