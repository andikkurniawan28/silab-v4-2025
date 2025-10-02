@extends('template.master')

@section('materials-active', 'active')
@section('master-show', 'show')
@section('master-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Edit Material</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('materials.update', $material->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Material</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $material->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="station_id" class="form-label">Stasiun</label>
                        <select name="station_id" id="station_id" class="form-select select2" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($stations as $id => $name)
                                <option value="{{ $id }}"
                                    {{ old('station_id', $material->station_id) == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Parameter yang Dianalisa</label>
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="checkAll">
                            <label class="form-check-label fw-bold" for="checkAll">Pilih Semua</label>
                        </div>

                        <div class="row">
                            @foreach ($parameters as $parameter)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input parameter-checkbox"
                                            id="parameter_{{ $parameter->id }}" name="parameters[]"
                                            value="{{ $parameter->id }}"
                                            {{ in_array($parameter->id, old('parameters', $material->parameters->pluck('id')->toArray())) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="parameter_{{ $parameter->id }}">
                                            {{ $parameter->name }}<sub>({{ $parameter->unit->name }})</sub>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label">Status</label>
                        <select name="is_active" id="is_active" class="form-select select2" required>
                            <option value="1" {{ old('is_active', $material->is_active) == 1 ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="0" {{ old('is_active', $material->is_active) == 0 ? 'selected' : '' }}>
                                Nonaktif
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="sampling_method" class="form-label">Metode Sampling</label>
                        <select name="sampling_method" id="sampling_method" class="form-select select2" required>
                            <option value="request"
                                {{ old('sampling_method', $material->sampling_method) == 'request' ? 'selected' : '' }}>
                                request
                            </option>
                            <option value="terjadwal"
                                {{ old('sampling_method', $material->sampling_method) == 'terjadwal' ? 'selected' : '' }}>
                                terjadwal
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('materials.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.getElementById('checkAll').addEventListener('change', function() {
            document.querySelectorAll('.parameter-checkbox').forEach(cb => cb.checked = this.checked);
        });
    </script>
@endsection
