@extends('template.master')

@section('item_transactions-active', 'active')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Daftar Mutasi Barang</strong></h1>

    @if(Auth()->user()->role->akses_tambah_transaksi_barang)
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('item_transactions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah
        </a>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="itemTransactionTable" class="table table-bordered table-striped table-sm w-100 text-center">
                    <thead>
                        <tr>
                            {{-- <th>ID</th> --}}
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Gudang</th>
                            <th>Admin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(function() {
    $('#itemTransactionTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('item_transactions.index') }}",
        order: [[0, 'desc']],
        columns: [
            // { data: 'id', name: 'id' },
            { data: 'code', name: 'code' },
            { data: 'date', name: 'date' },
            { data: 'description', name: 'description' },
            { data: 'warehouse', name: 'warehouse.name' },
            { data: 'user', name: 'user.name' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@endsection
