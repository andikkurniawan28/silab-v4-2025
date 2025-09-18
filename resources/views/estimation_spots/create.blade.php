@extends('template.master')

@section('estimation_spots-active', 'active')
@section('estimation_spots-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Tambah Titik Taksasi</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('estimation_spots.store') }}" method="POST">
                    @csrf

                    {{-- Satuan --}}
                    <div class="mb-3">
                        <label for="unit_id" class="form-label">Satuan</label>
                        <select name="unit_id" id="unit_id" class="form-select select2" required>
                            <option value="">-- Pilih Satuan --</option>
                            @foreach ($units as $id => $name)
                                <option value="{{ $id }}" {{ old('unit_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                            required autofocus>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('estimation_spots.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
