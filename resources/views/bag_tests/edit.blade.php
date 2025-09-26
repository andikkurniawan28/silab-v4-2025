@extends('template.master')

@section('bag_tests-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Edit Uji Karung</strong></h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('bag_tests.update', $bag_test->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Kedatangan</label>
                        <input type="date" name="arrival_date" value="{{ $bag_test->arrival_date }}" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Uji</label>
                        <input type="date" name="test_date" value="{{ $bag_test->test_date }}" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Batch</label>
                        <input type="number" name="batch" value="{{ $bag_test->batch }}" class="form-control" required>
                    </div>
                </div>

                {{-- Dimensi Outer --}}
                <h5 class="mt-4">Dimensi Outer</h5>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Panjang (cm)</label>
                        <input type="number" step="0.01" name="p_nilai_outer" value="{{ $bag_test->p_nilai_outer }}" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label>Keterangan</label>
                        <input type="text" name="p_ket_outer" value="{{ $bag_test->p_ket_outer }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Lebar (cm)</label>
                        <input type="number" step="0.01" name="l_nilai_outer" value="{{ $bag_test->l_nilai_outer }}" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label>Keterangan</label>
                        <input type="text" name="l_ket_outer" value="{{ $bag_test->l_ket_outer }}" class="form-control">
                    </div>
                </div>

                {{-- Berat Outer --}}
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Berat Outer (gram)</label>
                        <input type="number" step="0.01" name="berat_outer" value="{{ $bag_test->berat_outer }}" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label>Keterangan</label>
                        <input type="text" name="berat_outer_ket" value="{{ $bag_test->berat_outer_ket }}" class="form-control">
                    </div>
                </div>

                {{-- Mesh --}}
                <h5 class="mt-4">Mesh</h5>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Mesh Alas</label>
                        <input type="number" step="0.01" name="mesh_alas" value="{{ $bag_test->mesh_alas }}" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label>Keterangan</label>
                        <input type="text" name="mesh_ket_alas" value="{{ $bag_test->mesh_ket_alas }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Mesh Tinggi</label>
                        <input type="number" step="0.01" name="mesh_tinggi" value="{{ $bag_test->mesh_tinggi }}" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label>Keterangan</label>
                        <input type="text" name="mesh_ket_tinggi" value="{{ $bag_test->mesh_ket_tinggi }}" class="form-control">
                    </div>
                </div>

                {{-- Denier --}}
                <h5 class="mt-4">Denier</h5>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Denier Nilai</label>
                        <input type="number" step="0.01" name="denier_nilai" value="{{ $bag_test->denier_nilai }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-3">
                        <label>Keterangan</label>
                        <input type="text" name="denier_ket" value="{{ $bag_test->denier_ket }}" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Update
                </button>
                <a href="{{ route('bag_tests.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function hitungDenier() {
        const pOuter = parseFloat(document.querySelector('[name="p_nilai_outer"]').value) || 0;
        const lOuter = parseFloat(document.querySelector('[name="l_nilai_outer"]').value) || 0;
        const meshAlas = parseFloat(document.querySelector('[name="mesh_alas"]').value) || 0;
        const meshTinggi = parseFloat(document.querySelector('[name="mesh_tinggi"]').value) || 0;
        const beratOuter = parseFloat(document.querySelector('[name="berat_outer"]').value) || 0;

        const denierField = document.querySelector('[name="denier_nilai"]');

        if (pOuter === 0 || lOuter === 0 || meshAlas === 0 || meshTinggi === 0 || beratOuter === 0) {
            denierField.value = '';
            return;
        }

        const CM_TO_INCHI = 0.3937007874;
        const INCHI_TO_METER = 0.0254;

        const W = parseFloat((lOuter * CM_TO_INCHI).toFixed(1));
        const H = parseFloat((pOuter * CM_TO_INCHI).toFixed(1));

        const bagian1 = (CM_TO_INCHI * pOuter * meshAlas * H) * INCHI_TO_METER;
        const bagian2 = (CM_TO_INCHI * lOuter * meshTinggi * W) * INCHI_TO_METER;
        const ukuran = (bagian1 + bagian2) * 2;

        if (ukuran === 0) {
            denierField.value = '';
            return;
        }

        const denier = (beratOuter / ukuran) * 9000;
        denierField.value = Math.round(denier);
    }

    document.addEventListener("DOMContentLoaded", function () {
        const inputs = [
            '[name="p_nilai_outer"]',
            '[name="l_nilai_outer"]',
            '[name="mesh_alas"]',
            '[name="mesh_tinggi"]',
            '[name="berat_outer"]'
        ];

        inputs.forEach(selector => {
            const el = document.querySelector(selector);
            if (el) {
                el.addEventListener('input', hitungDenier);
            }
        });

        // Jalankan sekali saat load (biar isi default langsung dihitung)
        hitungDenier();
    });
</script>
@endsection
