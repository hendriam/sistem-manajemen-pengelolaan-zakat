@extends('app.layout')

@section('title', 'Master '.$title)

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet"  href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <style>
        td.dt-center{
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
                        <h1 class="m-0">Master {{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('muzakkis.index') }}">Master {{ $title }}</a></li>
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
                                <div class="card-tools">
                                    <a href="{{ route('muzakkis.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="data_table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>No. HP</th>
                                            <th>Alamat</th>
                                            <th>Diinput oleh</th>
                                            <th>Tanggal input</th>
                                            <th style="width: 200px; text-align:center;">#</th>
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
                url: '{{ route("muzakkis.index") }}',
                type: 'POST',
                    headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
            columns: [
                {
                    data: null,
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    },
                    orderable: false,
                },
                {
                    data: 'name',
                    orderable: true,
                },
                {
                    data: 'phone',
                    orderable: false,
                },
                {
                    data: 'address',
                    orderable: false,
                },
                {
                    data: 'created_by.name',
                    orderable: false,
                },
                {
                    data: 'created_at',
                    render: function (data, type, row) {
                        return moment(data).format('YYYY-MM-DD HH:mm:ss'); 
                    },
                    orderable: true,
                },
                {
                    data: null,
                    render : function(data, type, row){
                        return  '<a href="{{ route("muzakkis.index") }}/'+data.id+'/edit" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a> ' +
                        '<button type="button" class="btn btn-sm btn-danger btn-delete" data-id="'+data.id+'"><i class="fas fa-trash"></i> Hapus</button> ';
                    },
                    orderable: false,
                }
            ],
            order: [ 4, 'desc' ],
            columnDefs: [
                {targets: [5], className: 'dt-center'}
            ],
        });

        $('#data_table').on('click', '.btn-delete', function () {
            const id = $(this).data('id');
            Swal.fire({
                title: "Anda yakin untuk data ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, hapus!",
                cancelButtonText: "Tidak",
                showClass: {popup: `animate__animated animate__fadeInUp animate__faster`},
                hideClass: {popup: `animate__animated animate__fadeOutDown animate__faster`}
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("muzakkis.index") }}/'+id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function (res) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Data berhasil dihapus!",
                                icon: "success",
                                showClass: {popup: `animate__animated animate__fadeInUp animate__faster`},
                                hideClass: {popup: `animate__animated animate__fadeOutDown animate__faster`}
                            });
                            $('#data_table').DataTable().ajax.reload(null, false); // reload tanpa reset halaman
                        },
                        error: function (xhr) {
                            let message = 'Gagal menghapus data';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                title: "Failed!",
                                text: message,
                                icon: "error",
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush