@extends('template.master')

@section('analyses-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3">
            <strong>Ajukan Revisi Analisa</strong>
        </h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('analysisChangeRequest.process', $analysis->id) }}" method="POST">
                    @csrf

                    <input name="analysis_id" type="hidden" value="{{ $analysis->id }}">
                    <input name="material_id" type="hidden" value="{{ $analysis->material_id }}">

                    <div class="row">

                        {{-- Kiri: Hasil Analisa --}}
                        <div class="col-md-6 border-end">
                            <h5 class="mb-3">Hasil Analisa</h5>
                            <div class="row g-3">
                                @foreach ($parameters as $pm)
                                    @php
                                        $param = $pm->parameter;
                                        $colName = 'p' . $param->id;
                                        $value = old($colName, $analysis->{$colName});
                                        $oldValue = old($colName . '_old', $analysis->{$colName});
                                    @endphp
                                    <div class="col-md-4 mb-3">
                                        <label for="{{ $colName }}" class="form-label">
                                            {{ $param->name }}
                                            @if ($param->unit)
                                                <small>({{ $param->unit->name }})</small>
                                            @endif
                                        </label>
                                        <input type="text" name="{{ $colName }}" id="{{ $colName }}"
                                            class="form-control p-field @error($colName) is-invalid @enderror"
                                            value="{{ $value }}" data-old-field="{{ $colName }}_old">

                                        {{-- Mirror hidden field --}}
                                        <input type="hidden" name="{{ $colName }}_old" id="{{ $colName }}_old"
                                            value="{{ $oldValue }}">

                                        @error($colName)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Kanan: Informasi Sampel --}}
                        <div class="col-md-6">
                            <h5 class="mb-3">Informasi Sampel</h5>
                            <div class="row g-3">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Barcode</label>
                                    <input type="text" class="form-control" value="{{ $analysis->id }}" readonly>
                                </div>

                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Material</label>
                                    <input type="text" class="form-control" value="{{ $analysis->material->name }}"
                                        readonly>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="volume" class="form-label">Volume<sub>(Hl)</sub></label>
                                    <input type="number" step="0.01" name="volume" id="volume"
                                        class="form-control @error('volume') is-invalid @enderror"
                                        value="{{ old('volume', $analysis->volume) }}">
                                    @error('volume')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="pan" class="form-label">Pan</label>
                                    <input type="number" name="pan" id="pan"
                                        class="form-control @error('pan') is-invalid @enderror"
                                        value="{{ old('pan', $analysis->pan) }}">
                                    @error('pan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="reef" class="form-label">Palung</label>
                                    <input type="number" name="reef" id="reef"
                                        class="form-control @error('reef') is-invalid @enderror"
                                        value="{{ old('reef', $analysis->reef) }}">
                                    @error('reef')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="nopol" class="form-label">Nopol</label>
                                    <input type="text" name="nopol" id="nopol"
                                        class="form-control @error('nopol') is-invalid @enderror"
                                        value="{{ old('nopol', $analysis->nopol) }}">
                                    @error('nopol')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5 class="mb-3">Diajukan kepada</h5>

                            <div class="col-md-12 mb-3">
                                <label for="user_id" class="form-label">User</label>
                                <select name="user_id" id="user_id" class="form-select select2" required>
                                    <option value="">-- Pilih Kasubsie --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Keterangan</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('analyses.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const p1 = document.getElementById("p1");
            const p2 = document.getElementById("p2");
            const p4 = document.getElementById("p4");
            const p5 = document.getElementById("p5");

            // ambil faktor dari backend
            const faktorRendemenNpp = {{ $factors['Faktor Rendemen NPP'] ?? 0 }};
            const faktorMellaseNpp = {{ $factors['Faktor Mellase NPP'] ?? 0 }};

            function updateP4() {
                let v1 = parseFloat(p1.value) || 0;
                let v2 = parseFloat(p2.value) || 0;
                if (v1 > 0) {
                    p4.value = ((v2 / v1) * 100).toFixed(2);
                } else {
                    p4.value = "";
                }
                updateP5();
            }

            function updateP2() {
                let v1 = parseFloat(p1.value) || 0;
                let v4 = parseFloat(p4.value) || 0;
                if (v1 > 0) {
                    p2.value = ((v4 * v1) / 100).toFixed(2);
                }
                updateP5();
            }

            function updateP5() {
                if (!p5) return;
                let v1 = parseFloat(p1.value) || 0;
                let v2 = parseFloat(p2.value) || 0;
                let hasil = faktorRendemenNpp * (v2 - faktorMellaseNpp * (v1 - v2));
                p5.value = hasil.toFixed(2);
            }

            if (p1 && p2 && p4) {
                p1.addEventListener("input", updateP4);
                p2.addEventListener("input", updateP4);
                p4.addEventListener("input", updateP2);
            }

            // jalankan awal supaya langsung keisi
            updateP4();
            updateP5();
        });
    </script>
@endsection
