@extends('template.master')

@section('analisa_rendemen-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Tambah Analisa Rendemen</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('analisa_rendemen.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="id" class="form-label">Barcode</label>
                        <select name="id" id="id" class="form-select select2" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($samples as $s)
                                <option value="{{ $s->id }}" {{ old('id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->id }} | {{ $s->material->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="brix" class="form-label">Brix</label>
                                <input type="number" name="p1" id="brix" step="any"
                                    class="form-control @error('brix') is-invalid @enderror" value="{{ old('brix') }}"
                                    required>
                                @error('brix')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="pol" class="form-label">Pol</label>
                                <input type="number" name="p2" id="pol" step="any"
                                    class="form-control @error('pol') is-invalid @enderror"
                                    value="{{ old('pol') }}" required>
                                @error('pol')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pol_baca" class="form-label">Pol Baca</label>
                                <input type="number" name="p3" id="pol_baca" step="any"
                                    class="form-control @error('pol_baca') is-invalid @enderror" value="{{ old('pol_baca') }}"
                                    required>
                                @error('pol_baca')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="hk" class="form-label">HK</label>
                                <input type="number" name="p4" id="hk" step="any"
                                    class="form-control @error('hk') is-invalid @enderror" value="{{ old('hk') }}"
                                    readonly>
                                @error('hk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="rendemen" class="form-label">Rendemen</label>
                                <input type="number" name="p5" id="rendemen" step="any"
                                    class="form-control @error('rendemen') is-invalid @enderror" value="{{ old('rendemen') }}"
                                    readonly>
                                @error('rendemen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('analisa_rendemen.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const fr = {{ $fr }};
            const fm = {{ $fm }};

            let isCalculating = false; // Flag untuk mencegah infinite loop

            // Fungsi untuk mendapatkan nilai BJ berdasarkan Brix
            function getBJFromBrix(brix) {
                brix = parseFloat(brix);

                // Mapping Brix ke BJ berdasarkan range yang diberikan
                if (brix >= 0.0 && brix < 0.1) return 0.99653;
                else if (brix >= 0.1 && brix < 0.2) return 0.99692;
                else if (brix >= 0.2 && brix < 0.3) return 0.99731;
                else if (brix >= 0.3 && brix < 0.4) return 0.99771;
                else if (brix >= 0.4 && brix < 0.5) return 0.99810;
                else if (brix >= 0.5 && brix < 0.6) return 0.99849;
                else if (brix >= 0.6 && brix < 0.7) return 0.99888;
                else if (brix >= 0.7 && brix < 0.8) return 0.99928;
                else if (brix >= 0.8 && brix < 0.9) return 0.99967;
                else if (brix >= 0.9 && brix < 1.0) return 1.00006;
                else if (brix >= 1.0 && brix < 1.1) return 1.00045;
                else if (brix >= 1.1 && brix < 1.2) return 1.00085;
                else if (brix >= 1.2 && brix < 1.3) return 1.00124;
                else if (brix >= 1.3 && brix < 1.4) return 1.00163;
                else if (brix >= 1.4 && brix < 1.5) return 1.00202;
                else if (brix >= 1.5 && brix < 1.6) return 1.00242;
                else if (brix >= 1.6 && brix < 1.7) return 1.00281;
                else if (brix >= 1.7 && brix < 1.8) return 1.00320;
                else if (brix >= 1.8 && brix < 1.9) return 1.00359;
                else if (brix >= 1.9 && brix < 2.0) return 1.00399;
                else if (brix >= 2.0 && brix < 2.1) return 1.00438;
                else if (brix >= 2.1 && brix < 2.2) return 1.00477;
                else if (brix >= 2.2 && brix < 2.3) return 1.00516;
                else if (brix >= 2.3 && brix < 2.4) return 1.00556;
                else if (brix >= 2.4 && brix < 2.5) return 1.00595;
                else if (brix >= 2.5 && brix < 2.6) return 1.00634;
                else if (brix >= 2.6 && brix < 2.7) return 1.00673;
                else if (brix >= 2.7 && brix < 2.8) return 1.00713;
                else if (brix >= 2.8 && brix < 2.9) return 1.00752;
                else if (brix >= 2.9 && brix < 3.0) return 1.00791;
                else if (brix >= 3.0 && brix < 3.1) return 1.00830;
                else if (brix >= 3.1 && brix < 3.2) return 1.00870;
                else if (brix >= 3.2 && brix < 3.3) return 1.00909;
                else if (brix >= 3.3 && brix < 3.4) return 1.00948;
                else if (brix >= 3.4 && brix < 3.5) return 1.00988;
                else if (brix >= 3.5 && brix < 3.6) return 1.01027;
                else if (brix >= 3.6 && brix < 3.7) return 1.01066;
                else if (brix >= 3.7 && brix < 3.8) return 1.01105;
                else if (brix >= 3.8 && brix < 3.9) return 1.01145;
                else if (brix >= 3.9 && brix < 4.0) return 1.01184;
                else if (brix >= 4.0 && brix < 4.1) return 1.01223;
                else if (brix >= 4.1 && brix < 4.2) return 1.01262;
                else if (brix >= 4.2 && brix < 4.3) return 1.01302;
                else if (brix >= 4.3 && brix < 4.4) return 1.01341;
                else if (brix >= 4.4 && brix < 4.5) return 1.01380;
                else if (brix >= 4.5 && brix < 4.6) return 1.01419;
                else if (brix >= 4.6 && brix < 4.7) return 1.01459;
                else if (brix >= 4.7 && brix < 4.8) return 1.01498;
                else if (brix >= 4.8 && brix < 4.9) return 1.01537;
                else if (brix >= 4.9 && brix < 5.0) return 1.01576;
                else if (brix >= 5.0 && brix < 5.1) return 1.01592;
                else if (brix >= 5.1 && brix < 5.2) return 1.01632;
                else if (brix >= 5.2 && brix < 5.3) return 1.01671;
                else if (brix >= 5.3 && brix < 5.4) return 1.01711;
                else if (brix >= 5.4 && brix < 5.5) return 1.01751;
                else if (brix >= 5.5 && brix < 5.6) return 1.0179;
                else if (brix >= 5.6 && brix < 5.7) return 1.0183;
                else if (brix >= 5.7 && brix < 5.8) return 1.0187;
                else if (brix >= 5.8 && brix < 5.9) return 1.0191;
                else if (brix >= 5.9 && brix < 6.0) return 1.0195;
                else if (brix >= 6.0 && brix < 6.1) return 1.0199;
                else if (brix >= 6.1 && brix < 6.2) return 1.0203;
                else if (brix >= 6.2 && brix < 6.3) return 1.0207;
                else if (brix >= 6.3 && brix < 6.4) return 1.0211;
                else if (brix >= 6.4 && brix < 6.5) return 1.0215;
                else if (brix >= 6.5 && brix < 6.6) return 1.0219;
                else if (brix >= 6.6 && brix < 6.7) return 1.0223;
                else if (brix >= 6.7 && brix < 6.8) return 1.0227;
                else if (brix >= 6.8 && brix < 6.9) return 1.0231;
                else if (brix >= 6.9 && brix < 7.0) return 1.0235;
                else if (brix >= 7.0 && brix < 7.1) return 1.0239;
                else if (brix >= 7.1 && brix < 7.2) return 1.02431;
                else if (brix >= 7.2 && brix < 7.3) return 1.02471;
                else if (brix >= 7.3 && brix < 7.4) return 1.02511;
                else if (brix >= 7.4 && brix < 7.5) return 1.02551;
                else if (brix >= 7.5 && brix < 7.6) return 1.02592;
                else if (brix >= 7.6 && brix < 7.7) return 1.02632;
                else if (brix >= 7.7 && brix < 7.8) return 1.02672;
                else if (brix >= 7.8 && brix < 7.9) return 1.02713;
                else if (brix >= 7.9 && brix < 8.0) return 1.02753;
                else if (brix >= 8.0 && brix < 8.1) return 1.02794;
                else if (brix >= 8.1 && brix < 8.2) return 1.02834;
                else if (brix >= 8.2 && brix < 8.3) return 1.02875;
                else if (brix >= 8.3 && brix < 8.4) return 1.02915;
                else if (brix >= 8.4 && brix < 8.5) return 1.02955;
                else if (brix >= 8.5 && brix < 8.6) return 1.02996;
                else if (brix >= 8.6 && brix < 8.7) return 1.03037;
                else if (brix >= 8.7 && brix < 8.8) return 1.03077;
                else if (brix >= 8.8 && brix < 8.9) return 1.03118;
                else if (brix >= 8.9 && brix < 9.0) return 1.03159;
                else if (brix >= 9.0 && brix < 9.1) return 1.03199;
                else if (brix >= 9.1 && brix < 9.2) return 1.0324;
                else if (brix >= 9.2 && brix < 9.3) return 1.03281;
                else if (brix >= 9.3 && brix < 9.4) return 1.03322;
                else if (brix >= 9.4 && brix < 9.5) return 1.03362;
                else if (brix >= 9.5 && brix < 9.6) return 1.03403;
                else if (brix >= 9.6 && brix < 9.7) return 1.03444;
                else if (brix >= 9.7 && brix < 9.8) return 1.03485;
                else if (brix >= 9.8 && brix < 9.9) return 1.03526;
                else if (brix >= 9.9 && brix < 10.0) return 1.03567;
                else if (brix >= 10.0 && brix < 10.1) return 1.03608;
                else if (brix >= 10.1 && brix < 10.2) return 1.03649;
                else if (brix >= 10.2 && brix < 10.3) return 1.0369;
                else if (brix >= 10.3 && brix < 10.4) return 1.03731;
                else if (brix >= 10.4 && brix < 10.5) return 1.03772;
                else if (brix >= 10.5 && brix < 10.6) return 1.03813;
                else if (brix >= 10.6 && brix < 10.7) return 1.03854;
                else if (brix >= 10.7 && brix < 10.8) return 1.03896;
                else if (brix >= 10.8 && brix < 10.9) return 1.03937;
                else if (brix >= 10.9 && brix < 11.0) return 1.03978;
                else if (brix >= 11.0 && brix < 11.1) return 1.04019;
                else if (brix >= 11.1 && brix < 11.2) return 1.04061;
                else if (brix >= 11.2 && brix < 11.3) return 1.04102;
                else if (brix >= 11.3 && brix < 11.4) return 1.04143;
                else if (brix >= 11.4 && brix < 11.5) return 1.04185;
                else if (brix >= 11.5 && brix < 11.6) return 1.04226;
                else if (brix >= 11.6 && brix < 11.7) return 1.04267;
                else if (brix >= 11.7 && brix < 11.8) return 1.04309;
                else if (brix >= 11.8 && brix < 11.9) return 1.0435;
                else if (brix >= 11.9 && brix < 12.0) return 1.04392;
                else if (brix >= 12.0 && brix < 12.1) return 1.04433;
                else if (brix >= 12.1 && brix < 12.2) return 1.04475;
                else if (brix >= 12.2 && brix < 12.3) return 1.04517;
                else if (brix >= 12.3 && brix < 12.4) return 1.04558;
                else if (brix >= 12.4 && brix < 12.5) return 1.046;
                else if (brix >= 12.5 && brix < 12.6) return 1.04642;
                else if (brix >= 12.6 && brix < 12.7) return 1.04683;
                else if (brix >= 12.7 && brix < 12.8) return 1.04725;
                else if (brix >= 12.8 && brix < 12.9) return 1.04767;
                else if (brix >= 12.9 && brix < 13.0) return 1.04809;
                else if (brix >= 13.0 && brix < 13.1) return 1.04851;
                else if (brix >= 13.1 && brix < 13.2) return 1.04892;
                else if (brix >= 13.2 && brix < 13.3) return 1.04934;
                else if (brix >= 13.3 && brix < 13.4) return 1.04976;
                else if (brix >= 13.4 && brix < 13.5) return 1.05018;
                else if (brix >= 13.5 && brix < 13.6) return 1.0506;
                else if (brix >= 13.6 && brix < 13.7) return 1.05102;
                else if (brix >= 13.7 && brix < 13.8) return 1.05144;
                else if (brix >= 13.8 && brix < 13.9) return 1.05186;
                else if (brix >= 13.9 && brix < 14.0) return 1.05228;
                else if (brix >= 14.0 && brix < 14.1) return 1.05271;
                else if (brix >= 14.1 && brix < 14.2) return 1.05531;
                else if (brix >= 14.2 && brix < 14.3) return 1.05355;
                else if (brix >= 14.3 && brix < 14.4) return 1.05397;
                else if (brix >= 14.4 && brix < 14.5) return 1.05439;
                else if (brix >= 14.5 && brix < 14.6) return 1.05482;
                else if (brix >= 14.6 && brix < 14.7) return 1.05524;
                else if (brix >= 14.7 && brix < 14.8) return 1.05566;
                else if (brix >= 14.8 && brix < 14.9) return 1.05609;
                else if (brix >= 14.9 && brix < 15.0) return 1.05651;
                else if (brix >= 15.0 && brix < 15.1) return 1.05694;
                else if (brix >= 15.1 && brix < 15.2) return 1.05736;
                else if (brix >= 15.2 && brix < 15.3) return 1.05779;
                else if (brix >= 15.3 && brix < 15.4) return 1.05821;
                else if (brix >= 15.4 && brix < 15.5) return 1.05864;
                else if (brix >= 15.5 && brix < 15.6) return 1.05906;
                else if (brix >= 15.6 && brix < 15.7) return 1.05595;
                else if (brix >= 15.7 && brix < 15.8) return 1.05991;
                else if (brix >= 15.8 && brix < 15.9) return 1.06034;
                else if (brix >= 15.9 && brix < 16.0) return 1.06077;
                else if (brix >= 16.0 && brix < 16.1) return 1.0612;
                else if (brix >= 16.1 && brix < 16.2) return 1.06162;
                else if (brix >= 16.2 && brix < 16.3) return 1.06205;
                else if (brix >= 16.3 && brix < 16.4) return 1.06248;
                else if (brix >= 16.4 && brix < 16.5) return 1.06291;
                else if (brix >= 16.5 && brix < 16.6) return 1.06334;
                else if (brix >= 16.6 && brix < 16.7) return 1.06378;
                else if (brix >= 16.7 && brix < 16.8) return 1.0642;
                else if (brix >= 16.8 && brix < 16.9) return 1.06463;
                else if (brix >= 16.9 && brix < 17.0) return 1.06506;
                else if (brix >= 17.0 && brix < 17.1) return 1.06549;
                else if (brix >= 17.1 && brix < 17.2) return 1.06592;
                else if (brix >= 17.2 && brix < 17.3) return 1.06635;
                else if (brix >= 17.3 && brix < 17.4) return 1.06678;
                else if (brix >= 17.4 && brix < 17.5) return 1.06721;
                else if (brix >= 17.5 && brix < 17.6) return 1.06764;
                else if (brix >= 17.6 && brix < 17.7) return 1.06808;
                else if (brix >= 17.7 && brix < 17.8) return 1.06851;
                else if (brix >= 17.8 && brix < 17.9) return 1.06894;
                else if (brix >= 17.9 && brix < 18.0) return 1.06938;
                else if (brix >= 18.0 && brix < 18.1) return 1.06981;
                else if (brix >= 18.1 && brix < 18.2) return 1.06702;
                else if (brix >= 18.2 && brix < 18.3) return 1.07068;
                else if (brix >= 18.3 && brix < 18.4) return 1.07111;
                else if (brix >= 18.4 && brix < 18.5) return 1.07155;
                else if (brix >= 18.5 && brix < 18.6) return 1.07198;
                else if (brix >= 18.6 && brix < 18.7) return 1.07242;
                else if (brix >= 18.7 && brix < 18.8) return 1.07285;
                else if (brix >= 18.8 && brix < 18.9) return 1.07329;
                else if (brix >= 18.9 && brix < 19.0) return 1.07373;
                else if (brix >= 19.0 && brix < 19.1) return 1.07417;
                else if (brix >= 19.1 && brix < 19.2) return 1.0746;
                else if (brix >= 19.2 && brix < 19.3) return 1.07504;
                else if (brix >= 19.3 && brix < 19.4) return 1.07548;
                else if (brix >= 19.4 && brix < 19.5) return 1.07592;
                else if (brix >= 19.5 && brix < 19.6) return 1.07635;
                else if (brix >= 19.6 && brix < 19.7) return 1.07679;
                else if (brix >= 19.7 && brix < 19.8) return 1.07723;
                else if (brix >= 19.8 && brix < 19.9) return 1.07767;
                else if (brix >= 19.9 && brix < 20.0) return 1.07811;
                else if (brix >= 20.0 && brix < 20.1) return 1.07855;
                else if (brix >= 20.1 && brix < 20.2) return 1.07899;
                else if (brix >= 20.2 && brix < 20.3) return 1.07943;
                else if (brix >= 20.3 && brix < 20.4) return 1.07987;
                else if (brix >= 20.4 && brix < 20.5) return 1.08032;
                else if (brix >= 20.5 && brix < 20.6) return 1.08076;
                else if (brix >= 20.6 && brix < 20.7) return 1.0812;
                else if (brix >= 20.7 && brix < 20.8) return 1.08164;
                else if (brix >= 20.8 && brix < 20.9) return 1.08208;
                else if (brix >= 20.9 && brix < 21.0) return 1.08253;
                else if (brix >= 21.0 && brix < 21.1) return 1.08297;
                else if (brix >= 21.1 && brix < 21.2) return 1.08342;
                else if (brix >= 21.2 && brix < 21.3) return 1.08386;
                else if (brix >= 21.3 && brix < 21.4) return 1.0843;
                else if (brix >= 21.4 && brix < 21.5) return 1.08475;
                else if (brix >= 21.5 && brix < 21.6) return 1.08519;
                else if (brix >= 21.6 && brix < 21.7) return 1.08564;
                else if (brix >= 21.7 && brix < 21.8) return 1.08603;
                else if (brix >= 21.8 && brix < 21.9) return 1.08653;
                else if (brix >= 21.9 && brix < 22.0) return 1.08698;
                else if (brix >= 22.0 && brix < 22.1) return 1.08743;
                else if (brix >= 22.1 && brix < 22.2) return 1.08787;
                else if (brix >= 22.2 && brix < 22.3) return 1.08832;
                else if (brix >= 22.3 && brix < 22.4) return 1.08877;
                else if (brix >= 22.4 && brix < 22.5) return 1.08922;
                else if (brix >= 22.5 && brix < 22.6) return 1.08966;
                else if (brix >= 22.6 && brix < 22.7) return 1.09011;
                else if (brix >= 22.7 && brix < 22.8) return 1.09056;
                else if (brix >= 22.8 && brix < 22.9) return 1.09101;
                else if (brix >= 22.9 && brix < 23.0) return 1.09146;
                else if (brix >= 23.0 && brix < 23.1) return 1.09191;
                else if (brix >= 23.1 && brix < 23.2) return 1.09236;
                else if (brix >= 23.2 && brix < 23.3) return 1.09281;
                else if (brix >= 23.3 && brix < 23.4) return 1.09327;
                else if (brix >= 23.4 && brix < 23.5) return 1.09372;
                else if (brix >= 23.5 && brix < 23.6) return 1.09417;
                else if (brix >= 23.6 && brix < 23.7) return 1.09462;
                else if (brix >= 23.7 && brix < 23.8) return 1.09507;
                else if (brix >= 23.8 && brix < 23.9) return 1.09553;
                else if (brix >= 23.9 && brix < 24.0) return 1.09598;
                else if (brix >= 24.0 && brix < 24.1) return 1.09643;
                else if (brix >= 24.1 && brix < 24.2) return 1.09689;
                else if (brix >= 24.2 && brix < 24.3) return 1.09734;
                else if (brix >= 24.3 && brix < 24.4) return 1.0978;
                else if (brix >= 24.4 && brix < 24.5) return 1.09825;
                else if (brix >= 24.5 && brix < 24.6) return 1.09871;
                else if (brix >= 24.6 && brix < 24.7) return 1.09916;
                else if (brix >= 24.7 && brix < 24.8) return 1.09962;
                else if (brix >= 24.8 && brix < 24.9) return 1.10007;
                else if (brix >= 24.9 && brix < 25.0) return 1.10053;
                else return 1.000; // Default value jika di luar range
            }

            // Fungsi untuk menghitung Pol dari Pol Baca dan Brix
            function hitungPolDariPolBaca() {
                if (isCalculating) return;
                isCalculating = true;

                let pol_baca = parseFloat($('#pol_baca').val()) || 0;
                let brix = parseFloat($('#brix').val()) || 0;

                if (brix > 0 && pol_baca >= 0) {
                    let bj = getBJFromBrix(brix);
                    let pol = 0.286 * pol_baca / bj;
                    $('#pol').val(pol.toFixed(2));
                } else {
                    $('#pol').val('');
                }

                isCalculating = false;
                hitungHK();
            }

            // Fungsi untuk menghitung Pol Baca dari Pol dan Brix
            function hitungPolBacaDariPol() {
                if (isCalculating) return;
                isCalculating = true;

                let pol = parseFloat($('#pol').val()) || 0;
                let brix = parseFloat($('#brix').val()) || 0;

                if (brix > 0 && pol >= 0) {
                    let bj = getBJFromBrix(brix);
                    let pol_baca = (pol * bj) / 0.286;
                    $('#pol_baca').val(pol_baca.toFixed(2));
                } else {
                    $('#pol_baca').val('');
                }

                isCalculating = false;
                hitungHK();
            }

            // Fungsi untuk menghitung HK
            function hitungHK() {
                let pol = parseFloat($('#pol').val()) || 0;
                let brix = parseFloat($('#brix').val()) || 0;

                if (brix > 0 && pol >= 0) {
                    let hk = pol / brix * 100;
                    $('#hk').val(hk.toFixed(2));
                } else {
                    $('#hk').val('');
                }

                // Hitung rendemen setiap kali HK dihitung
                hitungRendemen();
            }

            // Fungsi untuk menghitung Rendemen
            function hitungRendemen() {
                let brix = parseFloat($('#brix').val()) || 0;
                let pol = parseFloat($('#pol').val()) || 0;

                if (brix > 0 && pol >= 0) {
                    let hasil = fr * (pol - fm * (brix - pol));
                    $('#rendemen').val(hasil.toFixed(2));
                } else {
                    $('#rendemen').val('');
                }
            }

            // Trigger perhitungan ketika brix berubah
            $('#brix').on('input', function() {
                // Jika pol_baca sudah ada nilai, hitung pol dari pol_baca
                let pol_baca = parseFloat($('#pol_baca').val()) || 0;
                let pol = parseFloat($('#pol').val()) || 0;

                if (pol_baca > 0) {
                    hitungPolDariPolBaca();
                } else if (pol > 0) {
                    hitungPolBacaDariPol();
                } else {
                    hitungHK();
                }
            });

            // Trigger perhitungan ketika pol_baca berubah
            $('#pol_baca').on('input', function() {
                hitungPolDariPolBaca();
            });

            // Trigger perhitungan ketika pol berubah
            $('#pol').on('input', function() {
                hitungPolBacaDariPol();
            });

            // Kalau barcode dipilih
            $('#id').on('change', function() {
                let brix = $(this).find(':selected').data('brix');
                let pol = $(this).find(':selected').data('pol');
                let pol_baca = $(this).find(':selected').data('pol_baca');

                $('#brix').val(brix ?? '');
                $('#pol').val(pol ?? '');
                $('#pol_baca').val(pol_baca ?? '');

                // Prioritaskan perhitungan dari pol_baca jika ada
                if (pol_baca) {
                    hitungPolDariPolBaca();
                } else if (pol) {
                    hitungPolBacaDariPol();
                } else {
                    hitungHK();
                }
            });

            // Jalankan sekali saat load kalau ada value lama
            $('#id').trigger('change');
        });
    </script>
@endsection
