@extends('template.master')

@section('barcodePrinting-active', 'active')
@section('barcodePrinting-show', 'show')
@section("barcodePrinting{$station_id}-active", 'active')

@section('content')
    <div class="container-fluid py-0 px-0">

        <h1 class="h3 mb-4"><strong>Cetak Barcode {{ $station }}</strong></h1>

        <div class="row">

            @foreach ($materials as $material)
                <div class="col-lg-3 md-3 mb-4">
                    <div class="card bg-primary text-white text-xs shadow">
                        <div class="card-body">
                            <div class="font-weight-bold text-light text-uppercase mb-1">
                                {{ strtoupper($material->name) }}
                            </div>
                            <form action="{{ route('barcode_printing.process') }}" method="POST" class="form-prevent"
                                id="formID">
                                @csrf @method('POST')
                                <input type="hidden" name="material_id" value="{{ $material->id }}">
                                <button type="submit" class="btn btn-warning btn-sm text-dark" id="submitID246"
                                    onclick="this.form.submit(); this.disabled=true;">
                                    Cetak
                                    <i class="fas fa-print"></i> </button>
                            </form>
                            <br>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>


    </div>
@endsection
