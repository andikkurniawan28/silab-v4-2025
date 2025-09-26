@extends('template.master')

@section('penilaian_mbss-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Daftar Penilaian MBS</strong></h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="roleTable" class="table table-bordered table-hover table-striped w-100 text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Timestamp</th>
                            <th>Nomor Antrian</th>
                            <th>Nopol</th>
                            <th>Kotoran</th>
                            <th>Rafaksi</th>
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
            ajax: "{{ route('penilaian_mbss.index') }}",
            order: [[0, 'desc']],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'mbs_at', name: 'mbs_at' },
                { data: 'nomor_antrian', name: 'nomor_antrian' },
                { data: 'nopol', name: 'nopol' },
                { data: 'impurities', name: 'impurities', orderable: false, searchable: false },
                { data: 'rafaksi', name: 'rafaksi' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
