@extends('template.master')

@section('coa_tetes-active', 'active')
@section('report-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">

        <h1 class="h3 mb-4"><strong>COA Tetes</strong></h1>

        {{-- Form filter --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form id="analysisForm" action="{{ route('reports.coaTetes.data') }}" method="POST">
                    @csrf
                    <div class="row g-3 align-items-end">

                        {{-- Nomor Dokumen --}}
                        <div class="col-md-4">
                            <label for="nomor_dokumen" class="form-label">Nomor Dokumen</label>
                            <input type="nomor_dokumen" id="nomor_dokumen" name="nomor_dokumen" class="form-control"
                                value="No. KBA/FRM/QCT/" required>
                        </div>

                        {{-- Tanggal --}}
                        <div class="col-md-4">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" id="date" name="date" class="form-control"
                                value="{{ date('Y-m-d') }}" required>
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
