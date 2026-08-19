<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — {{ config('app.name', 'Draw') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --void: #0b0e14;
            --panel: #12161f;
            --panel-raised: #171c27;
            --gold: #e7a33e;
            --gold-soft: rgba(231, 163, 62, 0.14);
            --teal: #2fbfb0;
            --text-primary: #f2f1ed;
            --text-muted: #838a9c;
            --text-faint: #565d6e;
            --border: rgba(255, 255, 255, 0.08);
            --danger: #e36464;
        }

        * { box-sizing: border-box; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }

        html, body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: var(--void);
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
        }

        .shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1.05fr 1fr;
        }

        /* ---------- Brand panel ---------- */
        .brand {
            position: relative;
            background:
                radial-gradient(circle at 15% 20%, rgba(231, 163, 62, 0.10), transparent 45%),
                radial-gradient(circle at 85% 80%, rgba(47, 191, 176, 0.08), transparent 45%),
                var(--void);
            padding: 56px 64px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            border-right: 1px dashed var(--border);
        }

        .brand::before,
        .brand::after {
            content: "";
            position: absolute;
            right: -14px;
            width: 28px;
            height: 28px;
            background: var(--void);
            border-radius: 50%;
            z-index: 3;
        }
        .brand::before { top: -14px; }
        .brand::after { bottom: -14px; }

        .mark {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 18px;
            letter-spacing: 0.01em;
        }

        .mark-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--gold);
            box-shadow: 0 0 0 4px var(--gold-soft);
        }

        .ticket-id {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.14em;
            color: var(--text-faint);
            text-transform: uppercase;
        }

        .hero {
            max-width: 420px;
        }

        .eyebrow {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--teal);
            margin: 0 0 18px;
        }

        .hero h1 {
            font-family: 'Sora', sans-serif;
            font-size: 40px;
            line-height: 1.15;
            font-weight: 700;
            margin: 0 0 16px;
            letter-spacing: -0.01em;
        }

        .hero p {
            font-size: 15px;
            line-height: 1.6;
            color: var(--text-muted);
            margin: 0;
        }

        .reel {
            display: flex;
            gap: 10px;
            margin-top: 36px;
        }

        .reel-digit {
            width: 46px;
            height: 58px;
            border-radius: 10px;
            background: var(--panel-raised);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'JetBrains Mono', monospace;
            font-size: 22px;
            font-weight: 600;
            color: var(--gold);
            animation: settle 2.6s ease-in-out infinite;
        }
        .reel-digit:nth-child(2) { animation-delay: 0.15s; color: var(--teal); }
        .reel-digit:nth-child(3) { animation-delay: 0.3s; }
        .reel-digit:nth-child(4) { animation-delay: 0.45s; color: var(--teal); }

        @keyframes settle {
            0%, 100% { transform: translateY(0); opacity: 1; }
            50% { transform: translateY(-3px); opacity: 0.7; }
        }

        .brand-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            color: var(--text-faint);
            letter-spacing: 0.08em;
        }

        .brand-footer span { display: block; }
        .brand-footer strong { color: var(--text-muted); font-weight: 500; }

        /* ---------- Form panel ---------- */
        .stage {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 32px;
            background: var(--panel);
        }

        .card {
            width: 100%;
            max-width: 380px;
        }

        .card-head { margin-bottom: 32px; }

        .card-head h2 {
            font-family: 'Sora', sans-serif;
            font-size: 26px;
            font-weight: 700;
            margin: 0 0 8px;
        }

        .card-head p {
            margin: 0;
            font-size: 14px;
            color: var(--text-muted);
        }

        .status {
            background: rgba(47, 191, 176, 0.1);
            border: 1px solid rgba(47, 191, 176, 0.3);
            color: var(--teal);
            font-size: 13px;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .field { margin-bottom: 18px; }

        .field label {
            display: block;
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .field input {
            width: 100%;
            background: var(--panel-raised);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 13px 14px;
            font-size: 14.5px;
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .field input::placeholder { color: var(--text-faint); }

        .field input:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px var(--gold-soft);
        }

        .field-error {
            margin-top: 6px;
            font-size: 12.5px;
            color: var(--danger);
        }

        .row-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 26px;
        }

        .checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-muted);
        }

        .checkbox input {
            width: 15px;
            height: 15px;
            accent-color: var(--gold);
        }

        .link {
            font-size: 13px;
            color: var(--teal);
            text-decoration: none;
        }
        .link:hover { text-decoration: underline; }

        .btn-primary {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: var(--gold);
            color: #1a1204;
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 14.5px;
            letter-spacing: 0.01em;
            cursor: pointer;
            transition: transform 0.12s ease, box-shadow 0.12s ease;
        }

        .btn-primary:hover {
            box-shadow: 0 8px 24px rgba(231, 163, 62, 0.28);
            transform: translateY(-1px);
        }

        .btn-primary:focus-visible {
            outline: 2px solid var(--teal);
            outline-offset: 3px;
        }

        .switch {
            text-align: center;
            margin-top: 24px;
            font-size: 13.5px;
            color: var(--text-muted);
        }

        .switch a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 600;
        }
        .switch a:hover { text-decoration: underline; }

        @media (max-width: 880px) {
            .shell { grid-template-columns: 1fr; }
            .brand {
                border-right: none;
                border-bottom: 1px dashed var(--border);
                padding: 40px 28px;
            }
            .brand::before, .brand::after { display: none; }
            .hero h1 { font-size: 30px; }
            .reel { display: none; }
            .stage { padding: 36px 24px 56px; }
        }
    </style>
