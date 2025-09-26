@extends('template.master')

@section('core_cards-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Tambah Gelas Core</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('core_cards.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="rfid" class="form-label">RFID</label>
                        <input type="text" name="rfid" id="rfid"
                            class="form-control @error('rfid') is-invalid @enderror" value="{{ old('rfid') }}" required autofocus>
                        @error('rfid')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis</label>
                        <input type="text" name="jenis" id="jenis"
                            class="form-control @error('jenis') is-invalid @enderror" value="{{ old('jenis') }}" required>
                        @error('jenis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('core_cards.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
