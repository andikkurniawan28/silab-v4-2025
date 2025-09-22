@extends('template.master')

@section('monitoring_hourly_spots-active', 'active')
@section('monitoring_hourly_spots-show', 'show')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Daftar Titik Monitoring Perjam</strong></h1>

    @if(Auth()->user()->role->akses_tambah_titik_monitoring_perjam)
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('monitoring_hourly_spots.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah
        </a>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="monitoring_hourly_spotTable" class="table table-bordered table-hover table-striped w-100 text-center">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Satuan</th>
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
        $('#monitoring_hourly_spotTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('monitoring_hourly_spots.index') }}",
            order: [[0, 'asc']],
            columns: [
                { data: 'name', name: 'name' },
                { data: 'unit', name: 'unit.name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
