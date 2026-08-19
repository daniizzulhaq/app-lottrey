<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topup;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TopupController extends Controller
{
    public function index(Request $request)
    {
        $topups = Topup::with([
                'user',
                'approver'
            ])
            ->when(
                $request->status,
                fn ($query) =>
                    $query->where(
                        'status',
                        $request->status
                    )
            )
            ->latest()
            ->paginate(20);

        return view(
            'admin.topups.index',
            compact('topups')
        );
    }

    public function show(Topup $topup)
    {
        $topup->load([
            'user',
            'approver'
        ]);

        return view(
            'admin.topups.show',
            compact('topup')
        );
    }

    /**
     * APPROVE TOPUP
     */
    public function approve(Topup $topup)
    {
        DB::transaction(function () use ($topup) {

            $lockedTopup = Topup::where(
                    'id',
                    $topup->id
                )
                ->lockForUpdate()
                ->first();

            /*
             * Cegah approve dua kali.
             */
            if ($lockedTopup->status !== 'pending') {
                throw ValidationException::withMessages([
                    'topup' =>
                        'Top up sudah diproses sebelumnya.'
                ]);
            }

            /*
             * Lock user.
             */
            /** @var User $user */
            $user = $lockedTopup->user()
                ->lockForUpdate()
                ->first();

            $balanceBefore = $user->balance;

            $balanceAfter =
                $balanceBefore +
                $lockedTopup->amount;

            /*
             * Update saldo.
             */
            $user->update([
                'balance' => $balanceAfter
            ]);

            /*
             * Update topup.
             */
            $lockedTopup->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

            /*
             * Catat transaksi.
             */
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'TOPUP',
                'amount' => $lockedTopup->amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'reference_type' => Topup::class,
                'reference_id' => $lockedTopup->id,
                'description' =>
                    'Top up virtual credit approved',
            ]);
        });

        return back()->with(
            'success',
            'Top up berhasil di-approve dan saldo user bertambah.'
        );
    }

    /**
     * REJECT TOPUP
     */
    public function reject(
        Request $request,
        Topup $topup
    ) {
        $validated = $request->validate([
            'rejection_reason' => [
                'required',
                'string',
                'max:1000'
            ],
        ]);

        if ($topup->status !== 'pending') {
            return back()->with(
                'error',
                'Top up sudah diproses.'
            );
        }

        $topup->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_reason' =>
                $validated['rejection_reason'],
        ]);

        /*
         * Tidak ada perubahan saldo
         * karena topup belum pernah
         * menambah saldo.
         */

        return back()->with(
            'success',
            'Top up berhasil ditolak.'
        );
    }
}
