@extends('template.master')

@section('analisa_ketel-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Tambah Analisa Ketel</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('analisa_ketel.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="id" class="form-label">Barcode</label>
                        <select name="id" id="id" class="form-select select2" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($samples as $s)
                                <option value="{{ $s->id }}">
                                    {{ $s->id }} | {{ $s->material->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="parameter-container">
                        <div class="row">
                            @foreach ($parameters as $pm)
                                @php
                                    $param = $pm->parameter;
                                    $fieldName = 'p' . $param->id;
                                @endphp
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="{{ $fieldName }}" class="form-label">
                                            {{ $param->name }}
                                            @if ($param->unit)
                                                ({{ $param->unit->name }})
                                            @endif
                                        </label>
                                        <input type="number" step="any" id="{{ $fieldName }}"
                                            name="{{ $fieldName }}" class="form-control" value="{{ old($fieldName) }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>


                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('analisa_ketel.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
