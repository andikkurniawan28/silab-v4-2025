@extends('template.master')

@section('penilaian_mbss-active', 'active')
@section('input-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Edit Penilaian MBS</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('penilaian_mbss.update', $penilaian_mbs->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" value="{{ date('Y-m-d H:i') }}" name="mbs_at">

                    <div class="mb-3">
                        <label for="id" class="form-label">ID</label>
                        <input type="number" name="id" id="id"
                            class="form-control @error('id') is-invalid @enderror"
                            value="{{ old('id', $penilaian_mbs->id) }}" readonly>
                        @error('id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Impurities sebagai checkbox --}}
                    <div class="mb-3">
                        <label class="form-label">Impurities</label><br>
                        @foreach ($impurities as $imp)
                            @php
                                $col = 'p' . $imp->id;
                                $checked = old($col, $penilaian_mbs->$col ?? 0) == 1;
                            @endphp
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox"
                                    id="impurity_{{ $imp->id }}"
                                    name="p{{ $imp->id }}"
                                    value="1" {{ $checked ? 'checked' : '' }}>
                                <label class="form-check-label" for="impurity_{{ $imp->id }}">
                                    {{ $imp->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update
                    </button>
                    <a href="{{ route('penilaian_mbss.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
