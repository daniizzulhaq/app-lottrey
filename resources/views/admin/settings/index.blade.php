@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')

@section('content')

    <div class="page-header">

        <h1>Pengaturan Website</h1>

        <p>Kelola konfigurasi umum website.</p>

    </div>


    <div class="card">

        <div class="card-header">

            <div class="card-title">
                Konfigurasi Umum
            </div>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('admin.settings.update') }}">

                @csrf
                @method('PUT')

                <div class="form-group">

                    <label class="form-label">Nama Website</label>

                    <input
                        type="text"
                        name="site_name"
                        class="form-input"
                        value="{{ old('site_name', $settings['site_name']->value ?? '') }}"
                    >

                </div>


                <div class="form-group">

                    <label class="form-label">Customer Service</label>

                    <input
                        type="text"
                        name="customer_service"
                        class="form-input"
                        value="{{ old('customer_service', $settings['customer_service']->value ?? '') }}"
                        placeholder="Nomor WhatsApp atau link kontak"
                    >

                </div>


                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0 20px;">

                    <div class="form-group">

                        <label class="form-label">Minimum Top Up</label>

                        <input
                            type="number"
                            name="minimum_topup"
                            class="form-input"
                            value="{{ old('minimum_topup', $settings['minimum_topup']->value ?? '') }}"
                            min="0"
                        >

                    </div>


                    <div class="form-group">

                        <label class="form-label">Maximum Top Up</label>

                        <input
                            type="number"
                            name="maximum_topup"
                            class="form-input"
                            value="{{ old('maximum_topup', $settings['maximum_topup']->value ?? '') }}"
                            min="0"
                        >

                    </div>


                    <div class="form-group">

                        <label class="form-label">Minimum Redeem</label>

                        <input
                            type="number"
                            name="minimum_redeem"
                            class="form-input"
                            value="{{ old('minimum_redeem', $settings['minimum_redeem']->value ?? '') }}"
                            min="0"
                        >

                    </div>


                    <div class="form-group">

                        <label class="form-label">Maximum Redeem</label>

                        <input
                            type="number"
                            name="maximum_redeem"
                            class="form-input"
                            value="{{ old('maximum_redeem', $settings['maximum_redeem']->value ?? '') }}"
                            min="0"
                        >

                    </div>

                </div>


                <div style="margin-top: 24px;">

                    <button type="submit" class="btn btn-primary">
                        Simpan Pengaturan
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
