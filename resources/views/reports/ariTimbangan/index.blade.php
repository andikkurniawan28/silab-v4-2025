@extends('template.master')

@section('laporan_ari_timbangan-active', 'active')
@section('report-show', 'show')
@section('report-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">

        <h1 class="h3 mb-4"><strong>Laporan ARI Timbangan</strong></h1>

        {{-- Form filter --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form id="ariTimbanganForm">
                    <div class="row g-3 align-items-end">
                        {{-- Tanggal --}}
                        <div class="col-md-4">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" id="date" name="date" class="form-control"
                                value="{{ date('Y-m-d') }}" required>
                        </div>

                        {{-- Shift --}}
                        <div class="col-md-4">
                            <label for="shift" class="form-label">Shift</label>
                            <select id="shift" name="shift" class="form-select select2" required>
                                <option value="" disabled selected>Pilih Shift</option>
                                <option value="harian">Harian</option>
                                <option value="pagi">Pagi</option>
                                <option value="sore">Sore</option>
                                <option value="malam">Malam</option>
                            </select>
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Hasil laporan --}}
        <div id="report-result"></div>
    </div>

    {{-- SheetJS --}}
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

    {{-- jsPDF + autotable --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

    <script>
        document.getElementById('ariTimbanganForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let date = document.getElementById('date').value;
            let shift = document.getElementById('shift').value;
            if (!date || !shift) return;

            let url = "{{ route('reports.ariTimbangan.data', ['date' => ':date', 'shift' => ':shift']) }}";
            url = url.replace(':date', date).replace(':shift', shift);

            fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    let container = document.getElementById('report-result');
                    container.innerHTML = '';

                    if (!data || data.length === 0) {
                        container.innerHTML =
                            `<div class="alert alert-warning">Tidak ada data untuk periode ini</div>`;
                        return;
                    }

                    let tableRows = "";
                    data.forEach(row => {
                        tableRows += `<tr>
                <td>${row.id ?? '-'}</td>
                <td>${row.core_at ?? '-'}</td>
                <td>${row.nomor_antrian ?? '-'}</td>
                <td>${row.register ?? '-'}</td>
                <td>${row.brix_core ?? '-'}</td>
                <td>${row.pol_core ?? '-'}</td>
                <td>${row.rendemen_core ?? '-'}</td>
            </tr>`;
                    });

                    let table = `
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-2 gap-2">
            <button id="btnExportExcel" class="btn btn-success btn-sm">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </button>
            <button id="btnExportPDF" class="btn btn-danger btn-sm">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </button>
        </div>
        <div class="table-responsive">
            <table id="ariTimbanganTable" class="table table-bordered table-hover table-striped text-left text-dark">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Timestamp</th>
                        <th>Nomor Antrian</th>
                        <th>Register</th>
                        <th>Brix Core</th>
                        <th>Pol Core</th>
                        <th>Rendemen Core</th>
                    </tr>
                </thead>
                <tbody>${tableRows}</tbody>
            </table>
        </div>
    </div>
</div>`;

                    container.innerHTML = table;

                    // Export Excel
                    document.getElementById('btnExportExcel').addEventListener('click', function() {
                        let wb = XLSX.utils.book_new();
                        let ws = XLSX.utils.table_to_sheet(document.getElementById('ariTimbanganTable'));
                        XLSX.utils.book_append_sheet(wb, ws, "Laporan ARI Timbangan");
                        XLSX.writeFile(wb, `Laporan_Core_Sample_${date}_${shift}.xlsx`);
                    });

                    // Export PDF
                    document.getElementById('btnExportPDF').addEventListener('click', function() {
                        const {
                            jsPDF
                        } = window.jspdf;
                        const doc = new jsPDF('l', 'pt', 'a4');
                        doc.setFontSize(14);
                        doc.text("Laporan ARI Timbangan", 40, 30);
                        doc.setFontSize(10);
                        doc.text(`Tanggal: ${date} | Shift: ${shift}`, 40, 50);

                        doc.autoTable({
                            html: '#ariTimbanganTable',
                            startY: 70,
                            theme: 'grid',
                            headStyles: {
                                fillColor: [41, 128, 185]
                            },
                            styles: {
                                fontSize: 8
                            }
                        });

                        doc.save(`Laporan_Core_Sample_${date}_${shift}.pdf`);
                    });
                })
                .catch(err => {
                    console.error("Error:", err);
                    document.getElementById('report-result').innerHTML =
                        `<div class="alert alert-danger">Gagal memuat data</div>`;
                });
        });
    </script>
@endsection
