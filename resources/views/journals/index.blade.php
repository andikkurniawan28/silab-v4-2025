@extends('template.master')

@section('journals-active', 'active')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Daftar Jurnal Akuntansi</strong></h1>

    @if(Auth()->user()->role->akses_tambah_jurnal)
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('journals.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah
        </a>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="journalTable" class="table table-bordered table-striped table-sm w-100 text-center">
                    <thead>
                        <tr>
                            {{-- <th>#</th> --}}
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            {{-- <th>Debit</th>
                            <th>Credit</th> --}}
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
    $('#journalTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('journals.index') }}",
        order: [[0, 'desc']],
        columns: [
            // { data: 'id', name: 'id' },
            { data: 'code', name: 'code' },
            { data: 'date', name: 'date' },
            { data: 'description', name: 'description' },
            // { data: 'debit', name: 'debit' },
            // { data: 'credit', name: 'credit' },
            { data: 'user', name: 'user.name' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@endsection
