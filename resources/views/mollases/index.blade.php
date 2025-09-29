@extends('template.master')

@section('mollases-active', 'active')
@section('master-show', 'show')
@section('master-active', 'active')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Daftar Timbangan Tetes</strong></h1>

    @if(Auth()->user()->role->akses_tambah_timbangan_tetes)
    <div class="d-flex justify-content-between align-roles-center mb-3">
        <a href="{{ route('mollases.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah
        </a>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="roleTable" class="table table-bordered table-hover table-striped w-100 text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Timestamp</th>
                            <th>Bruto</th>
                            <th>Tarra</th>
                            <th>Netto</th>
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
        $('#roleTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('mollases.index') }}",
            order: [[0, 'asc']],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'created_at', name: 'created_at' },
                { data: 'bruto', name: 'bruto' },
                { data: 'tarra', name: 'tarra' },
                { data: 'netto', name: 'netto' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
