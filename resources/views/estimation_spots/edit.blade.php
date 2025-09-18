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

                <div class="mb-3">
                    <label for="unit_id" class="form-label">Satuan</label>
                    <select name="unit_id" id="unit_id" class="form-select select2" required>
                        @foreach($units as $id => $name)
                            <option value="{{ $id }}" {{ $estimation_spot->unit_id == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" id="name" class="form-control"
                           value="{{ old('name', $estimation_spot->name) }}" required>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('estimation_spots.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
