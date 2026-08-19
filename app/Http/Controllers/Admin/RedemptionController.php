<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Redemption;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RedemptionController extends Controller
{
    public function index(Request $request)
    {
        $redemptions = Redemption::with([
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
            'admin.redemptions.index',
            compact('redemptions')
        );
    }

    public function show(
        Redemption $redemption
    ) {
        $redemption->load([
            'user',
            'approver'
        ]);

        return view(
            'admin.redemptions.show',
            compact('redemption')
        );
    }

    /**
     * APPROVE REDEEM
     */
    public function approve(
        Redemption $redemption
    ) {
        DB::transaction(function () use (
            $redemption
        ) {

            $locked = Redemption::where(
                    'id',
                    $redemption->id
                )
                ->lockForUpdate()
                ->first();

            if ($locked->status !== 'pending') {
                throw ValidationException::withMessages([
                    'redemption' =>
                        'Redeem sudah diproses.'
                ]);
            }

            /*
             * Saldo sudah dikurangi
             * ketika user membuat redeem.
             *
             * Jadi ketika approve,
             * TIDAK mengurangi saldo lagi.
             */
            /** @var int|null $adminId */
            $adminId = auth()->id();

            $locked->update([
                'status' => 'completed',
                'approved_by' => $adminId,
                'approved_at' => now(),
            ]);
        });

        return back()->with(
            'success',
            'Redeem berhasil disetujui.'
        );
    }

    /**
     * REJECT REDEEM
     *
     * Credit dikembalikan ke user.
     */
    public function reject(
        Request $request,
        Redemption $redemption
    ) {
        $validated = $request->validate([
            'rejection_reason' => [
                'required',
                'string',
                'max:1000'
            ],
        ]);

        DB::transaction(function () use (
            $redemption,
            $validated
        ) {

            $locked = Redemption::where(
                    'id',
                    $redemption->id
                )
                ->lockForUpdate()
                ->first();

            if ($locked->status !== 'pending') {
                throw ValidationException::withMessages([
                    'redemption' =>
                        'Redeem sudah diproses.'
                ]);
            }

            /** @var User $user */
            $user = $locked->user()
                ->lockForUpdate()
                ->first();

            $balanceBefore = $user->balance;

            $balanceAfter =
                $balanceBefore +
                $locked->amount;

            /*
             * Kembalikan credit.
             */
            $user->update([
                'balance' => $balanceAfter
            ]);

            /** @var int|null $adminId */
            $adminId = auth()->id();

            /*
             * Update redeem.
             */
            $locked->update([
                'status' => 'rejected',
                'approved_by' => $adminId,
                'approved_at' => now(),
                'rejection_reason' =>
                    $validated['rejection_reason'],
            ]);

            /*
             * Catat refund.
             */
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'REFUND',
                'amount' => $locked->amount,
                'balance_before' =>
                    $balanceBefore,
                'balance_after' =>
                    $balanceAfter,
                'reference_type' =>
                    Redemption::class,
                'reference_id' =>
                    $locked->id,
                'description' =>
                    'Refund virtual credit karena redeem ditolak',
            ]);
        });

        return back()->with(
            'success',
            'Redeem ditolak dan virtual credit dikembalikan.'
        );
    }
}
