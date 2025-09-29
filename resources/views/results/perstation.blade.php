@extends('template.master')

@section('resultPerStation-active', 'active')
@section('resultPerStation-show', 'show')
@section("resultPerStation{$station->id}-active", 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-4" id="title">
            <strong>Hasil Analisa {{ $station->name }}</strong>
        </h1>

        <div class="mb-3">
            <div class="input-group">
                <input type="text" id="material-search" class="form-control" placeholder="Cari material...">
                <span class="input-group-text bg-white">
                    <i class="bi bi-search"></i>
                </span>
            </div>
        </div>

        <div class="row" id="material-list">
            {{-- Data akan dimuat via AJAX --}}
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch("{{ route('results.perstation.data', $station->id) }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({})
                })
                .then(res => res.json())
                .then(data => {
                    let container = document.getElementById("material-list");
                    container.innerHTML = "";

                    data.materials.forEach(material => {
                        let colClass = material.parameters.length >= 8 ? "col-md-12" : "col-md-6";
                        let headerCols = ["Timestamp", ...material.parameters.map(p => p.name)];

                        let rows = "";
                        material.analyses.forEach(a => {
                            rows += "<tr>";
                            rows += `<td>${a.created_at}</td>`;
                            material.parameters.forEach(p => {
                                rows += `<td>${a[p.field] ?? ""}</td>`;
                            });
                            rows += "</tr>";
                        });

                        if (rows === "") {
                            rows = `<tr><td colspan="${headerCols.length}" class="text-center text-muted">Tidak ada data</td></tr>`;
                        }

                        let card = `
                            <div class="${colClass} mb-3 material-item">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-gradient-danger text-light">
                                        <strong class="material-name">
                                            <a href="{{ url('results/permaterial') }}/${material.id}" class="text-decoration-none text-light">
                                                ${material.material.toUpperCase()}
                                            </a>
                                        </strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-stripped table-hover table-bordered text-dark">
                                                <thead>
                                                    <tr>
                                                        ${headerCols.map(h => `<th>${h}</th>`).join("")}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ${rows}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        container.innerHTML += card;
                    });
                })
                .catch(err => {
                    console.error("Error load data:", err);
                    document.getElementById("material-list").innerHTML =
                        `<div class="col-12"><div class="alert alert-danger">Gagal memuat data</div></div>`;
                });
        });

        // Script filter pencarian
        $(document).ready(function() {
            $('#material-search').on('keyup', function() {
                let keyword = $(this).val().toLowerCase();
                $('#material-list .material-item').filter(function() {
                    $(this).toggle($(this).find('.material-name').text().toLowerCase().indexOf(keyword) > -1);
                });
            });
        });
    </script>
@endsection
