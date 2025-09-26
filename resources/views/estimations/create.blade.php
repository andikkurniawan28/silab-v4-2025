@extends('template.master')

@section('estimations-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Tambah Taksasi Proses</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('estimations.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        @foreach ($spots as $index => $spot)
                            <div class="col-md-3 mb-3">
                                <label class="form-label">{{ $spot->name }}</label>

                                @if ($spot->method === 'prosentase')
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control"
                                            name="p{{ $spot->id }}" value="{{ old('p' . $spot->id) }}"
                                            placeholder="Masukkan prosentase" max="100">
                                        <span class="input-group-text">%</span>
                                    </div>
                                @elseif ($spot->method === 'estimasi_massa')
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control"
                                            name="p{{ $spot->id }}" value="{{ old('p' . $spot->id) }}"
                                            placeholder="Masukkan massa" max="{{ $spot->capacity }}">
                                        <span class="input-group-text">{{ $spot->unit->name }}</span>
                                    </div>
                                @elseif ($spot->method === 'estimasi_volume')
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control"
                                            name="p{{ $spot->id }}" value="{{ old('p' . $spot->id) }}"
                                            placeholder="Masukkan volume" max="{{ $spot->capacity }}">
                                        <span class="input-group-text">{{ $spot->unit->name }}</span>
                                    </div>
                                @elseif ($spot->method === 'berapa_yang_aktif')
                                    <div class="input-group">
                                        <select name="p{{ $spot->id }}" class="form-select select2">
                                            <option value="">-- Pilih jumlah aktif --</option>
                                            @for ($i = 0; $i <= $spot->qty; $i++)
                                                <option value="{{ $i }}"
                                                    {{ old('p' . $spot->id) == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                @elseif ($spot->method === 'aktif/nonaktif')
                                    <select name="p{{ $spot->id }}" class="form-select select2">
                                        <option value="">-- Pilih status --</option>
                                        <option value="1" {{ old('p' . $spot->id) == '1' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="0" {{ old('p' . $spot->id) == '0' ? 'selected' : '' }}>Nonaktif
                                        </option>
                                    </select>
                                @endif
                            </div>
                        @endforeach
                    </div>


                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('estimations.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
