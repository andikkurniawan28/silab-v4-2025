@extends('template.master')

@section('mutasi_barang-active', 'active')
@section('report-show', 'show')
@section('report-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">

        <h1 class="h3 mb-4"><strong>Mutasi Barang</strong></h1>

        {{-- Form filter --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form id="analysisForm">
                    @csrf
                    <div class="row g-3 align-items-end">

                        {{-- Barang --}}
                        <div class="col-md-3">
                            <label for="item_id" class="form-label">Barang</label>
                            <select name="item_id" id="item_id" class="form-select select2" required>
                                <option value="">-- Pilih --</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Mulai --}}
                        <div class="col-md-3">
                            <label for="mulai" class="form-label">Mulai</label>
                            <input type="date" id="mulai" name="mulai" class="form-control"
                                value="{{ date('Y-m-d') }}" required>
                        </div>

                        {{-- Sampai Dengan --}}
                        <div class="col-md-3">
                            <label for="sampai_dengan" class="form-label">Sampai Dengan</label>
                            <input type="date" id="sampai_dengan" name="sampai_dengan" class="form-control"
                                value="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Hasil Laporan --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped text-dark" id="resultTable">
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>Status</th>
                            <th>User</th>
                            <th>Qty</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center">Silakan filter data dulu</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#analysisForm').on('submit', function(e) {
                e.preventDefault();

                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('reports.mutasiBarang.data') }}",
                    method: "POST",
                    data: formData,
                    success: function(res) {
                        console.log(res);

                        let rows = '';

                        // Tampilkan saldo awal
                        rows += `
                            <tr class="table-secondary fw-bold">
                                <td colspan="4">Saldo Awal</td>
                                <td>${res.saldo_awal}</td>
                            </tr>
                        `;

                        if (res.mutasi.length > 0) {
                            $.each(res.mutasi, function(i, item) {
                                rows += `
                                    <tr>
                                        <td>${
                                            (() => {
                                                const d = new Date(item.created_at);
                                                const y = d.getFullYear();
                                                const m = String(d.getMonth() + 1).padStart(2, '0');
                                                const day = String(d.getDate()).padStart(2, '0');
                                                const h = String(d.getHours()).padStart(2, '0');
                                                const i = String(d.getMinutes()).padStart(2, '0');
                                                return `${y}-${m}-${day} ${h}:${i}`;
                                            })()
                                        }</td>
                                        <td>${item.type}</td>
                                        <td>${item.user.name}</td>
                                        <td>${item.qty}</td>
                                        <td>${item.running_saldo}</td>
                                    </tr>
                                `;
                            });
                        } else {
                            rows +=
                                `<tr><td colspan="5" class="text-center">Tidak ada data</td></tr>`;
                        }

                        // Tampilkan saldo akhir
                        rows += `
                            <tr class="table-secondary fw-bold">
                                <td colspan="4">Saldo Akhir</td>
                                <td>${res.saldo_akhir}</td>
                            </tr>
                        `;

                        $('#resultTable tbody').html(rows);
                    },
                    error: function(xhr) {
                        alert("Gagal memuat data");
                    }
                });
            });
        });
    </script>
@endsection
