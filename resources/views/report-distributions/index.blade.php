@extends('app.layout')

@section('title', $title)

@push('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
<style>
    td.dt-center {
        text-align: center;
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <!-- Header content -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('report-distributions.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">List {{ $title }}</h5>
                        </div>
                        <div class="card-body">
                            {{-- filter by tanggal --}}
                            <form id="filter-form" class="mb-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Dari Tanggal</label>
                                        <input type="date" class="form-control" name="start_date" id="filter-start-date">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Sampai Tanggal</label>
                                        <input type="date" class="form-control" name="end_date" id="filter-end-date">
                                    </div>
                                    <div class="col-md-6 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary me-2">Filter</button> &nbsp
                                        <button type="button" class="btn btn-info" id="btn-export-pdf">Export PDF</button> &nbsp
                                        <button type="button" class="btn btn-secondary" id="reset-filters">Reset</button>
                                    </div>
                                </div>
                            </form>

                            <table id="data_table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal</th>
                                        <th>Mustahik</th>
                                        <th>Program</th>
                                        <th>Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('js')
<!-- DataTables  & Plugins -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script>
    const table = $('#data_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("report-distributions.index") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: function(d) {
                d.start_date = $('#filter-start-date').val();
                d.end_date = $('#filter-end-date').val();
            },
            dataSrc: 'data'
        },
        language: {
            emptyTable: 'Tidak Ada Data Tersedia',
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: {
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        },
        responsive: true,
        autoWidth: false,
        ordering: true,
        columns: [{
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + 1;
                },
                orderable: false,
            },
            {
                data: 'distribution_date',
                orderable: true,
            },
            {
                data: 'mustahik.name',
                orderable: false,
            },
            {
                data: 'program',
                orderable: false,
            },
            {
                data: 'amount',
                orderable: false,
            },
        ],
        order: [1, 'desc'],
    });

    // Submit form filter
    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    // Reset filter
    $('#reset-filters').on('click', function() {
        $('#filter-form')[0].reset();
        table.ajax.reload();
    });

    $('#btn-export-pdf').on('click', function() {
        // let status = $('#filter-status').val();
        let startDate = $('#filter-start-date').val();
        let endDate = $('#filter-end-date').val();

        let url = new URL("{{ route('report-distributions.export-pdf') }}", window.location.origin);
        // url.searchParams.append("status", status);
        url.searchParams.append("start_date", startDate);
        url.searchParams.append("end_date", endDate);

        window.open(url.toString(), '_blank');
    });
</script>
@endpush