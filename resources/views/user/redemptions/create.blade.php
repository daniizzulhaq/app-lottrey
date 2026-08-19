@extends('user.layouts.app')

@section('title', 'Redeem Virtual Credit')

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
        --danger: #e5484d;
    }

    .redeem-wrap {
        max-width: 480px;
        margin: 0 auto;
        padding: 18px 16px 40px;
        color: var(--text);
    }

    /* ===== HEADER ===== */
    .redeem-header {
        margin-bottom: 18px;
    }

    .redeem-title {
        font-size: 18px;
        font-weight: 700;
    }

    .redeem-subtitle {
        color: var(--text-muted);
        font-size: 11px;
        margin-top: 5px;
    }

    /* ===== BALANCE CARD ===== */
    .balance-card {
        position: relative;
        background: linear-gradient(145deg, var(--surface-2), var(--surface));
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 22px 20px;
        overflow: hidden;
        margin-bottom: 16px;
    }

    .balance-card::before {
        content: "";
        position: absolute;
        top: -60px;
        right: -60px;
        width: 160px;
        height: 160px;
        background: radial-gradient(circle, rgba(212,175,55,0.18), transparent 70%);
        pointer-events: none;
    }

    .balance-label {
        font-size: 11px;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 8px;
    }

    .balance-value {
        font-size: 28px;
        font-weight: 800;
        color: var(--gold-soft);
    }

    .balance-credit {
        margin-top: 4px;
        font-size: 12px;
        color: var(--text-muted);
    }

    /* ===== CARD ===== */
    .redeem-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 18px;
    }

    /* ===== FIELDS ===== */
    .field-group {
        margin-bottom: 18px;
    }

    .field-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        background: var(--surface-2);
        border: 1px solid var(--border);
        color: var(--text);
        border-radius: 10px;
        padding: 12px 14px;
        font-size: 13px;
        transition: border-color .15s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--gold);
    }

    .form-control::placeholder {
        color: var(--text-muted);
    }

    .field-hint {
        color: var(--text-muted);
        font-size: 10.5px;
        margin-top: 6px;
    }

    .field-hint strong {
        color: var(--gold-soft);
        font-weight: 700;
    }

    /* ===== NOTICE ===== */
    .redeem-notice {
        padding: 14px;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 12px;
        margin-bottom: 20px;
        color: var(--text-muted);
        font-size: 11px;
        line-height: 1.6;
    }

    .redeem-notice strong.status-pending {
        color: var(--gold-soft);
    }

    /* ===== SUBMIT ===== */
    .btn-submit {
        width: 100%;
        padding: 15px;
        border: 0;
        border-radius: 12px;
        background: var(--gold);
        color: #0b1220;
        font-size: 13.5px;
        font-weight: 800;
        cursor: pointer;
        transition: background .15s ease;
    }

    .btn-submit:hover {
        background: var(--gold-soft);
    }

    /* ===== ERRORS ===== */
    .field-error {
        color: var(--danger);
        font-size: 10.5px;
        margin-top: 6px;
    }
</style>

<div class="redeem-wrap">

    {{-- HEADER --}}
    <div class="redeem-header">
        <div class="redeem-title">Redeem</div>
        <div class="redeem-subtitle">Simulasi penukaran virtual credit.</div>
    </div>


    {{-- SALDO --}}
    <div class="balance-card">
        <div class="balance-label">Saldo Saat Ini</div>
        <div class="balance-value">
            {{ number_format(auth()->user()->balance, 0, ',', '.') }}
        </div>
        <div class="balance-credit">Virtual Credit</div>
    </div>


    <div class="redeem-card">

        <form method="POST" action="{{ route('redeem.store') }}">

            @csrf

            <div class="field-group">

                <label class="field-label">Jumlah Credit</label>

                <input
                    type="number"
                    name="amount"
                    class="form-control"
                    min="1"
                    max="{{ auth()->user()->balance }}"
                    value="{{ old('amount') }}"
                    placeholder="Masukkan jumlah credit"
                    required
                >

                <div class="field-hint">
                    Maksimal: <strong>{{ number_format(auth()->user()->balance, 0, ',', '.') }}</strong> credit
                </div>

                @error('amount')
                    <div class="field-error">{{ $message }}</div>
                @enderror

            </div>


            <div class="field-group">

                <label class="field-label">Tujuan Redeem</label>

                <input
                    type="text"
                    name="destination"
                    class="form-control"
                    value="{{ old('destination') }}"
                    placeholder="Contoh: Demo Bank - 1234567890"
                    required
                >

                @error('destination')
                    <div class="field-error">{{ $message }}</div>
                @enderror

            </div>


            <div class="redeem-notice">
                Redeem akan masuk ke status
                <strong class="status-pending">Pending</strong>
                dan harus diproses oleh admin.
                <br><br>
                Sistem ini hanya menggunakan virtual credit untuk simulasi.
            </div>


            <button type="submit" class="btn-submit">Ajukan Redeem</button>

        </form>

    </div>

</div>

@endsection
