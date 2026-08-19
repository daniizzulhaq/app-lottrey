<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Topup;
use Illuminate\Http\Request;

class TopupController extends Controller
{
    /**
     * Form top up.
     */
    public function create()
    {
        return view('user.topup.create');
    }

    /**
     * Simpan pengajuan top up.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:10',
                'max:100000000'
            ],

            'payment_method' => [
                'required',
                'string',
                'max:100'
            ],

            'proof' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120'
            ],
        ]);

        /*
         * Upload bukti.
         */
        $proofPath = $request
            ->file('proof')
            ->store('topups', 'public');

        Topup::create([
            'user_id' => $request->user()->id,
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'proof' => $proofPath,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('topup.history')
            ->with(
                'success',
                'Top up berhasil dikirim dan menunggu pemeriksaan admin.'
            );
    }

    /**
     * History top up.
     */
    public function history(Request $request)
    {
        $topups = Topup::where(
                'user_id',
                $request->user()->id
            )
            ->latest()
            ->paginate(10);

        return view(
            'user.topup.history',
            compact('topups')
        );
    }

    /**
     * Detail top up.
     */
    public function show(Request $request, Topup $topup)
    {
        abort_unless(
            $topup->user_id === $request->user()->id,
            403
        );

        return view(
            'user.topup.show',
            compact('topup')
        );
    }
}
