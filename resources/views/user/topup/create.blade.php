@extends('user.layouts.app')

@section('title', 'Top Up')

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

    .topup-wrap {
        max-width: 480px;
        margin: 0 auto;
        padding: 18px 16px 40px;
        color: var(--text);
    }

    /* ===== HEADER ===== */
    .topup-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 18px;
    }

    .topup-title {
        font-size: 18px;
        font-weight: 700;
    }

    .topup-subtitle {
        color: var(--text-muted);
        font-size: 11px;
        margin-top: 5px;
    }

    .btn-back {
        display: flex;
        align-items: center;
        gap: 4px;
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--text-muted);
        padding: 8px 12px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: border-color .15s ease;
    }

    .btn-back:hover {
        border-color: var(--gold);
        color: var(--text);
    }

    /* ===== BALANCE CARD ===== */
    .balance-card {
        position: relative;
        background: linear-gradient(145deg, var(--surface-2), var(--surface));
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 22px 20px;
        overflow: hidden;
        margin-bottom: 18px;
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
    .topup-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 18px;
        margin-bottom: 16px;
    }

    .card-title {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 4px;
    }

    .card-hint {
        font-size: 10.5px;
        color: var(--text-muted);
        margin-bottom: 14px;
    }

    /* ===== AMOUNT GRID ===== */
    .amount-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .amount-radio {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .amount-option {
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 16px 10px;
        text-align: center;
        background: var(--surface-2);
        color: var(--text);
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: border-color .15s ease, background .15s ease, transform .15s ease;
    }

    .amount-option:hover {
        border-color: var(--gold);
        transform: translateY(-1px);
    }

    .amount-radio:checked + .amount-option {
        border-color: var(--gold);
        background: rgba(212,175,55,0.12);
        color: var(--gold-soft);
    }

    /* ===== CUSTOM AMOUNT ===== */
    .field-group {
        margin-top: 16px;
    }

    .field-label {
        display: block;
        font-size: 11px;
        color: var(--text-muted);
        margin-bottom: 8px;
    }

    .input-with-prefix {
        position: relative;
    }

    .input-prefix {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 14px;
        font-weight: 600;
        pointer-events: none;
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

    .form-control.with-prefix {
        padding-left: 28px;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--gold);
    }

    .form-control::placeholder {
        color: var(--text-muted);
    }

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%237c8aa8' d='M1 1l5 5 5-5'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 34px;
    }

    /* ===== FILE UPLOAD ===== */
    .file-drop {
        position: relative;
        border: 1px dashed var(--border);
        border-radius: 12px;
        padding: 22px 14px;
        text-align: center;
        background: var(--surface-2);
        cursor: pointer;
        transition: border-color .15s ease;
    }

    .file-drop:hover {
        border-color: var(--gold);
    }

    .file-drop input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }

    .file-drop-icon {
        font-size: 26px;
        margin-bottom: 6px;
    }

    .file-drop-text {
        font-size: 12px;
        color: var(--text);
        font-weight: 600;
    }

    .file-drop-sub {
        font-size: 10.5px;
        color: var(--text-muted);
        margin-top: 3px;
    }

    .preview-container {
        display: none;
        margin-top: 14px;
        text-align: center;
    }

    .preview-container img {
        max-width: 100%;
        max-height: 240px;
        border-radius: 12px;
        border: 1px solid var(--border);
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
</style>

<div class="topup-wrap">

    {{-- HEADER --}}
    <div class="topup-header">
        <div>
            <div class="topup-title">Top Up Virtual Credit</div>
            <div class="topup-subtitle">Tambahkan virtual credit ke akun kamu.</div>
        </div>

        <a href="{{ route('dashboard') }}" class="btn-back">← Back</a>
    </div>


    {{-- SALDO --}}
    <div class="balance-card">
        <div class="balance-label">Saldo Saat Ini</div>
        <div class="balance-value">
            ${{ number_format(auth()->user()->balance ?? 0, 2, '.', ',') }}
        </div>
        <div class="balance-credit">Virtual Credit</div>
    </div>


    <form action="{{ route('topup.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        {{-- NOMINAL --}}
        <div class="topup-card">

            <div class="card-title">Pilih Nominal</div>
            <div class="card-hint">Klik salah satu nominal di bawah ini.</div>

            <div class="amount-grid">

                @foreach([10, 50, 100, 500, 1000] as $amount)

                    <label style="position:relative; display:block;">

                        <input
                            type="radio"
                            name="amount"
                            value="{{ $amount }}"
                            class="amount-radio"
                            onchange="selectAmount(this)"
                        >

                        <div class="amount-option">
                            ${{ number_format($amount, 2, '.', ',') }}
                        </div>

                    </label>

                @endforeach

            </div>

            <div class="field-group">
                <label class="field-label">Atau masukkan nominal ($)</label>

                <div class="input-with-prefix">
                    <span class="input-prefix">$</span>
                    <input
                        type="number"
                        name="custom_amount"
                        min="1"
                        step="0.01"
                        class="form-control with-prefix"
                        placeholder="75.00"
                    >
                </div>
            </div>

        </div>


        {{-- PAYMENT METHOD --}}
        <div class="topup-card">

            <div class="card-title">Metode Pembayaran</div>
            <div class="card-hint">Pilih channel pembayaran yang kamu gunakan.</div>

            <select name="payment_method" required class="form-control">
                <option value="">-- Pilih Metode --</option>
                <option value="bank_transfer">Bank Transfer</option>
                <option value="ewallet">E-Wallet</option>
            </select>

        </div>


        {{-- BUKTI --}}
        <div class="topup-card">

            <div class="card-title">Bukti Pembayaran</div>
            <div class="card-hint">Upload bukti transfer untuk simulasi.</div>

            <div class="file-drop">

                <input
                    type="file"
                    name="proof"
                    accept="image/jpeg,image/png,image/jpg"
                    required
                    onchange="previewImage(event)"
                >

                <div class="file-drop-icon">📎</div>
                <div class="file-drop-text">Klik untuk upload gambar</div>
                <div class="file-drop-sub">JPG atau PNG, maks. beberapa MB</div>

            </div>

            <div id="preview-container" class="preview-container">
                <img id="preview" alt="Preview bukti pembayaran">
            </div>

        </div>


        {{-- SUBMIT --}}
        <button type="submit" class="btn-submit">Submit Top Up</button>

    </form>

</div>


<script>

function selectAmount(input)
{
    // radio + adjacent CSS sudah menghandle style,
    // tapi custom_amount ikut dikosongkan biar tidak ambigu
    document.querySelector('input[name="custom_amount"]').value = '';
}

document
    .querySelector('input[name="custom_amount"]')
    .addEventListener('input', function () {

        document
            .querySelectorAll('input[name="amount"]')
            .forEach(function (radio) {
                radio.checked = false;
            });

    });


function previewImage(event)
{
    const file = event.target.files[0];

    if (!file) return;

    const reader = new FileReader();

    reader.onload = function (e) {
        document.getElementById('preview').src = e.target.result;
        document.getElementById('preview-container').style.display = 'block';
    };

    reader.readAsDataURL(file);
}

</script>

@endsection
