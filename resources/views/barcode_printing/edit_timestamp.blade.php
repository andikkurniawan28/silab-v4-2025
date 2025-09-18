@extends('template.master')

@section('barcodePrinting-active', 'active')
@section('barcodePrinting-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Edit Timestamp Barcode</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('barcode_printing.editTimestampProcess', $sample->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="created_at" class="form-label">Timestamp</label>
                        <input type="text" name="created_at" id="created_at"
                            class="form-control @error('created_at') is-invalid @enderror"
                            value="{{ old('created_at', $sample->created_at) }}"
                            required>
                        @error('created_at')
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
