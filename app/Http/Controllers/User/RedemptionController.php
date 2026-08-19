<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Redemption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RedemptionController extends Controller
{
    public function create(Request $request)
    {
        return view(
            'user.redemptions.create',
            [
                'user' => $request->user()
            ]
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:10'
            ],

            'destination' => [
                'required',
                'array'
            ],

            'destination.bank_name' => [
                'required',
                'string',
                'max:100'
            ],

            'destination.account_number' => [
                'required',
                'string',
                'max:100'
            ],

            'destination.account_name' => [
                'required',
                'string',
                'max:100'
            ],
        ]);

        DB::transaction(function () use (
            $request,
            $validated
        ) {

            $user = $request->user();

            $lockedUser = $user->newQuery()
                ->where('id', $user->id)
                ->lockForUpdate()
                ->first();

            $amount = (float) $validated['amount'];

            if ($lockedUser->balance < $amount) {
                throw ValidationException::withMessages([
                    'amount' => 'Saldo virtual credit tidak mencukupi.'
                ]);
            }

            /*
             * Credit ditahan sejak request redeem
             * dibuat agar tidak dapat digunakan lagi.
             */
            $lockedUser->balance -= $amount;
            $lockedUser->save();

            Redemption::create([
                'user_id' => $lockedUser->id,
                'amount' => $amount,
                'destination' => $validated['destination'],
                'status' => 'pending',
            ]);
        });

        return redirect()
            ->route('redeem.history')
            ->with(
                'success',
                'Pengajuan redeem berhasil dikirim.'
            );
    }

    public function history(Request $request)
    {
        $redemptions = Redemption::where(
                'user_id',
                $request->user()->id
            )
            ->latest()
            ->paginate(10);

        return view(
            'user.redemptions.history',
            compact('redemptions')
        );
    }

    public function show(
        Request $request,
        Redemption $redemption
    ) {
        abort_unless(
            $redemption->user_id === $request->user()->id,
            403
        );

        return view(
            'user.redemptions.show',
            compact('redemption')
        );
    }
}
