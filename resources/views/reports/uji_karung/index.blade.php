@extends('template.master')

@section('uji_karung-active', 'active')
@section('report-show', 'show')
@section('report-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">

        <h1 class="h3 mb-4"><strong>Uji Karung</strong></h1>

        {{-- Form filter --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form id="analysisForm" action="{{ route('reports.ujiKarung.data') }}" method="POST">
                    @csrf
                    <div class="row g-3 align-items-end">

                        {{-- Nomor Dokumen --}}
                        {{-- <div class="col-md-4">
                            <label for="nomor_dokumen" class="form-label">Nomor Dokumen</label>
                            <input type="nomor_dokumen" id="nomor_dokumen" name="nomor_dokumen" class="form-control"
                                value="No. KBA/FRM/QCT/" required>
                        </div> --}}

                        {{-- Tanggal Terima --}}
                        <div class="col-md-3">
                            <label for="arrival_date" class="form-label">Tanggal Kedatangan</label>
                            <input type="date" id="arrival_date" name="arrival_date" class="form-control"
                                value="{{ date('Y-m-d') }}" required>
                        </div>

                        {{-- Tanggal Pengujian --}}
                        <div class="col-md-3">
                            <label for="test_date" class="form-label">Tanggal Pengujian</label>
                            <input type="date" id="test_date" name="test_date" class="form-control"
                                value="{{ date('Y-m-d') }}" required>
                        </div>

                        {{-- Tanggal Cetak --}}
                        <div class="col-md-3">
                            <label for="batch" class="form-label">Batch</label>
                            <input type="number" id="batch" name="batch" class="form-control"
                                value="1" required>
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
