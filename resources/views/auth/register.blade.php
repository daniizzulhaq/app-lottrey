<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — {{ config('app.name', 'Draw') }}</title>
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
            background: var(--teal);
            box-shadow: 0 0 0 4px rgba(47, 191, 176, 0.14);
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
            color: var(--gold);
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

        .steps {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-top: 32px;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13.5px;
            color: var(--text-muted);
        }

        .step-mark {
            width: 22px;
            height: 22px;
            flex: none;
            border-radius: 50%;
            border: 1px solid var(--border);
            background: var(--panel-raised);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            color: var(--gold);
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
            max-width: 400px;
        }

        .card-head { margin-bottom: 28px; }

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

        .field { margin-bottom: 16px; }

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
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(47, 191, 176, 0.14);
        }

        .field-error {
            margin-top: 6px;
            font-size: 12.5px;
            color: var(--danger);
        }

        .field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .btn-primary {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: var(--teal);
            color: #06201d;
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 14.5px;
            letter-spacing: 0.01em;
            cursor: pointer;
            margin-top: 6px;
            transition: transform 0.12s ease, box-shadow 0.12s ease;
        }

        .btn-primary:hover {
            box-shadow: 0 8px 24px rgba(47, 191, 176, 0.28);
            transform: translateY(-1px);
        }

        .btn-primary:focus-visible {
            outline: 2px solid var(--gold);
            outline-offset: 3px;
        }

        .fine-print {
            margin-top: 14px;
            font-size: 12px;
            line-height: 1.6;
            color: var(--text-faint);
        }

        .switch {
            text-align: center;
            margin-top: 22px;
            font-size: 13.5px;
            color: var(--text-muted);
        }

        .switch a {
            color: var(--teal);
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
            .steps { display: none; }
            .stage { padding: 36px 24px 56px; }
            .field-row { grid-template-columns: 1fr; }
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
                <div class="ticket-id" style="margin-top: 6px;">Pendaftaran Anggota · Ref. {{ now()->format('ymd') }}-REG</div>
            </div>

            <div class="hero">
                <p class="eyebrow">Bergabung Sebagai Member</p>
                <h1>Satu akun untuk semua permainan &amp; undian.</h1>
                <p>Daftar gratis, top up saldo, dan ikuti setiap putaran draw langsung dari dashboard Anda.</p>
                <div class="steps">
                    <div class="step"><span class="step-mark">1</span> Isi data diri &amp; buat password</div>
                    <div class="step"><span class="step-mark">2</span> Akun member aktif otomatis</div>
                    <div class="step"><span class="step-mark">3</span> Top up saldo &amp; mulai bermain</div>
                </div>
            </div>

            <div class="brand-footer">
                <span><strong>Gratis.</strong><br>Tanpa biaya pendaftaran</span>
                <span><strong>Instan.</strong><br>Langsung masuk dashboard</span>
            </div>
        </div>

        <!-- Form panel -->
        <div class="stage">
            <div class="card">
                <div class="card-head">
                    <h2>Buat Akun Member</h2>
                    <p>Khusus pendaftaran akun member/pengguna.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="field">
                        <label for="name">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                               placeholder="Nama lengkap Anda" required autofocus autocomplete="name">
                        @error('name')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               placeholder="nama@email.com" required autocomplete="username">
                        @error('email')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field-row">
                        <div class="field">
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password"
                                   placeholder="Minimal 8 karakter" required autocomplete="new-password">
                            @error('password')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="password_confirmation">Konfirmasi</label>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                   placeholder="Ulangi password" required autocomplete="new-password">
                        </div>
                    </div>

                    <button type="submit" class="btn-primary">Daftar Sekarang</button>

                    <p class="fine-print">
                        Dengan mendaftar, akun Anda akan dibuat sebagai member biasa dan tidak memiliki akses admin.
                    </p>

                    <p class="switch">
                        Sudah punya akun?
                        <a href="{{ route('login') }}">Masuk di sini</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
