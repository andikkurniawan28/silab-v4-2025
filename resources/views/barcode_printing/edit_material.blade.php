@extends('template.master')

@section('stations-active', 'active')
@section('stations-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Edit Material Barcode</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('barcode_printing.editMaterialProcess', $sample->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="material_id" class="form-label">Material</label>
                        <select name="material_id" id="material_id"
                            class="form-control select2 @error('material_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Material --</option>
                            @foreach ($materials as $material)
                                <option value="{{ $material->id }}"
                                    {{ old('material_id', $sample->material_id) == $material->id ? 'selected' : '' }}>
                                    {{ $material->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('material_id')
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
