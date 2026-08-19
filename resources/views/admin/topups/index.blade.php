@extends('admin.layouts.app')

@section('title', 'Kelola Top Up')

@section('content')

    <div class="page-header">

        <h1>Kelola Top Up</h1>

        <p>Daftar seluruh permintaan top up dari user.</p>

    </div>


    <div class="card">

        <div class="card-header">

            <div>

                <div class="card-title">
                    Daftar Top Up
                </div>

                <div class="card-description">
                    Total {{ $topups->total() }} top up
                </div>

            </div>

        </div>

        <div class="card-body">

            <form method="GET" action="{{ route('admin.topups.index') }}" style="margin-bottom: 18px;">

                <select
                    name="status"
                    class="form-select"
                    onchange="this.form.submit()"
                    style="max-width: 260px;"
                >

                    <option value="">Semua Status</option>

                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>

                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>
                        Approved
                    </option>

                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>
                        Rejected
                    </option>

                </select>

            </form>


            <div class="table-wrapper">

                <table class="table">

                    <thead>

                        <tr>

                            <th>User</th>

                            <th>Jumlah</th>

                            <th>Status</th>

                            <th>Diproses Oleh</th>

                            <th>Tanggal</th>

                            <th></th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($topups as $topup)

                            <tr>

                                <td>{{ $topup->user->name ?? '-' }}</td>

                                <td>{{ number_format($topup->amount, 0, ',', '.') }}</td>

                                <td>

                                    @if($topup->status === 'pending')

                                        <span class="badge badge-warning">Pending</span>

                                    @elseif($topup->status === 'approved')

                                        <span class="badge badge-success">Approved</span>

                                    @else

                                        <span class="badge badge-danger">Rejected</span>

                                    @endif

                                </td>

                                <td>{{ $topup->approver->name ?? '-' }}</td>

                                <td>{{ $topup->created_at->format('d M Y, H:i') }}</td>

                                <td>

                                    <a href="{{ route('admin.topups.show', $topup) }}" class="btn btn-secondary">
                                        Detail
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" style="text-align: center; color: #64748b; padding: 30px;">
                                    Belum ada data top up.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <div style="margin-top: 20px;">
                {{ $topups->appends(request()->query())->links() }}
            </div>

        </div>

    </div>

@endsection
