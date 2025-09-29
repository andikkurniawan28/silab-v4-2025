@extends('template.master')

@section('mollases-active', 'active')
@section('master-show', 'show')
@section('master-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Tambah Timbangan Tetes</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('mollases.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="created_at" class="form-label">Timestamp</label>
                        <input type="text" name="created_at" id="created_at"
                            class="form-control @error('created_at') is-invalid @enderror"
                            value="{{ old('created_at', date('Y-m-d H:i:s')) }}" required autofocus>
                        @error('created_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bruto" class="form-label">Bruto</label>
                        <input type="number" name="bruto" id="bruto"
                            class="form-control @error('bruto') is-invalid @enderror" value="{{ old('bruto') }}" required>
                        @error('bruto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tarra" class="form-label">Tarra</label>
                        <input type="number" name="tarra" id="tarra"
                            class="form-control @error('tarra') is-invalid @enderror" value="{{ old('tarra') }}" required>
                        @error('tarra')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="netto" class="form-label">Netto</label>
                        <input type="number" name="netto" id="netto"
                            class="form-control @error('netto') is-invalid @enderror" value="{{ old('netto') }}" readonly>
                        @error('netto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('mollases.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const brutoInput = document.getElementById('bruto');
            const tarraInput = document.getElementById('tarra');
            const nettoInput = document.getElementById('netto');

            function calculateNetto() {
                const bruto = parseFloat(brutoInput.value) || 0;
                const tarra = parseFloat(tarraInput.value) || 0;
                const netto = bruto - tarra;

                nettoInput.value = netto >= 0 ? netto : 0;
            }

            // Event listeners untuk input bruto dan tarra
            brutoInput.addEventListener('input', calculateNetto);
            tarraInput.addEventListener('input', calculateNetto);

            // Juga hitung saat halaman pertama kali dimuat (jika ada nilai awal)
            calculateNetto();
        });
    </script>
@endsection
