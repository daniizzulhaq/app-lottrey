@extends('user.layouts.app')

@section('title', 'Home')

@section('content')

<style>
    :root {
        --bg: #0b1220;
        --surface: #101b30;
        --surface-2: #16233c;
        --border: #223151;
        --gold: #d4af37;
        --gold-soft: #f2d675;
        --teal: #22d3c7;
        --text: #e8ecf5;
        --text-muted: #7c8aa8;
        --win: #2ecc71;
        --lose: #e5484d;
    }

    body { background: var(--bg); }

    .app-wrap {
        max-width: 480px;
        margin: 0 auto;
        color: var(--text);
        padding-bottom: 90px;
    }

    /* ===== HEADER ===== */
    .app-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px;
        background: var(--surface);
    }

    .app-logo {
        font-size: 15px;
        font-weight: 800;
        letter-spacing: .03em;
        color: var(--gold-soft);
        line-height: 1.1;
    }

    .app-logo small {
        display: block;
        font-size: 11px;
        font-weight: 400;
        font-style: italic;
        color: var(--teal);
    }

    .app-header-icon {
        width: 22px;
        height: 22px;
        color: var(--text-muted);
    }

    /* ===== BANNER ===== */
    .banner-carousel {
        position: relative;
        width: 100%;
        aspect-ratio: 16 / 9;
        overflow: hidden;
        background: var(--surface-2);
    }

    .banner-carousel img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .banner-dots {
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        gap: 6px;
    }

    .banner-dots span {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: rgba(255,255,255,0.35);
    }

    .banner-dots span.active {
        background: var(--teal);
        width: 16px;
        border-radius: 4px;
    }

    /* ===== WELCOME / BALANCE ===== */
    .welcome-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px 6px;
    }

    .welcome-text {
        font-size: 13px;
        color: var(--text-muted);
    }

    .welcome-text strong {
        color: var(--text);
    }

    .notice-pill {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        color: var(--text-muted);
        background: var(--surface-2);
        border: 1px solid var(--border);
        padding: 4px 10px;
        border-radius: 999px;
    }

    .balance-row {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 0 16px 16px;
        font-size: 24px;
        font-weight: 800;
        color: var(--gold-soft);
    }

    .balance-row span {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-muted);
    }

    /* ===== QUICK ACTIONS ===== */
    .quick-actions {
        display: flex;
        justify-content: space-around;
        padding: 0 16px 20px;
    }

    .quick-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        color: var(--text-muted);
        font-size: 11px;
    }

    .quick-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: var(--surface-2);
        border: 1px solid var(--border);
        font-size: 18px;
        color: var(--teal);
    }

    /* ===== GAME GRID ===== */
    .game-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px 8px;
        padding: 0 16px 20px;
    }

    .game-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        color: var(--text-muted);
    }

    .game-circle {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, var(--surface-2), var(--surface));
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        font-size: 24px;
        transition: border-color .15s ease, transform .15s ease;
    }

    .game-item:hover .game-circle {
        border-color: var(--gold);
        transform: translateY(-2px);
    }

    .game-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .game-label {
        font-size: 10.5px;
        text-align: center;
        line-height: 1.2;
        color: var(--text-muted);
    }

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 30px 16px;
        color: var(--text-muted);
        font-size: 12px;
    }

    /* ===== PROMO BANNER ===== */
    .promo-banner {
        margin: 0 16px 20px;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid var(--border);
    }

    .promo-banner img {
        width: 100%;
        display: block;
    }

    /* ===== HISTORY ===== */
    .section {
        padding: 0 16px 20px;
    }

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .section-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--text);
    }

    .section-link {
        font-size: 11px;
        color: var(--teal);
        text-decoration: none;
        font-weight: 600;
    }

    .history-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
    }

    .history-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 13px 16px;
        border-bottom: 1px solid var(--border);
    }

    .history-item:last-child { border-bottom: none; }

    .history-name {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text);
    }

    .history-date {
        font-size: 10.5px;
        color: var(--text-muted);
        margin-top: 3px;
    }

    .win { color: var(--win); font-size: 12.5px; }
    .lose { color: var(--lose); font-size: 12.5px; }

    .badge-warning {
        display: inline-block;
        padding: 3px 9px;
        border-radius: 999px;
        background: rgba(212,175,55,0.15);
        color: var(--gold-soft);
        font-size: 10.5px;
        font-weight: 600;
    }

    /* ===== BOTTOM NAV ===== */
    .bottom-nav {
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
        max-width: 480px;
        margin: 0 auto;
        display: flex;
        background: var(--surface);
        border-top: 1px solid var(--border);
        z-index: 40;
    }

    .nav-item {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 3px;
        padding: 10px 0 12px;
        text-decoration: none;
        font-size: 10.5px;
        color: var(--text-muted);
    }

    .nav-item.active {
        color: var(--teal);
    }

    .nav-icon { font-size: 18px; }
