@extends('layouts.app')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    @if($message = Session::get('error'))
        @include('components.alert', ['message'=>$message, 'color'=>'danger'])
    @elseif($message = Session::get('success'))
        @include('components.alert', ['message'=>$message, 'color'=>'success'])
    @endif

     <!-- Content Row -->
     <div class="row">

        <div class="col-lg-4 mb-4">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    <div class="font-weight-bold text-light text-uppercase mb-1">
                        COA Kapur
                    </div>
                    <hr>
                    <form action="{{ route('coa_kapur.process') }}" method="POST" target="_blank">
                        @csrf
                        @method('POST')
                        <div class="form-group">

                            <div class="mb-3">
                              <label for="nomor_dokumen" class="form-label">Nomor Dokumen:</label>
                              <input id="nomor_dokumen" name="nomor_dokumen" type="text" class="form-control"
                                     value="No. KBA/FRM/QCT/028" required autofocus>
                            </div>

                            <div class="mb-3">
                              <label for="tanggal_terima" class="form-label">Tanggal Terima:</label>
                              <input id="tanggal_terima" name="tanggal_terima" type="date" class="form-control"
                                     value="{{ date('Y-m-d', strtotime('-1 days')) }}" required>
                            </div>

                            <div class="mb-3">
                              <label for="tanggal_pengujian" class="form-label">Tanggal Pengujian:</label>
                              <input id="tanggal_pengujian" name="tanggal_pengujian" type="date" class="form-control"
                                     value="{{ date('Y-m-d', strtotime('-1 days')) }}" required>
                            </div>

                            <div class="mb-3">
                              <label for="tanggal_cetak" class="form-label">Tanggal Cetak:</label>
                              <input id="tanggal_cetak" name="tanggal_cetak" type="date" class="form-control"
                                     value="{{ date('Y-m-d', strtotime('-1 days')) }}" required>
                            </div>

                          </div>

                        <div class="form-group">
                            <button type="submit" name="handling" value="print" class="btn btn-warning text-dark">Print <i class='fas fa-print'></i></button>
                            {{-- <button type="submit" name="handling" value="export" class="btn btn-warning text-dark">Export <i class='fas fa-download'></i></button> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>

     </div>

</div>

@endsection
