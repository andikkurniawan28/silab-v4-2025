@extends('template.master')

@section('monitoring_shiftlies-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Edit Monitoring Pershift</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('monitoring_shiftlies.update', $monitoring_shiftly) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" id="date" name="date" class="form-control"
                                value="{{ date('Y-m-d', strtotime($monitoring_shiftly->created_at)) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="shift" class="form-label">Shift</label>
                            <select id="shift" name="shift" class="form-control select2" required>
                                <option value="pagi" {{ $monitoring_shiftly->shift === 'pagi' ? 'selected' : '' }}>pagi</option>
                                <option value="sore" {{ $monitoring_shiftly->shift === 'sore' ? 'selected' : '' }}>sore</option>
                                <option value="malam" {{ $monitoring_shiftly->shift === 'malam' ? 'selected' : '' }}>malam</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        @foreach ($spots as $index => $spot)
                            <div class="col-md-3 mb-3">
                                <label class="form-label">{{ $spot->name }}</label>
                                <input type="number" step="any" class="form-control"
                                    name="p{{ $spot->id }}"
                                    value="{{ $monitoring_shiftly->{'p'.$spot->id} }}">
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('monitoring_shiftlies.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
