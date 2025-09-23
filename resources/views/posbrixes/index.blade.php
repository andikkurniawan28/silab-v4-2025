@extends('template.master')

@section('posbrixes-active', 'active')
@section('input-show', 'show')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Daftar Posbrix</strong></h1>

    @if(Auth()->user()->role->akses_tambah_posbrix)
    <div class="d-flex justify-content-between align-roles-center mb-3">
        <a href="{{ route('posbrixes.create') }}" class="btn btn-primary">
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
                            <th>Nomorator TA</th>
                            <th>Varietas</th>
                            <th>Kawalan</th>
                            <th>Status</th>
                            <th>Brix</th>
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
            ajax: "{{ route('posbrixes.index') }}",
            order: [[0, 'desc']],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'created_at', name: 'created_at' },
                { data: 'spta', name: 'spta' },
                { data: 'variety', name: 'variety.name' },
                { data: 'kawalan', name: 'kawalan.name' },
                { data: 'status', name: 'status' },
                { data: 'brix_posbrix', name: 'brix_posbrix' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
