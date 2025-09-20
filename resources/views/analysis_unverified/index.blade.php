@extends('template.master')

@section('analysis_unverified-active', 'active')
@section('input-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Verifikasi Mandor</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form id="verifyForm" method="POST" action="{{ route('analysis_unverified.process') }}">
                    @csrf
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="bi bi-check-circle"></i> Verifikasi
                        </button>
                    </div>
                    <table id="analysesTable" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="checkAll">
                                </th>
                                <th>ID</th>
                                <th>Timestamp</th>
                                <th>Material</th>
                                <th>Hasil</th>
                                <th>Status</th>
                                <th>User</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            let table = $('#analysesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('analysis_unverified.index') }}",
                order: [
                    [1, 'desc']
                ],
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `<input type="checkbox" name="ids[]" class="row-check" value="${data}">`;
                        }
                    },
                    {
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
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Check All
            $('#checkAll').on('click', function() {
                $('.row-check').prop('checked', $(this).prop('checked'));
            });
        });
    </script>
@endsection
