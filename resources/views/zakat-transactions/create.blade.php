@extends('app.layout')

@section('title', $title)

@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
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
                        <li class="breadcrumb-item"><a href="{{ route('zakat-transactions.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
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
                    <form action="{{ route('zakat-transactions.store') }}" method="post" id="formStore" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Form Tambah {{ $title }}</h5>
                                <div class="card-tools">
                                    <a href="{{ route('zakat-transactions.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                            <div class="card-body">
                                @include('zakat-transactions.form', ['data' => null])
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> <i class='fas fa-spinner fa-spin' style="display: none"></i> Simpan</button>
                                <button type="button" class="btn btn-default" id="btnCancel"><i class="fas fa-window-close"></i> Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

<script>
    //Initialize Select2 Elements
    $('.muzakki_id').select2({
        theme: 'bootstrap4'
    })

    //Date picker
    $('#zakatTransactionDate').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
    });

    $(function() {
        bsCustomFileInput.init();
    });

    $('#formStore').on('submit', function(e) {
        e.preventDefault();

        const route = $('#formStore').attr('action');
        const formData = $("#formStore").serialize();

        $.ajax({
            url: route,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: formData,
            beforeSend: function() {
                // Hapus pesan error sebelumnya
                $('#formStore .is-invalid').removeClass('is-invalid');
                $('#formStore .invalid-feedback').remove();

                $('#formStore .fa-spinner').show();
                $('#formStore .fa-save').hide();
            },
            success: function(res) {
                $('#formStore .fa-spinner').hide();
                $('#formStore .fa-save').show();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: res.message,
                    showClass: {
                        popup: `animate__animated animate__fadeInUp animate__faster`
                    },
                    hideClass: {
                        popup: `animate__animated animate__fadeOutDown animate__faster`
                    }
                }).then(() => {
                    window.location.href = res.redirect;
                });
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;

                    if (errors.muzakki_id) {
                        $('#muzakki_id').addClass('is-invalid').after(`<div class="invalid-feedback">${errors.muzakki_id}</div>`);
                    }

                    if (errors.types_of_zakat) {
                        $('#types_of_zakat').addClass('is-invalid').after(`<div class="invalid-feedback">${errors.types_of_zakat}</div>`);
                    }

                    if (errors.amount) {
                        $('#amount').addClass('is-invalid').after(`<div class="invalid-feedback">${errors.amount}</div>`);
                    }

                    if (errors.zakat_transaction_date) {
                        $('#zakat_transaction_date').addClass('is-invalid').after(`<div class="invalid-feedback">${errors.zakat_transaction_date}</div>`);
                    }

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: xhr.responseJSON.message,
                        showClass: {
                            popup: `animate__animated animate__fadeInUp animate__faster`
                        },
                        hideClass: {
                            popup: `animate__animated animate__fadeOutDown animate__faster`
                        }
                    });
                }
                $('#formStore .fa-spinner').hide();
                $('#formStore .fa-save').show();
            }
        });
    });
</script>
@endpush