@extends('template.master')

@section('analysis_change_request-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Daftar Revisi Analisa</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <table id="analysis_change_requestTable" class="table table-bordered table-striped w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Barcode</th>
                            <th>Pemohon</th>
                            <th>Timestamp</th>
                            <th>Material</th>
                            <th>Sebelum</th>
                            <th>Setelah</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Mengetahui</th>
                            <th>Aksi</th>
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
        $('#analysis_change_requestTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('analysisChangeRequest.index') }}",
            order: [[0, 'desc']],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'analysis_id', name: 'analysis_id' },
                { data: 'pemohon', name: 'pemohon' },
                { data: 'created_at', name: 'created_at' },
                { data: 'material', name: 'material.name' },
                { data: 'before', name: 'before', orderable: false, searchable: false },
                { data: 'after', name: 'after', orderable: false, searchable: false },
                { data: 'description', name: 'description' },
                { data: 'status', name: 'after', orderable: false, searchable: false },
                { data: 'user', name: 'user.name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
