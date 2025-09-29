@extends('template.master')

@section('analisa_lain-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Tambah Analisa Lain</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('analisa_lain.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="id" class="form-label">Barcode</label>
                        <select name="id" id="id" class="form-select select2" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($samples as $s)
                                <option value="{{ $s->id }}" {{ old('id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->id }} | {{ $s->material->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        @foreach ($parameters as $p)
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="{{ $p->name }}" class="form-label">{{ $p->name }}<sub>({{ $p->unit->name }})</sub></label>
                                <input type="number" name="p{{ $p->id }}" id="p{{ $p->name }}" step="any"
                                    class="form-control @error('{{ $p->name }}') is-invalid @enderror" value="{{ old($p->name) }}">
                                @error('{{ $p->name }}')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('analisa_lain.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
