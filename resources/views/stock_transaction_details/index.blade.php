@extends('template.master')

@section('stock_transaction_details-active', 'active')
@section('input-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Daftar Mutasi Stok</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <table id="stockTable" class="table table-bordered table-striped w-100">
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>Status</th>
                            <th>Barang</th>
                            <th>Qty</th>
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
            $('#stockTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('stock_transaction_details.index') }}",
                order: [[0, 'desc']],
                columns: [
                    { data: 'created_at', name: 'created_at' },
                    { data: 'type', name: 'type' },
                    { data: 'item', name: 'item.name' },
                    { data: 'qty', name: 'qty' },
                ]
            });
        });
    </script>
@endsection
