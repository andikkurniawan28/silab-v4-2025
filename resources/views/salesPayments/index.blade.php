@extends('template.master')

@section('salesPayments-active', 'active')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Daftar Pelunasan Piutang</strong></h1>

    {{-- @if(Auth()->user()->role->akses_tambah_pelunasan_hutang ?? true)
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('salesPayments.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah
        </a>
    </div>
    @endif --}}

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="salesPaymentsTable" class="table table-bordered table-striped table-sm w-100 text-center">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Customer</th>
                            <th>Total</th>
                            {{-- <th>Status</th> --}}
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
    $('#salesPaymentsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('salesPayments.index') }}",
        order: [[0, 'desc']],
        columns: [
            { data: 'code', name: 'code' },
            { data: 'date', name: 'date' },
            { data: 'contact', name: 'contact.name' },
            { data: 'grand_total', name: 'grand_total'},
            // { data: 'status', name: 'status' },
            { data: 'user', name: 'user.name' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@endsection
