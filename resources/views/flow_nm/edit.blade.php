@extends('template.master')

@section('flow_nm-active', 'active')
@section('input-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Edit Flow NM</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('flow_nm.update', $monitoring->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" id="date" name="date" class="form-control"
                                value="{{ date('Y-m-d', strtotime($monitoring->created_at)) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="time" class="form-label">Jam</label>
                            <select id="time" name="time" class="form-control select2" required>
                                @for ($i = 0; $i <= 23; $i++)
                                    <option value="{{ $i }}" {{ $monitoring->time == $i ? 'selected' : '' }}>
                                        {{ $i }}:00 - {{ $i+1 }}:00
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th class="text-left" style="width: 30%">Titik Monitoring</th>
                                    <th class="text-left">Sebelum ({{ date('H:i', strtotime($last_monitoring->created_at)) }})</th>
                                    <th class="text-left">Sesudah</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- contoh loop spots --}}
                                @foreach ($spots as $spot)
                                    @php
                                        $col = 'p' . $spot->id;
                                        $before = $last_monitoring->{$col} ?? 0;
                                        $after = $monitoring->{$col} ?? 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $spot->name }}</td>
                                        <td>
                                            <input type="text" class="form-control" value="{{ $before }}" readonly>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="{{ $col }}"
                                                value="{{ $after }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Update
                    </button>
                    <a href="{{ route('flow_nm.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
