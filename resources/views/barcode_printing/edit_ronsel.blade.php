@extends('template.master')

@section('barcodePrinting-active', 'active')
@section('barcodePrinting-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Edit Ronsel Barcode</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('barcode_printing.editRonselProcess', $sample->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="volume" class="form-label">Volume<sub>(Hl)</sub></label>
                        <input type="number" name="volume" id="volume"
                            class="form-control @error('volume') is-invalid @enderror"
                            value="{{ old('volume', $sample->volume) }}"
                            required>
                        @error('volume')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="pan" class="form-label">Pan</label>
                        <input type="number" name="pan" id="pan"
                            class="form-control @error('pan') is-invalid @enderror"
                            value="{{ old('pan', $sample->pan) }}"
                            required>
                        @error('pan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="reef" class="form-label">Palung</label>
                        <input type="number" name="reef" id="reef"
                            class="form-control @error('reef') is-invalid @enderror"
                            value="{{ old('reef', $sample->reef) }}"
                            required>
                        @error('reef')
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
