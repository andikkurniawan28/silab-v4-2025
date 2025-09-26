@extends('template.master')

@section('roles-active', 'active')
@section('master-show', 'show')
@section('master-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Tambah Jabatan</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Hak Akses</label>

                        {{-- Check All --}}
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="checkAll">
                            <label class="form-check-label fw-bold" for="checkAll">Pilih Semua</label>
                        </div>

                        <div class="row">
                            @foreach ($semua_akses as $akses)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input akses-checkbox"
                                            id="{{ $akses['id'] }}" name="{{ $akses['id'] }}" value="1"
                                            {{ old($akses['id']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $akses['id'] }}">
                                            {{ $akses['name'] }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.getElementById('checkAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.akses-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>
@endsection
