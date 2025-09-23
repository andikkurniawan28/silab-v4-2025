@extends('template.master')

@section('core_samples-active', 'active')
@section('input-show', 'show')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Daftar Core Sample</strong></h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="roleTable" class="table table-bordered table-hover table-striped w-100 text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Timestamp</th>
                            <th>Nomor Gelas</th>
                            <th>Nomor Antrian</th>
                            <th>Nopol</th>
                            <th>Brix</th>
                            <th>Pol</th>
                            <th>R</th>
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
            ajax: "{{ route('core_samples.index') }}",
            order: [[0, 'desc']],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'core_at', name: 'core_at' },
                { data: 'kartu_core', name: 'kartu_core' },
                { data: 'nomor_antrian', name: 'nomor_antrian' },
                { data: 'nopol', name: 'nopol' },
                { data: 'brix_core', name: 'brix_core' },
                { data: 'pol_core', name: 'pol_core' },
                { data: 'rendemen_core', name: 'rendemen_core' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
