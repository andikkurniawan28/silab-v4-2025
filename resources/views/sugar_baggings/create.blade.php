@extends('template.master')

@section('sugar_baggings-active', 'active')
@section('input-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Tambah Gula Dikarungi</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('sugar_baggings.store') }}" method="POST" id="baggingForm">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" id="date" name="date" class="form-control"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="time" class="form-label">Jam</label>
                            <select id="time" name="time" class="form-control select2" required>
                                @for ($i = 0; $i <= 23; $i++)
                                    <option value="{{ $i }}" {{ (int)date('H') === $i ? 'selected' : '' }}>
                                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00 - {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}:00
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    {{-- Tabel Input & Hasil --}}
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Line</th>
                                <th>Karung Terakhir</th>
                                <th>Karung Sekarang</th>
                                <th>Jumlah Karung</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Chronous A</strong></td>
                                <td>
                                    <input type="text" class="form-control"
                                        value="{{ $last_bagging->last_bag_id_chronous_a ?? 0 }}" readonly>
                                </td>
                                <td>
                                    <input type="number" id="last_a" name="last_bag_id_chronous_a" class="form-control"
                                        required>
                                </td>
                                <td>
                                    <input type="text" id="qty_a" name="bag_qty_from_chronous_a" class="form-control"
                                        readonly>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Chronous B</strong></td>
                                <td>
                                    <input type="text" class="form-control"
                                        value="{{ $last_bagging->last_bag_id_chronous_b ?? 0 }}" readonly>
                                </td>
                                <td>
                                    <input type="number" id="last_b" name="last_bag_id_chronous_b" class="form-control"
                                        required>
                                </td>
                                <td>
                                    <input type="text" id="qty_b" name="bag_qty_from_chronous_b" class="form-control"
                                        readonly>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Chronous C</strong></td>
                                <td>
                                    <input type="text" class="form-control"
                                        value="{{ $last_bagging->last_bag_id_chronous_c ?? 0 }}" readonly>
                                </td>
                                <td>
                                    <input type="number" id="last_c" name="last_bag_id_chronous_c" class="form-control"
                                        required>
                                </td>
                                <td>
                                    <input type="text" id="qty_c" name="bag_qty_from_chronous_c" class="form-control"
                                        readonly>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3" class="text-end">Total Gula (Kuintal)</th>
                                <td>
                                    <input type="text" id="sugar_total" name="sugar_total" class="form-control" readonly>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('sugar_baggings.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let inputs = ['last_a', 'last_b', 'last_c'];
            inputs.forEach(id => document.getElementById(id).addEventListener('input', hitung));
            document.getElementById('time').addEventListener('change', hitung);

            function hitung() {
                let lastA = parseInt(document.getElementById('last_a').value) || 0;
                let lastB = parseInt(document.getElementById('last_b').value) || 0;
                let lastC = parseInt(document.getElementById('last_c').value) || 0;
                let jam = parseInt(document.getElementById('time').value);

                // ambil dari backend
                let prevA = {{ $last_bagging->last_bag_id_chronous_a ?? 0 }};
                let prevB = {{ $last_bagging->last_bag_id_chronous_b ?? 0 }};
                let prevC = {{ $last_bagging->last_bag_id_chronous_c ?? 0 }};

                let qtyA, qtyB, qtyC;
                if (jam !== 7) {
                    qtyA = lastA - prevA;
                    qtyB = lastB - prevB;
                    qtyC = lastC - prevC;
                } else {
                    qtyA = lastA;
                    qtyB = lastB;
                    qtyC = lastC;
                }

                let total = (qtyA + qtyB + qtyC) * 0.5;

                document.getElementById('qty_a').value = qtyA;
                document.getElementById('qty_b').value = qtyB;
                document.getElementById('qty_c').value = qtyC;
                document.getElementById('sugar_total').value = total.toFixed(2);
            }
        });
    </script>
@endsection
