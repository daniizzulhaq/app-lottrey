@extends('user.layouts.app')

@section('title', 'Akun')

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
        gap: 12px;
        padding: 14px 16px;
        background: var(--surface);
    }

    .app-header-back {
        width: 22px;
        height: 22px;
        color: var(--text-muted);
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .app-header-title {
        font-size: 15px;
        font-weight: 800;
        letter-spacing: .02em;
        color: var(--gold-soft);
    }

    /* ===== PROFILE CARD ===== */
    .profile-card {
        margin: 16px;
        padding: 20px 16px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--surface-2), var(--surface));
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .profile-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: var(--surface);
        border: 1px solid var(--gold);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: var(--gold-soft);
        flex-shrink: 0;
    }

    .profile-name {
        font-size: 16px;
        font-weight: 700;
        color: var(--text);
    }

    .profile-email {
        font-size: 11.5px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .profile-balance-label {
        font-size: 10.5px;
        color: var(--text-muted);
        margin-top: 8px;
    }

    .profile-balance {
        font-size: 20px;
        font-weight: 800;
        color: var(--gold-soft);
        margin-top: 2px;
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

    /* ===== MENU LIST ===== */
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

    .menu-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
    }

    .menu-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 16px;
        border-bottom: 1px solid var(--border);
        text-decoration: none;
        color: var(--text);
    }

    .menu-item:last-child { border-bottom: none; }

    .menu-item-icon {
        width: 28px;
        text-align: center;
        font-size: 15px;
        color: var(--teal);
    }

    .menu-item-label {
        flex: 1;
        font-size: 12.5px;
        font-weight: 600;
    }

    .menu-item-arrow {
        color: var(--text-muted);
        font-size: 12px;
    }

    /* ===== TRANSACTION HISTORY ===== */
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
        text-decoration: none;
        color: inherit;
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

    .empty-state {
        text-align: center;
        padding: 30px 16px;
        color: var(--text-muted);
        font-size: 12px;
    }

    /* ===== PAGINATION ===== */
    .pagination-wrap {
        padding: 16px 0 0;
    }

    .pagination-wrap a,
    .pagination-wrap span {
        font-size: 11px !important;
        color: var(--text-muted) !important;
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
        <a href="{{ route('dashboard') }}" class="app-header-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                <path d="M15 18l-6-6 6-6" />
            </svg>
        </a>
        <div class="app-header-title">Akun Saya</div>
    </div>


    {{-- ================================
         PROFILE CARD
    ================================ --}}
    <div class="profile-card">
        <div class="profile-avatar">👤</div>
        <div>
            <div class="profile-name">{{ $user->name }}</div>
            <div class="profile-email">{{ $user->email ?? $user->phone ?? '-' }}</div>
            <div class="profile-balance-label">Saldo</div>
            <div class="profile-balance">$ {{ number_format($user->balance, 2, '.', ',') }}</div>
        </div>
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

        <a href="{{ route('history.index') }}" class="quick-btn">
            <div class="quick-icon">📋</div>
            history
        </a>

    </div>


    {{-- ================================
         ACCOUNT MENU
    ================================ --}}
    <div class="section">
        <div class="section-header">
            <div class="section-title">Menu Akun</div>
        </div>

        <div class="menu-card">
            <a href="{{ route('topup.create') }}" class="menu-item">
                <div class="menu-item-icon">💳</div>
                <div class="menu-item-label">Isi Saldo</div>
                <div class="menu-item-arrow">›</div>
            </a>
            <a href="{{ route('redeem.create') }}" class="menu-item">
                <div class="menu-item-icon">💸</div>
                <div class="menu-item-label">Tarik Dana</div>
                <div class="menu-item-arrow">›</div>
            </a>
            <a href="{{ route('history.index') }}" class="menu-item">
                <div class="menu-item-icon">🎰</div>
                <div class="menu-item-label">Riwayat Permainan</div>
                <div class="menu-item-arrow">›</div>
            </a>
        </div>
    </div>


    {{-- ================================
         TRANSACTION LIST (paginated)
    ================================ --}}
    <div class="section">

        <div class="section-header">
            <div class="section-title">Riwayat Transaksi</div>
        </div>

        <div class="history-card">

            @forelse($transactions as $trx)

                <a href="{{ route('transactions.show', $trx) }}" class="history-item">
                    <div>
                        <div class="history-name">{{ ucfirst($trx->type ?? 'Transaksi') }}</div>
                        <div class="history-date">
                            {{ $trx->created_at?->format('d M Y H:i') }}
                        </div>
                    </div>

                    <div>
                        @if(($trx->type ?? '') === 'topup')
                            <strong class="win">+{{ number_format($trx->amount, 0, ',', '.') }}</strong>
                        @elseif(($trx->type ?? '') === 'withdrawal')
                            <strong class="lose">-{{ number_format($trx->amount, 0, ',', '.') }}</strong>
                        @else
                            <span class="badge-warning">{{ ucfirst($trx->status ?? '-') }}</span>
                        @endif
                    </div>
                </a>

            @empty

                <div class="empty-state">Belum ada riwayat transaksi.</div>

            @endforelse

        </div>

        <div class="pagination-wrap">
            {{ $transactions->links() }}
        </div>

    </div>

</div>


{{-- ================================
     BOTTOM NAV
================================ --}}
<div class="bottom-nav">
    <a href="{{ route('dashboard') }}" class="nav-item">
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
    <a href="{{ route('transactions.index') }}" class="nav-item active">
        <span class="nav-icon">👤</span>
        mine
    </a>
</div>

@endsection
