@extends('template.master')

@section('coa_kapur-active', 'active')
@section('report-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">

        <h1 class="h3 mb-4"><strong>COA Kapur</strong></h1>

        {{-- Form filter --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form id="analysisForm" action="{{ route('reports.coaKapur.data') }}" method="POST">
                    @csrf
                    <div class="row g-3 align-items-end">

                        {{-- Nomor Dokumen --}}
                        <div class="col-md-4">
                            <label for="nomor_dokumen" class="form-label">Nomor Dokumen</label>
                            <input type="nomor_dokumen" id="nomor_dokumen" name="nomor_dokumen" class="form-control"
                                value="No. KBA/FRM/QCT/" required>
                        </div>

                        {{-- Tanggal Terima --}}
                        <div class="col-md-4">
                            <label for="tanggal_terima" class="form-label">Tanggal Terima</label>
                            <input type="date" id="tanggal_terima" name="tanggal_terima" class="form-control"
                                value="{{ date('Y-m-d') }}" required>
                        </div>

                        {{-- Tanggal Pengujian --}}
                        <div class="col-md-4">
                            <label for="tanggal_pengujian" class="form-label">Tanggal Pengujian</label>
                            <input type="date" id="tanggal_pengujian" name="tanggal_pengujian" class="form-control"
                                value="{{ date('Y-m-d') }}" required>
                        </div>

                        {{-- Tanggal Cetak --}}
                        <div class="col-md-4">
                            <label for="tanggal_cetak" class="form-label">Tanggal Cetak</label>
                            <input type="date" id="tanggal_cetak" name="tanggal_cetak" class="form-control"
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
