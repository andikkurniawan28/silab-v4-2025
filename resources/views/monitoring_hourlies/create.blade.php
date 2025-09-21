@extends('template.master')

@section('monitoring_hourlies-active', 'active')
@section('input-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Tambah Monitoring Perjam</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('monitoring_hourlies.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" id="date" name="date" class="form-control"
                                value="{{ old('date', date('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="time" class="form-label">Jam</label>
                            <select id="time" name="time" class="form-control select2" required>
                                @for ($i = 0; $i <= 23; $i++)
                                    <option value="{{ $i }}" {{ (int)date('H') === $i ? 'selected' : '' }}>
                                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00 - {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}:00
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        @foreach ($spots as $spot)
                            <div class="col-md-3 mb-3">
                                <label class="form-label">{{ $spot->name }}</label>
                                <input type="number" step="any" class="form-control"
                                    name="p{{ $spot->id }}" value="{{ old('p'.$spot->id) }}">
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('monitoring_hourlies.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
