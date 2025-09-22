@extends('template.master')

@section('imbibisi-active', 'active')
@section('input-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Edit Imbibisi</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('imbibisi.update', $imbibisi->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" id="date" name="date" class="form-control"
                                value="{{ old('date', $imbibisi->date ? \Carbon\Carbon::parse($imbibisi->date)->format('Y-m-d') : '') }}"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label for="time" class="form-label">Jam</label>
                            <select id="time" name="time" class="form-control select2" required>
                                @for ($i = 0; $i <= 23; $i++)
                                    <option value="{{ $i }}"
                                        {{ \Carbon\Carbon::parse($imbibisi->time)->format('H') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00 -
                                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}:00
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
                                    <th class="text-left">Setelah</th>
                                    <th class="text-left">Flow</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($spots as $spot)
                                    <tr>
                                        <td>{{ $spot->name }}</td>
                                        <td>
                                            <input type="number" class="form-control"
                                                id="totalizer_{{ $spot->name }}_sebelum" name="tb{{ $spot->id }}"
                                                value="{{ old('tb' . $spot->id, $imbibisi->{'tb' . $spot->id} ?? 0) }}"
                                                readonly>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control"
                                                id="totalizer_{{ $spot->name }}_setelah" name="t{{ $spot->id }}"
                                                value="{{ old('t' . $spot->id, $imbibisi->{'t' . $spot->id}) }}" required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control"
                                                id="flow_{{ $spot->name }}_setelah" name="f{{ $spot->id }}"
                                                value="{{ old('f' . $spot->id, $imbibisi->{'f' . $spot->id}) }}" readonly>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save"></i> Update
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
                // loop semua spot
                @foreach ($spots as $spot)
                    let sebelum_{{ $spot->id }} = parseFloat(document.getElementById(
                        "totalizer_{{ $spot->name }}_sebelum").value) || 0;
                    let setelah_{{ $spot->id }} = parseFloat(document.getElementById(
                        "totalizer_{{ $spot->name }}_setelah").value) || 0;

                    // flow = setelah - sebelum
                    let flow_{{ $spot->id }} = setelah_{{ $spot->id }} - sebelum_{{ $spot->id }};

                    // isi field
                    document.getElementById("flow_{{ $spot->name }}_setelah").value = flow_{{ $spot->id }};
                @endforeach
            }

            // trigger ketika input berubah
            document.querySelectorAll("input").forEach(el => {
                el.addEventListener("input", hitungFlow);
            });
        });
    </script>
@endsection
