@extends('template.master')

@section('parameters-active', 'active')
@section('parameters-show', 'show')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Daftar Parameter</strong></h1>

    @if(Auth()->user()->role->akses_tambah_parameter)
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('parameters.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah
        </a>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="parameterTable" class="table table-bordered table-hover table-striped table-sm w-100 text-center">
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
        $('#parameterTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('parameters.index') }}",
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
