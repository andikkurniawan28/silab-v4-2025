@extends('template.master')

@section('posbrixes-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Edit Posbrix</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('posbrixes.update', $posbrix->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="spta" class="form-label">Nomorator TA</label>
                        <input type="text" name="spta" id="spta"
                            class="form-control @error('spta') is-invalid @enderror"
                            value="{{ old('spta', $posbrix->spta) }}" required autofocus>
                        @error('spta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Varietas (radio) --}}
                    <div class="mb-3">
                        <label class="form-label">Varietas</label><br>
                        @foreach ($varieties as $variety)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                    name="variety_id" id="variety_{{ $variety->id }}"
                                    value="{{ $variety->id }}"
                                    {{ old('variety_id', $posbrix->variety_id ?? 10) == $variety->id ? 'checked' : '' }}>
                                <label class="form-check-label" for="variety_{{ $variety->id }}">
                                    {{ $variety->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    {{-- Kawalan (radio) --}}
                    <div class="mb-3">
                        <label class="form-label">Kawalan</label><br>
                        @foreach ($kawalans as $kawalan)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                    name="kawalan_id" id="kawalan_{{ $kawalan->id }}"
                                    value="{{ $kawalan->id }}"
                                    {{ old('kawalan_id', $posbrix->kawalan_id ?? 1) == $kawalan->id ? 'checked' : '' }}>
                                <label class="form-check-label" for="kawalan_{{ $kawalan->id }}">
                                    {{ $kawalan->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label for="brix_posbrix" class="form-label">Brix</label>
                        <input type="number" name="brix_posbrix" id="brix_posbrix"
                            class="form-control @error('brix_posbrix') is-invalid @enderror"
                            value="{{ old('brix_posbrix', $posbrix->brix_posbrix) }}" required>
                        @error('brix_posbrix')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status (radio) --}}
                    <div class="mb-3">
                        <label class="form-label">Status</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio"
                                name="status" id="status_diterima" value="diterima"
                                {{ old('status', $posbrix->status ?? 'diterima') == 'diterima' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_diterima">Diterima</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio"
                                name="status" id="status_ditolak" value="ditolak"
                                {{ old('status', $posbrix->status) == 'ditolak' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_ditolak">Ditolak</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update
                    </button>
                    <a href="{{ route('posbrixes.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
