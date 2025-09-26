@extends('template.master')

@section('monitoring_hourlies-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Edit Monitoring Perjam</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('monitoring_hourlies.update', $monitoring_hourly) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" id="date" name="date" class="form-control"
                                value="{{ date('Y-m-d', strtotime($monitoring_hourly->created_at)) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="time" class="form-label">Jam</label>
                            <select id="time" name="time" class="form-control select2" required>
                                @for ($i = 0; $i <= 23; $i++)
                                    <option value="{{ $i }}"
                                        {{ (int) date('H', strtotime($monitoring_hourly->created_at)) === $i ? 'selected' : '' }}>
                                        {{ $i }}:00 - {{ $i + 1 }}:00
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        @foreach ($spots as $index => $spot)
                            <div class="col-md-3 mb-3">
                                <label class="form-label">{{ $spot->name }}</label>
                                <input type="number" step="any" class="form-control"
                                    name="p{{ $spot->id }}"
                                    value="{{ $monitoring_hourly->{'p'.$spot->id} }}">
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
