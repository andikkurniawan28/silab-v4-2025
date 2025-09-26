@extends('template.master')

@section('monitoring_shiftly_spots-active', 'active')
@section('master-show', 'show')
@section('master-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Edit Titik Monitoring Pershift</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('monitoring_shiftly_spots.update', $monitoring_shiftly_spot->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', $monitoring_shiftly_spot->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="unit_id" class="form-label">Satuan</label>
                        <select name="unit_id" id="unit_id" class="form-select select2" required>
                            @foreach ($units as $id => $name)
                                <option value="{{ $id }}"
                                    {{ $monitoring_shiftly_spot->unit_id == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('monitoring_shiftly_spots.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