</style>

<div class="app-wrap">

    {{-- ================================
         HEADER
    ================================ --}}
    <div class="app-header">
        <div class="app-logo">
            GRAND LISBOA
            <small>Macau</small>
        </div>
        <svg class="app-header-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M3 6h18M3 6l9 7 9-7M3 6v12h18V6" />
        </svg>
    </div>


    {{-- ================================
         BANNER CAROUSEL
    ================================ --}}
    <div class="banner-carousel">
        @if(($banners ?? collect())->count())
            <img src="{{ Storage::url($banners->first()->image) }}" alt="Banner">
        @else
            <img src="https://images.unsplash.com/photo-1508964942454-1a56651d54ac?w=800&q=60" alt="Banner">
        @endif
        <div class="banner-dots">
            @forelse(($banners ?? collect(range(1,3))) as $i => $b)
                <span class="{{ $i === 0 ? 'active' : '' }}"></span>
            @endforeach
        </div>
    </div>


    {{-- ================================
         WELCOME + BALANCE
    ================================ --}}
    <div class="welcome-row">
        <div class="welcome-text">Welcome, <strong>{{ auth()->user()->name }}</strong></div>
        <div class="notice-pill">⋯ Notice</div>
    </div>

    <div class="balance-row">
        <span>$</span>{{ number_format(auth()->user()->balance, 2, '.', ',') }}
    </div>


    {{-- ================================
         QUICK ACTIONS
    ================================ --}}
    <div class="quick-actions">

        <a href="{{ route('topup.create') }}" class="quick-btn">
            <div class="quick-icon">💳</div>
            recharge
        </a>

        <a href="{{ route('redeem.create') }}" class="quick-btn">
            <div class="quick-icon">💸</div>
            withdrawal
        </a>

        <a href="{{ route('transactions.index') }}" class="quick-btn">
            <div class="quick-icon">👤</div>
            account
        </a>

    </div>


    {{-- ================================
         GAME GRID
    ================================ --}}
    <div class="game-grid">

        @forelse($games ?? [] as $game)

            <a href="{{ route('games.show', $game) }}" class="game-item">
                <div class="game-circle">
                    @if($game->icon)
                        <img src="{{ Storage::url($game->icon) }}" alt="{{ $game->name }}">
                    @else
                        🎰
                    @endif
                </div>
                <div class="game-label">{{ Str::limit($game->name, 14) }}</div>
            </a>

        @empty

            <div class="empty-state">Belum ada game aktif.</div>

        @endforelse

    </div>





    {{-- ================================
         RECENT HISTORY
    ================================ --}}
    <div class="section">

        <div class="section-header">
            <div class="section-title">Permainan Terakhir</div>
            <a href="{{ route('history.index') }}" class="section-link">Semua History</a>
        </div>

        <div class="history-card">

            @forelse($recentBets ?? [] as $bet)

                <div class="history-item">
                    <div>
                        <div class="history-name">{{ $bet->game->name }}</div>
                        <div class="history-date">
                            {{ $bet->created_at?->format('d M Y H:i') }}
                        </div>
                    </div>

                    <div>
                        @if($bet->status === 'win')
                            <strong class="win">+{{ number_format($bet->amount, 0, ',', '.') }}</strong>
                        @elseif($bet->status === 'lose')
                            <strong class="lose">-{{ number_format($bet->amount, 0, ',', '.') }}</strong>
                        @else
                            <span class="badge-warning">{{ ucfirst($bet->status) }}</span>
                        @endif
                    </div>
                </div>

            @empty

                <div class="empty-state">Belum ada riwayat permainan.</div>

            @endforelse

        </div>

    </div>

</div>


{{-- ================================
     BOTTOM NAV
================================ --}}
<div class="bottom-nav">
    <a href="{{ route('dashboard') }}" class="nav-item active">
        <span class="nav-icon">🏠</span>
        front page
    </a>
    <a href="{{ route('history.index') }}" class="nav-item">
        <span class="nav-icon">📋</span>
        betting record
    </a>
    <a href="#" class="nav-item">
        <span class="nav-icon">🎧</span>
        customer service
    </a>
    <a href="{{ route('transactions.index') }}" class="nav-item">
        <span class="nav-icon">👤</span>
        mine
    </a>
</div>

@endsection
