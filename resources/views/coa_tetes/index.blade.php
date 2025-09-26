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
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <div class="font-weight-bold text-light text-uppercase mb-1">
                        COA Tetes
                    </div>
                    <hr>
                    <form action="{{ route('coa_tetes.process') }}" method="POST" target="_blank">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <div class="input-group">
                                <input id="text1" name="nomor_dokumen" type="text" class="form-control" value="No. KBA/FRM/QCT/" required autofocus>
                            </div>
                            <div class="input-group">
                                <input id="text1" name="created_at" type="date" class="form-control" value="{{ date("Y-m-d", strtotime(date("Y-m-d") . "-1 days")); }}" required>
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
