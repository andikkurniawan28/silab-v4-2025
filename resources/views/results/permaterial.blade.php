@extends('template.master')

@section('resultPerStation-active', 'active')
@section('resultPerStation-show', 'show')
@section("resultPerStation{$material->station->id}-active", 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>{{ strtoupper($material->name) }}</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="materialTable" class="table table-bordered table-hover table-striped w-100 text-center">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Timestamp</th>
                                @foreach ($material->parameters as $p)
                                    <th>{{ $p->name }}<sub>({{ $p->unit->name }})</sub></th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DataTables isi otomatis -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#materialTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('results.permaterial.data', $material->id) }}",
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    @foreach ($material->parameters as $p)
                        {
                            data: "p{{ $p->id }}",
                            name: "p{{ $p->id }}"
                        },
                    @endforeach
                ],
                order: [
                    [0, 'desc']
                ],
                language: {
                    emptyTable: "Tidak ada data tersedia",
                    processing: "Memuat..."
                }
            });
        });
    </script>
@endsection
