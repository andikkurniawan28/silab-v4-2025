@extends('template.master')

@section('sugar_baggings-active', 'active')
@section('input-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Daftar Gula Dikarungi</strong></h1>

        @if (Auth()->user()->role->akses_tambah_gula_dikarungi)
            <div class="d-flex justify-content-between align-roles-center mb-3">
                <a href="{{ route('sugar_baggings.create') }}" class="btn btn-primary">
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
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>A<sub>(Karung)</sub></th>
                            <th>B<sub>(Karung)</sub></th>
                            <th>C<sub>(Karung)</sub></th>
                            <th>Total<sub>(Ku)</sub></th>
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
                ajax: "{{ route('sugar_baggings.index') }}",
                order: [
                    [0, 'desc']
                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'time',
                        name: 'time'
                    },
                    {
                        data: 'bag_qty_from_chronous_a',
                        name: 'bag_qty_from_chronous_a'
                    },
                    {
                        data: 'bag_qty_from_chronous_b',
                        name: 'bag_qty_from_chronous_b'
                    },
                    {
                        data: 'bag_qty_from_chronous_c',
                        name: 'bag_qty_from_chronous_c'
                    },
                    {
                        data: 'sugar_total',
                        name: 'sugar_total'
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
