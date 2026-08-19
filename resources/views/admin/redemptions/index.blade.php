@extends('admin.layouts.app')

@section('title', 'Kelola Redeem')

@section('content')

    <div class="page-header">

        <h1>Kelola Redeem</h1>

        <p>Daftar seluruh permintaan redeem dari user.</p>

    </div>


    <div class="card">

        <div class="card-header">

            <div>

                <div class="card-title">
                    Daftar Redeem
                </div>

                <div class="card-description">
                    Total {{ $redemptions->total() }} redeem
                </div>

            </div>

        </div>

        <div class="card-body">

            <form method="GET" action="{{ route('admin.redemptions.index') }}" style="margin-bottom: 18px;">

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

                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>
                        Completed
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

                        @forelse($redemptions as $redemption)

                            <tr>

                                <td>{{ $redemption->user->name ?? '-' }}</td>

                                <td>{{ number_format($redemption->amount, 0, ',', '.') }}</td>

                                <td>

                                    @if($redemption->status === 'pending')

                                        <span class="badge badge-warning">Pending</span>

                                    @elseif($redemption->status === 'completed')

                                        <span class="badge badge-success">Completed</span>

                                    @else

                                        <span class="badge badge-danger">Rejected</span>

                                    @endif

                                </td>

                                <td>{{ $redemption->approver->name ?? '-' }}</td>

                                <td>{{ $redemption->created_at->format('d M Y, H:i') }}</td>

                                <td>

                                    <a href="{{ route('admin.redemptions.show', $redemption) }}" class="btn btn-secondary">
                                        Detail
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" style="text-align: center; color: #64748b; padding: 30px;">
                                    Belum ada data redeem.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <div style="margin-top: 20px;">
                {{ $redemptions->appends(request()->query())->links() }}
            </div>

        </div>

    </div>

@endsection