</head>
<body>
    <div class="shell">
        <!-- Brand / signature panel -->
        <div class="brand">
            <div>
                <div class="mark">
                    <span class="mark-dot"></span>
                    {{ config('app.name', 'Draw') }}
                </div>
                <div class="ticket-id" style="margin-top: 6px;">Akses Anggota · Ref. {{ now()->format('ymd') }}-LOGIN</div>
            </div>

            <div class="hero">
                <p class="eyebrow">Putaran Berikutnya Menanti</p>
                <h1>Masuk untuk memantau setiap draw&nbsp;secara real&#8209;time.</h1>
                <p>Pantau saldo, riwayat taruhan, dan hasil undian Anda dalam satu dashboard yang selalu diperbarui.</p>
                <div class="reel" aria-hidden="true">
                    <div class="reel-digit">7</div>
                    <div class="reel-digit">2</div>
                    <div class="reel-digit">4</div>
                    <div class="reel-digit">9</div>
                </div>
            </div>

            <div class="brand-footer">
                <span><strong>Aman.</strong><br>Transaksi terenkripsi</span>
                <span><strong>Transparan.</strong><br>Hasil undian tercatat</span>
            </div>
        </div>

        <!-- Form panel -->
        <div class="stage">
            <div class="card">
                <div class="card-head">
                    <h2>Masuk ke Akun</h2>
                    <p>Lanjutkan ke dashboard member Anda.</p>
                </div>

                @if (session('status'))
                    <div class="status">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               placeholder="nama@email.com" required autofocus autocomplete="username">
                        @error('email')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password"
                               placeholder="••••••••" required autocomplete="current-password">
                        @error('password')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row-between">
                        <label class="checkbox">
                            <input type="checkbox" name="remember" id="remember_me">
                            Ingat saya
                        </label>

                        @if (Route::has('password.request'))
                            <a class="link" href="{{ route('password.request') }}">Lupa password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn-primary">Masuk</button>

                    @if (Route::has('register'))
                        <p class="switch">
                            Belum punya akun?
                            <a href="{{ route('register') }}">Daftar sekarang</a>
                        </p>
                    @endif
                </form>
            </div>
        </div>
    </div>
</body>
</html>
