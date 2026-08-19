    <?php

    use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
    use App\Http\Controllers\Admin\DrawController as AdminDrawController;
    use App\Http\Controllers\Admin\GameController as AdminGameController;
    use App\Http\Controllers\Admin\RedemptionController as AdminRedemptionController;
    use App\Http\Controllers\Admin\SettingController as AdminSettingController;
    use App\Http\Controllers\Admin\TopupController as AdminTopupController;
    use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
    use App\Http\Controllers\Admin\UserController as AdminUserController;

    use App\Http\Controllers\User\DashboardController;
    use App\Http\Controllers\User\GameController;
    use App\Http\Controllers\User\HistoryController;
    use App\Http\Controllers\User\ProfileController;
    use App\Http\Controllers\User\RedemptionController;
    use App\Http\Controllers\User\TopupController;
    use App\Http\Controllers\User\TransactionController;

    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | Public Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/', function () {
        return auth()->check()
            ? redirect()->route('dashboard')
            : redirect()->route('login');
    })->name('home');


    /*
    |--------------------------------------------------------------------------
    | Authenticated User Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware(['auth'])->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            DashboardController::class,
            'index'
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Profile
        |--------------------------------------------------------------------------
        */

        Route::prefix('profile')
            ->name('profile.')
            ->group(function () {

                Route::get('/', [
                    ProfileController::class,
                    'show'
                ])->name('show');

                Route::put('/', [
                    ProfileController::class,
                    'update'
                ])->name('update');
            });


        /*
        |--------------------------------------------------------------------------
        | Customer Service
        |--------------------------------------------------------------------------
        */

        Route::get('/support', function () {
            return view('user.support');
        })->name('support');


        /*
        |--------------------------------------------------------------------------
        | Games
        |--------------------------------------------------------------------------
        */

        Route::prefix('games')
        ->name('games.')
        ->group(function () {

            // Daftar game
            Route::get('/', [
                GameController::class,
                'index'
            ])->name('index');

            // Halaman game
            Route::get('/{game}', [
                GameController::class,
                'show'
            ])->name('show');

            // Submit taruhan
            Route::post('/{game}/play', [
                GameController::class,
                'play'
            ])->name('play');

            // Ambil informasi round aktif
            Route::get('/{game}/round', [
                GameController::class,
                'round'
            ])->name('round');

            // Cek status round
            Route::get('/{game}/round/status', [
                GameController::class,
                'roundStatus'
            ])->name('round.status');

            // Riwayat round game
            Route::get('/{game}/round/history', [
                GameController::class,
                'roundHistory'
            ])->name('round.history');
        });


        /*
        |--------------------------------------------------------------------------
        | Top Up
        |--------------------------------------------------------------------------
        */

        Route::prefix('topup')
            ->name('topup.')
            ->group(function () {

                Route::get('/', [
                    TopupController::class,
                    'create'
                ])->name('create');

                Route::post('/', [
                    TopupController::class,
                    'store'
                ])->name('store');

                Route::get('/history', [
                    TopupController::class,
                    'history'
                ])->name('history');

                Route::get('/{topup}', [
                    TopupController::class,
                    'show'
                ])->name('show');
            });


        /*
        |--------------------------------------------------------------------------
        | Redeem
        |--------------------------------------------------------------------------
        */

        Route::prefix('redeem')
            ->name('redeem.')
            ->group(function () {

                Route::get('/', [
                    RedemptionController::class,
                    'create'
                ])->name('create');

                Route::post('/', [
                    RedemptionController::class,
                    'store'
                ])->name('store');

                Route::get('/history', [
                    RedemptionController::class,
                    'history'
                ])->name('history');

                Route::get('/{redemption}', [
                    RedemptionController::class,
                    'show'
                ])->name('show');
            });


        /*
        |--------------------------------------------------------------------------
        | Game History
        |--------------------------------------------------------------------------
        */

        Route::prefix('history')
            ->name('history.')
            ->group(function () {

                Route::get('/', [
                    HistoryController::class,
                    'index'
                ])->name('index');

                Route::get('/{gameBet}', [
                    HistoryController::class,
                    'show'
                ])->name('show');
            });


        /*
        |--------------------------------------------------------------------------
        | Transactions
        |--------------------------------------------------------------------------
        */

        Route::prefix('transactions')
            ->name('transactions.')
            ->group(function () {

                Route::get('/', [
                    TransactionController::class,
                    'index'
                ])->name('index');

                Route::get('/{transaction}', [
                    TransactionController::class,
                    'show'
                ])->name('show');
            });
    });


    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware([
        'auth',
        'admin'
    ])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Dashboard
            |--------------------------------------------------------------------------
            */

            Route::get('/', [
                AdminDashboardController::class,
                'index'
            ])->name('dashboard');


            /*
            |--------------------------------------------------------------------------
            | Users
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'users',
                AdminUserController::class
            );


            /*
            |--------------------------------------------------------------------------
            | Games
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'games',
                AdminGameController::class
            );


            /*
            |--------------------------------------------------------------------------
            | Draws
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'draws',
                AdminDrawController::class
            );


            /*
            |--------------------------------------------------------------------------
            | Draw Actions
            |--------------------------------------------------------------------------
            */

            Route::post(
                '/draws/{draw}/open',
                [
                    AdminDrawController::class,
                    'open'
                ]
            )->name('draws.open');


            Route::post(
                '/draws/{draw}/close',
                [
                    AdminDrawController::class,
                    'close'
                ]
            )->name('draws.close');


            Route::post(
                '/draws/{draw}/result',
                [
                    AdminDrawController::class,
                    'result'
                ]
            )->name('draws.result');


            /*
            |--------------------------------------------------------------------------
            | Top Ups
            |--------------------------------------------------------------------------
            */

            Route::prefix('topups')
                ->name('topups.')
                ->group(function () {

                    Route::get('/', [
                        AdminTopupController::class,
                        'index'
                    ])->name('index');

                    Route::get('/{topup}', [
                        AdminTopupController::class,
                        'show'
                    ])->name('show');

                    Route::post('/{topup}/approve', [
                        AdminTopupController::class,
                        'approve'
                    ])->name('approve');

                    Route::post('/{topup}/reject', [
                        AdminTopupController::class,
                        'reject'
                    ])->name('reject');
                });


            /*
            |--------------------------------------------------------------------------
            | Redemptions
            |--------------------------------------------------------------------------
            */

            Route::prefix('redemptions')
                ->name('redemptions.')
                ->group(function () {

                    Route::get('/', [
                        AdminRedemptionController::class,
                        'index'
                    ])->name('index');

                    Route::get('/{redemption}', [
                        AdminRedemptionController::class,
                        'show'
                    ])->name('show');

                    Route::post('/{redemption}/approve', [
                        AdminRedemptionController::class,
                        'approve'
                    ])->name('approve');

                    Route::post('/{redemption}/reject', [
                        AdminRedemptionController::class,
                        'reject'
                    ])->name('reject');
                });


            /*
            |--------------------------------------------------------------------------
            | Transactions
            |--------------------------------------------------------------------------
            */

            Route::prefix('transactions')
                ->name('transactions.')
                ->group(function () {

                    Route::get('/', [
                        AdminTransactionController::class,
                        'index'
                    ])->name('index');

                    Route::get('/{transaction}', [
                        AdminTransactionController::class,
                        'show'
                    ])->name('show');
                });


            /*
            |--------------------------------------------------------------------------
            | Website Settings
            |--------------------------------------------------------------------------
            */

            Route::prefix('settings')
                ->name('settings.')
                ->group(function () {

                    Route::get('/', [
                        AdminSettingController::class,
                        'index'
                    ])->name('index');

                    Route::put('/', [
                        AdminSettingController::class,
                        'update'
                    ])->name('update');
                });
        });


    /*
    |--------------------------------------------------------------------------
    | Breeze Authentication Routes
    |--------------------------------------------------------------------------
    */

    require __DIR__ . '/auth.php';
