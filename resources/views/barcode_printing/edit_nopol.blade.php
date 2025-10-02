@extends('template.master')

@section('barcodePrinting-active', 'active')
@section('barcodePrinting-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Edit Nopol Barcode</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('barcode_printing.editNopolProcess', $sample->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nopol" class="form-label">Nopol</label>
                        <input type="text" name="nopol" id="nopol"
                            class="form-control @error('nopol') is-invalid @enderror"
                            value="{{ old('nopol', $sample->nopol) }}"
                            required>
                        @error('nopol')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
