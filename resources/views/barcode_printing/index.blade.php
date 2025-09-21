@extends('template.master')

@section('barcodePrinting-active', 'active')
@section('barcodePrinting-show', 'show')
@section("barcodePrinting{$station_id}-active", 'active')

@section('content')
    <div class="container-fluid py-0 px-0">

        <h1 class="h3 mb-4"><strong>Cetak Barcode {{ $station }}</strong></h1>

        <div class="mb-3">
            <div class="input-group">
                <input type="text" id="material-search" class="form-control" placeholder="Cari material...">
                <span class="input-group-text bg-white">
                    <i class="bi bi-search"></i>
                </span>
            </div>
        </div>

        <div class="row" id="materials-container">
            @foreach ($materials as $material)
                <div class="col-lg-3 md-3 mb-4 material-item">
                    <div class="card bg-gradient-danger text-white text-xs shadow">
                        <div class="card-body">
                            <div class="font-weight-bold text-light text-uppercase mb-1 material-name">
                                {{ strtoupper($material->name) }}
                            </div>
                            <form action="{{ route('barcode_printing.process') }}" method="POST" class="form-prevent"
                                id="formID">
                                @csrf
                                @method('POST')

                                <input type="hidden" name="material_id" value="{{ $material->id }}">

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <input type="date" name="date" class="form-control"
                                            value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="time" name="time" class="form-control"
                                            value="{{ date('H:i') }}">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-warning text-dark" id="submitID246"
                                    onclick="this.form.submit(); this.disabled=true;">
                                    Cetak
                                    <i class="fas fa-print"></i>
                                </button>
                            </form>

                            <br>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#material-search').on('keyup', function() {
                let keyword = $(this).val().toLowerCase();
                $('#materials-container .material-item').filter(function() {
                    $(this).toggle($(this).find('.material-name').text().toLowerCase().indexOf(
                        keyword) > -1);
                });
            });
        });
    </script>
@endsection
