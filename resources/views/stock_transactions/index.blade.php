@extends('template.master')

@section('stock_transactions-active', 'active')
@section('input-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Daftar Transaksi Stok</strong></h1>

        @if (Auth()->user()->role->akses_tambah_transaksi_stok)
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('stock_transactions.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah
                </a>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <table id="stockTable" class="table table-bordered table-striped w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Timestamp</th>
                            <th>Status</th>
                            <th>Detail</th>
                            <th>User</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            $('#stockTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('stock_transactions.index') }}",
                order: [[0, 'desc']],
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'type', name: 'type' },
                    { data: 'details', name: 'details', orderable: false, searchable: false },
                    { data: 'user', name: 'user.name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });
    </script>
@endsection
