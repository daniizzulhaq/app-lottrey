<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Draw;
use App\Models\Game;
use App\Models\GameBet;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class GameController extends Controller
{
    /**
     * Daftar game aktif.
     */
    public function index()
    {
        $games = Game::where('status', 'active')
            ->latest()
            ->get();

        return view(
            'user.games.index',
            compact('games')
        );
    }

    /**
     * Halaman game.
     */
    public function show(Game $game)
    {
        abort_if(
            $game->status !== 'active',
            404
        );

        $mode = $this->getGameMode($game);

        /*
         * ==========================================================
         * CARI DRAW YANG SUDAH DIBUKA ADMIN
         * ==========================================================
         *
         * PENTING:
         * Kalau admin melakukan Open Draw secara manual,
         * start_time tidak boleh lagi menjadi syarat.
         *
         * Jadi cukup:
         * - game_id sesuai
         * - status open
         * - end_time belum lewat
         */
        $draw = Draw::where('game_id', $game->id)
            ->where('status', 'open')
            ->where('end_time', '>', now())
            ->orderBy('start_time')
            ->first();

        /*
         * Kalau belum ada draw open,
         * tampilkan upcoming terdekat.
         */
        if (!$draw) {
            $draw = Draw::where('game_id', $game->id)
                ->where('status', 'upcoming')
                ->where('end_time', '>', now())
                ->orderBy('start_time')
                ->first();
        }

        /*
         * Recent result.
         */
        $recentDraws = Draw::where('game_id', $game->id)
            ->where('status', 'completed')
            ->whereNotNull('result')
            ->latest('end_time')
            ->limit(10)
            ->get();

        return view(
            'user.games.show',
            compact(
                'game',
                'draw',
                'recentDraws',
                'mode'
            )
        );
    }

    /**
     * Pasang bet.
     */
    public function play(Request $request, Game $game)
    {
        $validated = $request->validate([
            'draw_id' => [
                'required',
                'integer',
                'exists:draws,id',
            ],

            'selection' => [
                'required',
                'string',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:1',
            ],
        ]);

        $user = $request->user();

        /*
         * Game harus aktif.
         */
        if ($game->status !== 'active') {
            return back()->with(
                'error',
                'Game sedang tidak aktif.'
            );
        }

        /*
         * Decode selection.
         */
        $selection = json_decode(
            $validated['selection'],
            true
        );

        if (!is_array($selection) || empty($selection)) {
            return back()->with(
                'error',
                'Pilihan taruhan tidak valid.'
            );
        }

        /*
         * Pilihan yang diperbolehkan.
         */
        $allowedOptions = [
            'big',
            'small',
            'single',
            'double',
        ];

        foreach ($selection as $section => $option) {

            if (!is_string($option)) {
                return back()->with(
                    'error',
                    'Pilihan taruhan tidak valid.'
                );
            }

            if (!in_array(
                $option,
                $allowedOptions,
                true
            )) {
                return back()->with(
                    'error',
                    'Pilihan taruhan tidak valid.'
                );
            }
        }

        /*
         * ==========================================================
         * VALIDASI DRAW
         * ==========================================================
         *
         * PENTING:
         * start_time TIDAK dicek lagi.
         *
         * Karena admin bisa membuka draw secara manual
         * walaupun start_time belum tercapai.
         */
        $draw = Draw::where('id', $validated['draw_id'])
            ->where('game_id', $game->id)
            ->where('status', 'open')
            ->where('end_time', '>', now())
            ->first();

        if (!$draw) {
            return back()->with(
                'error',
                'Round sudah ditutup, belum dibuka, atau sudah berakhir.'
            );
        }

        /*
         * Configuration game.
         */
        $configuration = $game->configuration ?? [];

        $minimumBet = (float) (
            $configuration['minimum_bet'] ?? 1
        );

        $maximumBet = (float) (
            $configuration['maximum_bet'] ?? PHP_INT_MAX
        );

        $amount = (float) $validated['amount'];

        /*
         * Minimum.
         */
        if ($amount < $minimumBet) {
            throw ValidationException::withMessages([
                'amount' =>
                    "Minimum bet adalah {$minimumBet}."
            ]);
        }

        /*
         * Maximum.
         */
        if ($amount > $maximumBet) {
            throw ValidationException::withMessages([
                'amount' =>
                    "Maximum bet adalah {$maximumBet}."
            ]);
        }

        /*
         * Mode dan rate.
         */
        $mode = $this->getGameMode($game);

        $rate = $mode['rate'];

        /*
         * Total uang yang dipotong.
         */
        $totalAmount =
            count($selection) * $amount;

        /*
         * ==========================================================
         * TRANSACTION
         * ==========================================================
         */
        DB::transaction(function () use (
            $user,
            $game,
            $draw,
            $selection,
            $amount,
            $totalAmount,
            $rate,
            $mode
        ) {

            /*
             * Lock user.
             */
            $lockedUser = $user->newQuery()
                ->where('id', $user->id)
                ->lockForUpdate()
                ->first();

            if (!$lockedUser) {
                throw ValidationException::withMessages([
                    'amount' =>
                        'User tidak ditemukan.'
                ]);
            }

            /*
             * Cek saldo.
             */
            if (
                (float) $lockedUser->balance
                < $totalAmount
            ) {
                throw ValidationException::withMessages([
                    'amount' =>
                        'Insufficient account balance'
                ]);
            }

            /*
             * Saldo.
             */
            $balanceBefore =
                (float) $lockedUser->balance;

            $balanceAfter =
                $balanceBefore - $totalAmount;

            $lockedUser->update([
                'balance' => $balanceAfter
            ]);

            /*
             * Buat bet.
             */
            foreach ($selection as $section => $option) {

                $bet = GameBet::create([
                    'user_id' =>
                        $lockedUser->id,

                    'game_id' =>
                        $game->id,

                    'draw_id' =>
                        $draw->id,

                    'selection' => [
                        'section' => $section,
                        'type' => $option,
                    ],

                    'amount' =>
                        $amount,

                    'rate' =>
                        $rate,

                    'mode' =>
                        $mode['mode'],

                    'status' =>
                        'pending',

                    'win_amount' =>
                        0,
                ]);

                /*
                 * Transaction.
                 */
                Transaction::create([
                    'user_id' =>
                        $lockedUser->id,

                    'type' =>
                        'GAME',

                    'amount' =>
                        -$amount,

                    'balance_before' =>
                        $balanceBefore,

                    'balance_after' =>
                        $balanceAfter,

                    'reference_type' =>
                        GameBet::class,

                    'reference_id' =>
                        $bet->id,

                    'description' =>
                        'Bet 5 Points Lottery',
                ]);
            }
        });

        return redirect()
            ->route(
                'games.show',
                $game
            )
            ->with(
                'success',
                'Bet berhasil dipasang.'
            );
    }

    /**
     * Menentukan Normal / Special Mode.
     */
    private function getGameMode(
        Game $game
    ): array {

        $configuration =
            $game->configuration ?? [];

        $normalRate =
            (float) (
                $configuration['normal_rate']
                ?? 1.98
            );

        $specialRate =
            (float) (
                $configuration['special_rate']
                ?? 2.10
            );

        $specialDuration =
            (int) (
                $configuration['special_duration']
                ?? 15
            );

        $specialTimes =
            $configuration['special_times']
            ?? [
                '14:30',
                '20:00'
            ];

        /*
         * Gunakan timezone WIB.
         */
        $now = Carbon::now(
            'Asia/Jakarta'
        );

        $specialMode = false;

        foreach ($specialTimes as $specialTime) {

            try {

                $start =
                    Carbon::createFromFormat(
                        'H:i',
                        $specialTime,
                        'Asia/Jakarta'
                    );

                $start->setDate(
                    $now->year,
                    $now->month,
                    $now->day
                );

                $end =
                    $start->copy()
                        ->addMinutes(
                            $specialDuration
                        );

                if (
                    $now->greaterThanOrEqualTo($start)
                    &&
                    $now->lessThan($end)
                ) {
                    $specialMode = true;
                    break;
                }

            } catch (\Throwable $e) {

                /*
                 * Abaikan konfigurasi waktu
                 * yang formatnya tidak valid.
                 */
                continue;
            }
        }

        if ($specialMode) {

            return [
                'mode' =>
                    'special',

                'rate' =>
                    $specialRate,

                'special' =>
                    true,

                'rate_label' =>
                    number_format(
                        $specialRate,
                        2
                    ),
            ];
        }

        return [
            'mode' =>
                'normal',

            'rate' =>
                $normalRate,

            'special' =>
                false,

            'rate_label' =>
                number_format(
                    $normalRate,
                    2
                ),
        ];
    }
}
