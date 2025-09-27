@extends('template.master')

@section('estimations-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Edit Taksasi Proses</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('estimations.update', $estimation->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        @foreach ($spots as $index => $spot)
                            @php
                                $fieldName = 'p' . $spot->id;
                                $value = old($fieldName, $estimation->{$fieldName});
                            @endphp

                            <div class="col-md-3 mb-3">
                                <label class="form-label">{{ $spot->name }}</label>

                                @if ($spot->method === 'prosentase')
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control"
                                            name="{{ $fieldName }}" value="{{ $value }}"
                                            placeholder="Masukkan prosentase" max="100">
                                        <span class="input-group-text">%</span>
                                    </div>

                                @elseif ($spot->method === 'estimasi_massa')
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control"
                                            name="{{ $fieldName }}" value="{{ $value }}"
                                            placeholder="Masukkan massa" max="{{ $spot->capacity }}">
                                        <span class="input-group-text">{{ $spot->unit->name }}</span>
                                    </div>

                                @elseif ($spot->method === 'estimasi_volume')
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control"
                                            name="{{ $fieldName }}" value="{{ $value }}"
                                            placeholder="Masukkan volume" max="{{ $spot->capacity }}">
                                        <span class="input-group-text">{{ $spot->unit->name }}</span>
                                    </div>

                                @elseif ($spot->method === 'berapa_yang_aktif')
                                    <select name="{{ $fieldName }}" class="form-select select2">
                                        <option value="">-- Pilih jumlah aktif --</option>
                                        @for ($i = 0; $i <= $spot->qty; $i++)
                                            <option value="{{ $i }}" {{ $value == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>

                                {{-- @elseif ($spot->method === 'aktif/nonaktif')
                                    <select name="{{ $fieldName }}" class="form-select select2">
                                        <option value="">-- Pilih status --</option>
                                        <option value="1" {{ $value == '1' ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ $value == '0' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                @endif --}}

                                @elseif ($spot->method === 'aktif/nonaktif')
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="p{{ $spot->id }}" id="p{{ $spot->id }}" value="1"
                                            {{ $value == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="p{{ $spot->id }}" id="label_p{{ $spot->id }}"
                                            style="{{ old('p' . $spot->id, '0') == '1' ? 'color: #198754;' : 'color: #dc3545;' }}">
                                            {{ $value == '1' ? '✅ Aktif' : '❌ Nonaktif' }}
                                        </label>
                                    </div>
                                    <script>
                                    document.getElementById('p{{ $spot->id }}').addEventListener('change', function() {
                                        const label = document.getElementById('label_p{{ $spot->id }}');
                                        if (this.checked) {
                                            label.innerHTML = '✅ Aktif';
                                            label.style.color = '#198754';
                                        } else {
                                            label.innerHTML = '❌ Nonaktif';
                                            label.style.color = '#dc3545';
                                        }
                                    });
                                    </script>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Update
                    </button>
                    <a href="{{ route('estimations.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
