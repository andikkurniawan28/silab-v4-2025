@extends('template.master')

@section('monitoring_hourlies-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Daftar Monitoring Perjam</strong></h1>

        @if (Auth()->user()->role->akses_tambah_monitoring_perjam)
            <div class="d-flex justify-content-between align-roles-center mb-3">
                <a href="{{ route('monitoring_hourlies.create') }}" class="btn btn-primary">
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
                ajax: "{{ route('monitoring_hourlies.index') }}",
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
