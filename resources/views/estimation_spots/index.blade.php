@extends('template.master')

@section('estimation_spots-active', 'active')
@section('master-show', 'show')
@section('master-active', 'active')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Daftar Titik Taksasi</strong></h1>

    @if(Auth()->user()->role->akses_tambah_titik_taksasi)
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('estimation_spots.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah
        </a>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="estimation_spotTable" class="table table-bordered table-hover table-striped w-100 text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Satuan</th>
                            <th>Jumlah</th>
                            <th>Kapasitas</th>
                            <th>Metode</th>
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
        $('#estimation_spotTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('estimation_spots.index') }}",
            order: [[0, 'asc']],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'unit', name: 'unit.name' },
                { data: 'qty', name: 'qty' },
                { data: 'capacity', name: 'capacity' },
                { data: 'method', name: 'method' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
