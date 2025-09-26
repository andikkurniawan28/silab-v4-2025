@extends('template.master')

@section('ari_timbangans-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Daftar ARI Timbangan</strong></h1>

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
            ajax: "{{ route('ari_timbangans.index') }}",
            order: [[0, 'desc']],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'ari_at', name: 'ari_at' },
                { data: 'kartu_ari', name: 'kartu_ari' },
                { data: 'nomor_antrian', name: 'nomor_antrian' },
                { data: 'nopol', name: 'nopol' },
                { data: 'brix_ari', name: 'brix_ari' },
                { data: 'pol_ari', name: 'pol_ari' },
                { data: 'rendemen_ari', name: 'rendemen_ari' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
