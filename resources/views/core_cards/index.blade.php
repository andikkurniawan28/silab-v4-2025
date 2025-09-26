@extends('template.master')

@section('core_cards-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Daftar Gelas Core</strong></h1>

    @if(Auth()->user()->role->akses_tambah_gelas_core)
    <div class="d-flex justify-content-between align-roles-center mb-3">
        <a href="{{ route('core_cards.create') }}" class="btn btn-primary">
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
                            {{-- <th>ID</th> --}}
                            <th>RFID</th>
                            <th>Jenis</th>
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
            ajax: "{{ route('core_cards.index') }}",
            order: [[0, 'asc']],
            columns: [
                // { data: 'id', name: 'id' },
                { data: 'rfid', name: 'rfid' },
                { data: 'jenis', name: 'jenis' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
