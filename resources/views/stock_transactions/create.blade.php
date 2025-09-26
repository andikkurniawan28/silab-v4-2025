@extends('template.master')

@section('stock_transactions-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Tambah Transaksi Stok</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('stock_transactions.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="type" class="form-label">Status</label>
                            <select id="type" name="type" class="form-select select2" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="masuk">masuk</option>
                                <option value="keluar">keluar</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered align-middle text-center" id="itemsTable">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 60%">Barang</th>
                                    <th style="width: 25%">Qty</th>
                                    <th style="width: 15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Baris barang dinamis -->
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-outline-primary" id="addRow">
                            <i class="bi bi-plus-circle"></i> Tambah Barang
                        </button>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('stock_transactions.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let items = @json($items);
            let rowIdx = 0;

            // Tambah baris
            $('#addRow').click(function() {
                rowIdx++;

                let options = `<option value="">-- Pilih Barang --</option>`;
                items.forEach(item => {
                    options += `<option value="${item.id}">${item.name}</option>`;
                });

                let row = `
                    <tr id="row${rowIdx}">
                        <td>
                            <select name="items[${rowIdx}][id]" class="form-select select2" required>
                                ${options}
                            </select>
                        </td>
                        <td>
                            <input type="number" step="any" name="items[${rowIdx}][qty]" class="form-control" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm removeRow" data-id="${rowIdx}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

                $('#itemsTable tbody').append(row);

                // Inisialisasi select2 untuk row baru
                $(`select[name="items[${rowIdx}][id]"]`).select2({
                    width: '100%',
                    dropdownParent: $('#itemsTable').closest('.card-body')
                });
            });

            // Hapus baris
            $(document).on('click', '.removeRow', function() {
                let id = $(this).data('id');
                $(`#row${id}`).remove();
            });
        });
    </script>
@endsection
