@extends('template.master')

@section('estimations-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Daftar Taksasi Proses</strong></h1>

        @if (Auth()->user()->role->akses_tambah_taksasi_proses)
            <div class="d-flex justify-content-between align-roles-center mb-3">
                <a href="{{ route('estimations.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah
                </a>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <table id="analysesTable" class="table table-bordered table-striped w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Timestamp</th>
                            <th>Hasil</th>
                            <th>User</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            $('#analysesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('estimations.index') }}",
                order: [
                    [0, 'desc']
                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'result',
                        name: 'result',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user',
                        name: 'user.name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endsection
