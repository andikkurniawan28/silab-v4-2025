@extends('template.master')

@section('imbibisi-active', 'active')
@section('input-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Tambah Imbibisi</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('imbibisi.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" id="date" name="date" class="form-control"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="time" class="form-label">Jam</label>
                            <select id="time" name="time" class="form-control select2" required>
                                @for ($i = 0; $i <= 23; $i++)
                                    <option value="{{ $i }}">{{ $i }}:00 - {{ $i + 1 }}:00
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th class="text-left" style="width: 30%">Titik Monitoring</th>
                                    <th class="text-left">Sebelum</th>
                                    <th class="text-left">Sesudah</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Totalizer --}}
                                <tr>
                                    <td>Totalizer Imbibisi</td>
                                    <td>
                                        <input type="text" class="form-control" id="totalizer_imb_sebelum"
                                            value="{{ $last_monitoring->p4 ?? 0 }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="totalizer_imb_setelah" name="p4"
                                            required>
                                    </td>
                                </tr>
                                {{-- Flow --}}
                                <tr>
                                    <td>Flow Imbibisi</td>
                                    <td>
                                        <input type="text" class="form-control" id="flow_imb_sebelum"
                                            value="{{ $last_monitoring->p7 ?? 0 }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="flow_imb_setelah" name="p7"
                                            readonly>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('imbibisi.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function hitungFlow() {
                // ambil totalizer sebelum & sesudah
                let totalizer_imb_sebelum = parseFloat(document.getElementById("totalizer_imb_sebelum").value) || 0;
                let totalizer_imb_setelah = parseFloat(document.getElementById("totalizer_imb_setelah").value) || 0;

                // hitung flow imbibisi
                let flow_imb = totalizer_imb_setelah - totalizer_imb_sebelum;

                // isi ke field
                document.getElementById("flow_imb_setelah").value = flow_imb;
            }

            // trigger saat input totalizer imbibisi setelah berubah
            document.getElementById("totalizer_imb_setelah")
                .addEventListener("input", hitungFlow);
        });
    </script>
@endsection
