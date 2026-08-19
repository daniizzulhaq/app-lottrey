<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Draw;
use App\Models\Game;
use App\Models\GameBet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DrawController extends Controller
{
    /**
     * Daftar draw.
     */
    public function index(Request $request)
    {
        $draws = Draw::with('game')
            ->when(
                $request->game_id,
                function ($query) use ($request) {
                    $query->where(
                        'game_id',
                        $request->game_id
                    );
                }
            )
            ->latest('start_time')
            ->paginate(20);

        $games = Game::orderBy('name')->get();

        return view(
            'admin.draws.index',
            compact(
                'draws',
                'games'
            )
        );
    }

    /**
     * Form membuat draw.
     */
    public function create()
    {
        $games = Game::where(
            'status',
            'active'
        )
            ->orderBy('name')
            ->get();

        return view(
            'admin.draws.create',
            compact('games')
        );
    }

    /**
     * Membuat draw.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'game_id' => [
                'required',
                'integer',
                'exists:games,id'
            ],

            'draw_number' => [
                'required',
                'string',
                'max:100'
            ],

            'start_time' => [
                'required',
                'date'
            ],

            'end_time' => [
                'required',
                'date',
                'after:start_time'
            ],
        ]);

        /*
         * Game harus aktif.
         */
        $game = Game::where(
            'id',
            $validated['game_id']
        )
            ->where(
                'status',
                'active'
            )
            ->first();

        if (!$game) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Game tidak aktif.'
                );
        }

        /*
         * Cek duplicate draw number.
         */
        $exists = Draw::where(
            'game_id',
            $game->id
        )
            ->where(
                'draw_number',
                $validated['draw_number']
            )
            ->exists();

        if ($exists) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Nomor draw sudah digunakan untuk game ini.'
                );
        }

        Draw::create([
            'game_id' =>
                $game->id,

            'draw_number' =>
                $validated['draw_number'],

            'start_time' =>
                $validated['start_time'],

            'end_time' =>
                $validated['end_time'],

            'status' =>
                'upcoming',

            'result' =>
                null,
        ]);

        return redirect()
            ->route('admin.draws.index')
            ->with(
                'success',
                'Round berhasil dibuat.'
            );
    }

    /**
     * Detail draw.
     */
    public function show(Draw $draw)
    {
        $draw->load([
            'game',
            'bets.user'
        ]);

        return view(
            'admin.draws.show',
            compact('draw')
        );
    }

    /**
     * Buka draw.
     */
    public function open(Draw $draw)
    {
        /*
         * Hanya upcoming yang bisa dibuka.
         */
        if ($draw->status !== 'upcoming') {

            return back()->with(
                'error',
                'Round tidak dapat dibuka.'
            );
        }

        /*
         * Game harus aktif.
         */
        $draw->load('game');

        if (
            !$draw->game ||
            $draw->game->status !== 'active'
        ) {

            return back()->with(
                'error',
                'Game sedang tidak aktif.'
            );
        }

        /*
         * Jangan izinkan membuka draw
         * yang waktu akhirnya sudah lewat.
         */
        if (
            now()->greaterThanOrEqualTo(
                $draw->end_time
            )
        ) {

            return back()->with(
                'error',
                'Waktu round sudah berakhir.'
            );
        }

        /*
         * Cegah dua draw open dalam satu game.
         */
        $anotherOpen = Draw::where(
            'game_id',
            $draw->game_id
        )
            ->where(
                'status',
                'open'
            )
            ->where(
                'id',
                '!=',
                $draw->id
            )
            ->exists();

        if ($anotherOpen) {

            return back()->with(
                'error',
                'Masih ada round lain yang sedang terbuka.'
            );
        }

        /*
         * Open manual.
         */
        $startTime = $draw->start_time;

        if (
            now()->lessThan(
                $draw->start_time
            )
        ) {
            $startTime = now();
        }

        $draw->update([
            'status' =>
                'open',

            'start_time' =>
                $startTime,
        ]);

        return back()->with(
            'success',
            'Round berhasil dibuka. User sekarang dapat betting.'
        );
    }

    /**
     * Tutup draw.
     */
    public function close(Draw $draw)
    {
        if ($draw->status !== 'open') {

            return back()->with(
                'error',
                'Round tidak sedang terbuka.'
            );
        }

        $draw->update([
            'status' => 'closed'
        ]);

        return back()->with(
            'success',
            'Round berhasil ditutup.'
        );
    }

    /**
     * ==========================================================
     * SIMPAN RESULT
     * ==========================================================
     */
    public function result(
        Request $request,
        Draw $draw
    ) {

        /*
         * Result harus berupa 5 angka.
         */
        $validated = $request->validate([
            'result' => [
                'required',
                'array',
                'size:5',
            ],

            'result.*' => [
                'required',
                'integer',
                'between:0,9',
            ],
        ]);

        /*
         * Draw harus open atau closed.
         */
        if (
            !in_array(
                $draw->status,
                [
                    'open',
                    'closed'
                ],
                true
            )
        ) {

            return back()->with(
                'error',
                'Round harus Open atau Closed untuk memasukkan result.'
            );
        }

        /*
         * Result tidak boleh diproses dua kali.
         */
        if (!empty($draw->result)) {

            return back()->with(
                'error',
                'Result draw ini sudah diproses.'
            );
        }

        DB::transaction(function () use (
            $draw,
            $validated
        ) {

            /*
             * Lock draw.
             */
            $lockedDraw = Draw::where(
                'id',
                $draw->id
            )
                ->lockForUpdate()
                ->first();

            if (!$lockedDraw) {

                throw ValidationException::withMessages([
                    'result' =>
                        'Draw tidak ditemukan.'
                ]);
            }

            /*
             * Pastikan status masih valid.
             */
            if (
                !in_array(
                    $lockedDraw->status,
                    [
                        'open',
                        'closed'
                    ],
                    true
                )
            ) {

                throw ValidationException::withMessages([
                    'result' =>
                        'Round sudah diproses.'
                ]);
            }

            /*
             * Ambil 5 angka.
             */
            $numbers = array_map(
                'intval',
                $validated['result']
            );

            /*
             * Pastikan tepat 5 angka.
             */
            if (count($numbers) !== 5) {

                throw ValidationException::withMessages([
                    'result' =>
                        'Result harus terdiri dari 5 angka.'
                ]);
            }

            /*
             * Pastikan angka 0 sampai 9.
             */
            foreach ($numbers as $number) {

                if (
                    $number < 0 ||
                    $number > 9
                ) {

                    throw ValidationException::withMessages([
                        'result' =>
                            'Setiap angka result harus 0 sampai 9.'
                    ]);
                }
            }

            /*
             * ======================================================
             * HITUNG TOTAL
             * ======================================================
             */

            $total = array_sum($numbers);

            /*
             * ======================================================
             * BIG / SMALL
             * ======================================================
             *
             * 0 - 22  = SMALL
             * 23 - 45 = BIG
             */

            $sizeResult = $total >= 23
                ? 'big'
                : 'small';

            /*
             * ======================================================
             * SINGLE / DOUBLE
             * ======================================================
             *
             * Ganjil = SINGLE
             * Genap  = DOUBLE
             */

            $parityResult = $total % 2 === 0
                ? 'double'
                : 'single';

            /*
             * ======================================================
             * 4 HASIL
             * ======================================================
             *
             * Kita simpan semua kategori hasil.
             *
             * Contoh:
             *
             * BIG
             * SMALL
             * SINGLE
             * DOUBLE
             *
             * Hasil aktual tetap ditentukan dari
             * total angka.
             */

            $resultTypes = [
                $sizeResult,
                $parityResult,
            ];

            /*
             * ======================================================
             * SIMPAN RESULT
             * ======================================================
             */

            $lockedDraw->update([
                'result' =>
                    $numbers,

                'status' =>
                    'completed',
            ]);

            /*
             * ======================================================
             * AMBIL SEMUA BET
             * ======================================================
             */

            $bets = GameBet::where(
                'draw_id',
                $lockedDraw->id
            )
                ->lockForUpdate()
                ->get();

            foreach ($bets as $bet) {

                /*
                 * Jangan proses dua kali.
                 */
                if (
                    in_array(
                        $bet->status,
                        [
                            'won',
                            'lost'
                        ],
                        true
                    )
                ) {
                    continue;
                }

                /*
                 * Selection.
                 */
                $selection = $bet->selection;

                $selectedType = null;

                if (is_array($selection)) {

                    $selectedType =
                        $selection['type']
                        ?? null;
                }

                /*
                 * ==================================================
                 * CEK MENANG
                 * ==================================================
                 *
                 * Contoh hasil:
                 *
                 * BIG + DOUBLE
                 *
                 * Bet BIG    => WIN
                 * Bet DOUBLE => WIN
                 * Bet SMALL  => LOSE
                 * Bet SINGLE => LOSE
                 */

                $isWin = in_array(
                    $selectedType,
                    $resultTypes,
                    true
                );

                /*
                 * Hitung payout.
                 */
                $winAmount =
                    $isWin
                        ? $this->calculatePayout($bet)
                        : 0;

                /*
                 * Lock user.
                 */
                $user = $bet
                    ->user()
                    ->lockForUpdate()
                    ->first();

                if (!$user) {

                    throw ValidationException::withMessages([
                        'result' =>
                            'User untuk bet tidak ditemukan.'
                    ]);
                }

                /*
                 * Simpan hasil bet.
                 */
                $bet->update([
                    'status' =>
                        $isWin
                            ? 'won'
                            : 'lost',

                    'result' =>
                        $isWin
                            ? $selectedType
                            : implode(
                                ',',
                                $resultTypes
                            ),

                    'win_amount' =>
                        $winAmount,
                ]);

                /*
                 * Kalau menang,
                 * tambahkan saldo.
                 */
                if ($isWin) {

                    $balanceBefore =
                        (float) $user->balance;

                    $balanceAfter =
                        $balanceBefore
                        + $winAmount;

                    $user->update([
                        'balance' =>
                            $balanceAfter,
                    ]);

                    /*
                     * Transaction WIN.
                     */
                    Transaction::create([
                        'user_id' =>
                            $user->id,

                        'type' =>
                            'WIN',

                        'amount' =>
                            $winAmount,

                        'balance_before' =>
                            $balanceBefore,

                        'balance_after' =>
                            $balanceAfter,

                        'reference_type' =>
                            GameBet::class,

                        'reference_id' =>
                            $bet->id,

                        'description' =>
                            'Game win - ' .
                            (
                                $lockedDraw
                                    ->game
                                    ->name
                                    ?? 'Game'
                            ),
                    ]);
                }
            }
        });

        return back()->with(
            'success',
            'Result berhasil disimpan dan seluruh bet sudah diproses.'
        );
    }

    /**
     * Hitung payout.
     */
    private function calculatePayout(
        GameBet $bet
    ): float {

        $rate =
            (float) (
                $bet->rate ?? 1.98
            );

        return round(
            (float) $bet->amount * $rate,
            2
        );
    }
}
