@extends('template.master')

@section('analisa_ketel-active', 'active')
@section('input-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Daftar Analisa Ketel</strong></h1>

        @if (Auth()->user()->role->akses_tambah_analisa_ketel)
            <div class="d-flex justify-content-between align-roles-center mb-3">
                <a href="{{ route('analisa_ketel.create') }}" class="btn btn-primary">
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
                            <th>Material</th>
                            <th>Hasil</th>
                            <th>Status</th>
                            <th>User</th>
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
                ajax: "{{ route('analisa_ketel.index') }}",
                order: [
                    [0, 'desc']
                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'material',
                        name: 'material.name'
                    },
                    {
                        data: 'result',
                        name: 'result',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user',
                        name: 'user.name'
                    },
                ]
            });
        });
    </script>
@endsection
