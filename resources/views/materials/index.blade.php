@extends('template.master')

@section('materials-active', 'active')
@section('materials-show', 'show')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Daftar Material</strong></h1>

    <div class="d-flex justify-content-between align-materials-center mb-3">
        <a href="{{ route('materials.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="materialTable" class="table table-bordered table-hover table-striped table-sm w-100 text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Stasiun</th>
                            <th>Parameter</th>
                            <th>Status</th>
                            <th>Metode Sampling</th>
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
        $('#materialTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('materials.index') }}",
            order: [[0, 'asc']],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'station', name: 'station.name' },
                { data: 'parameters', name: 'parameters', orderable: false, searchable: false },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'sampling_method', name: 'sampling_method' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
