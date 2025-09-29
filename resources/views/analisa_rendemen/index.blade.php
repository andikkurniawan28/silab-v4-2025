@extends('template.master')

@section('analisa_rendemen-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Daftar Analisa Rendemen</strong></h1>

        @if (Auth()->user()->role->akses_tambah_analisa_rendemen)
            <div class="d-flex justify-content-between align-roles-center mb-3">
                <a href="{{ route('analisa_rendemen.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah
                </a>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <table id="analysesTable" class="table table-bordered table-striped w-100">
                    <thead>
                        <tr>
                            <th>Barcode</th>
                            <th>Timestamp</th>
                            <th>Material</th>
                            <th>Brix</th>
                            <th>Pol</th>
                            <th>Pol Baca</th>
                            <th>HK</th>
                            <th>R</th>
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
                ajax: "{{ route('analisa_rendemen.index') }}",
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
                        data: 'material',
                        name: 'material.name'
                    },
                    {
                        data: 'p1',
                        name: 'p1'
                    },
                    {
                        data: 'p2',
                        name: 'p2'
                    },
                    {
                        data: 'p3',
                        name: 'p3'
                    },
                    {
                        data: 'p4',
                        name: 'p4'
                    },
                    {
                        data: 'p5',
                        name: 'p5'
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
