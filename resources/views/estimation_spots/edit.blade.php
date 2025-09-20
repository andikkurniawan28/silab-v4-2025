@extends('template.master')

@section('estimation_spots-active', 'active')
@section('estimation_spots-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Edit Titik Taksasi</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('estimation_spots.update', $estimation_spot->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Satuan --}}
                    <div class="mb-3">
                        <label for="unit_id" class="form-label">Satuan</label>
                        <select name="unit_id" id="unit_id" class="form-select select2" required>
                            @foreach ($units as $id => $name)
                                <option value="{{ $id }}"
                                    {{ old('unit_id', $estimation_spot->unit_id) == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', $estimation_spot->name) }}" required>
                    </div>

                    {{-- Qty --}}
                    <div class="mb-3">
                        <label for="qty" class="form-label">Qty</label>
                        <input type="number" name="qty" id="qty" class="form-control"
                            value="{{ old('qty', $estimation_spot->qty) }}" required>
                    </div>

                    {{-- Kapasitas --}}
                    <div class="mb-3">
                        <label for="capacity" class="form-label">Kapasitas</label>
                        <input type="number" step="any" name="capacity" id="capacity" class="form-control"
                            value="{{ old('capacity', $estimation_spot->capacity) }}" required>
                    </div>

                    {{-- Metode --}}
                    <div class="mb-3">
                        <label for="method" class="form-label">Metode</label>
                        <select name="method" id="method" class="form-select select2" required>
                            @foreach (['prosentase', 'estimasi_massa', 'estimasi_volume', 'berapa_yang_aktif', 'aktif/nonaktif'] as $method)
                                <option value="{{ $method }}"
                                    {{ old('method', $estimation_spot->method) == $method ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $method)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Update
                    </button>
                    <a href="{{ route('estimation_spots.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </form>

            </div>
        </div>
    </div>
@endsection
