@extends('app.layout')

@section('title', 'Master '.$title)

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
@endpush

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Master {{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('muzakkis.index') }}">Master {{ $title }}</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                        <form action="{{ route('muzakkis.update', $data->id) }}" method="post" id="formUpdate" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Edit {{ $data->name }}</h5>
                                    <div class="card-tools">
                                        <a href="{{ route('muzakkis.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @include('muzakkis.form', ['data' => $data])
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
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <script>
        $('#formUpdate').on('submit', function (e) {
            e.preventDefault();

            const route = $('#formUpdate').attr('action');
            const formData = $("#formUpdate").serialize();
           
            $.ajax({
                url: route,
                method: 'PUT',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                data: formData,
                beforeSend: function() {
                    // Hapus pesan error sebelumnya
                    $('#formUpdate .is-invalid').removeClass('is-invalid');
                    $('#formUpdate .invalid-feedback').remove();

                    $('#formUpdate .fa-spinner').show();
                    $('#formUpdate .fa-save').hide();
                },
                success: function (res) {
                    $('#formUpdate .fa-spinner').hide();
                    $('#formUpdate .fa-save').show();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message,
                        showClass: {popup: `animate__animated animate__fadeInUp animate__faster`},
                        hideClass: {popup: `animate__animated animate__fadeOutDown animate__faster`}
                    }).then(() => {
                        window.location.href = res.redirect;
                    });
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;

                        if (errors.name) {
                            $('#name').addClass('is-invalid').after(`<div class="invalid-feedback">${errors.name}</div>`);
                        }

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: xhr.responseJSON.message,
                            showClass: {popup: `animate__animated animate__fadeInUp animate__faster`},
                            hideClass: {popup: `animate__animated animate__fadeOutDown animate__faster`}
                        });
                    }
                    $('#formUpdate .fa-spinner').hide();
                    $('#formUpdate .fa-save').show();
                }
            });
        });

    </script>
@endpush