@extends('template.master')

@section('dashboard-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">

        <h1 class="h3 mb-4"><strong>Dashboard</strong></h1>

        <div class="row">

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Analisa Belum Terverifikasi</div>
                                <div class="h5 mb-0 font-weight-bold text-dark" id="analisa_belum_terverifikasi">

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-check fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Material Baru Bulan Ini</div>
                                <div class="h5 mb-0 font-weight-bold text-dark" id="material_baru_bulan_ini">

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-flask fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Stok Form A</div>
                                <div class="h5 mb-0 font-weight-bold text-dark" id="stok_form_a">

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-box fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Stok Form B</div>
                                <div class="h5 mb-0 font-weight-bold text-dark" id="stok_form_b">

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-box fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    NPP Pagi</div>
                                <div class="h5 mb-0 font-weight-bold text-dark">
                                    <span id="npp_pagi_rendemen">-</span>
                                </div>
                                <div class="text-xs text-muted mt-1" id="npp_pagi_jumlah">
                                    -
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-percent fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    NPP Sore</div>
                                <div class="h5 mb-0 font-weight-bold text-dark">
                                    <span id="npp_sore_rendemen">-</span>
                                </div>
                                <div class="text-xs text-muted mt-1" id="npp_sore_jumlah">
                                    -
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-percent fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    NPP Malam</div>
                                <div class="h5 mb-0 font-weight-bold text-dark">
                                    <span id="npp_malam_rendemen">-</span>
                                </div>
                                <div class="text-xs text-muted mt-1" id="npp_malam_jumlah">
                                    -
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-percent fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    NPP Harian</div>
                                <div class="h5 mb-0 font-weight-bold text-dark">
                                    <span id="npp_harian_rendemen">-</span>
                                </div>
                                <div class="text-xs text-muted mt-1" id="npp_harian_jumlah">
                                    -
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-percent fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Stok Kertas Merang</div>
                                <div class="h5 mb-0 font-weight-bold text-dark" id="stok_kertas_merang">

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-box fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>

    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch("{{ route('dashboard.data') }}", {
                    method: "GET",
                    headers: {
                        // "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("analisa_belum_terverifikasi").textContent = data.analisa_belum_terverifikasi + " Sampel";
                    document.getElementById("stok_form_a").textContent = data.stok_form_a + " Jurigen";
                    document.getElementById("stok_form_b").textContent = data.stok_form_b + " Jurigen";
                    // document.getElementById("stok_kertas_merang").textContent = data.stok_kertas_merang + " Ball";
                    document.getElementById("material_baru_bulan_ini").textContent = data.material_baru_bulan_ini + " Material";
                    if (data.npp_pagi) {
                        document.getElementById("npp_pagi_jumlah").textContent = data.npp_pagi.jumlah + " Sampel";
                        document.getElementById("npp_pagi_rendemen").textContent =
                            data.npp_pagi.rendemen ? data.npp_pagi.rendemen.toFixed(2) : "0.00";
                    }

                    if (data.npp_sore) {
                        document.getElementById("npp_sore_jumlah").textContent = data.npp_sore.jumlah + " Sampel";
                        document.getElementById("npp_sore_rendemen").textContent =
                            data.npp_sore.rendemen ? data.npp_sore.rendemen.toFixed(2) : "0.00";
                    }

                    if (data.npp_malam) {
                        document.getElementById("npp_malam_jumlah").textContent = data.npp_malam.jumlah + " Sampel";
                        document.getElementById("npp_malam_rendemen").textContent =
                            data.npp_malam.rendemen ? data.npp_malam.rendemen.toFixed(2) : "0.00";
                    }

                    if (data.npp_harian) {
                        document.getElementById("npp_harian_jumlah").textContent = data.npp_harian.jumlah + " Sampel";
                        document.getElementById("npp_harian_rendemen").textContent =
                            data.npp_harian.rendemen ? data.npp_harian.rendemen.toFixed(2) : "0.00";
                    }
                })
                .catch(error => {
                    console.error("Error fetching dashboard data:", error);
                });
        });
    </script>
@endsection
