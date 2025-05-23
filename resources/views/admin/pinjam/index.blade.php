@extends('layouts.admin')

@section('title', 'Pinjaman')

@section('breadcrumb')
    <x-dashboard.breadcrumb title="Data Pinjaman" page="Home" active="Pinjaman" route="{{ route('home') }}" />
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                @if(auth()->user()->hasRole('anggota'))
                <div class="card-body d-flex justify-content-end align-items-center">
                    <a href="{{ route('pinjaman.create') }}" class="btn btn-primary">Tambah Data</a>
                </div>
                @endif

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered display responsive nowrap" style="width:100%">
                            <thead>
                                <tr class="fw-bolder">
                                    <th scope="col">No</th>
                                    <th scope="col" class="min-w-100px">Nama</th>
                                    <th scope="col" class="min-w-100px">Tanggal Lahir</th>
                                    <th scope="col" class="min-w-100px">Nip</th>
                                    <th scope="col" class="min-w-100px">Jumlah Pinjaman</th>
                                    <th scope="col" class="min-w-100px">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            loadData();

            $(document).on('click', '.delete', function() {
                let id = $(this).attr('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Data akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('pinjaman.destroy') }}",
                            type: 'POST',
                            data: {
                                id: id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res, status) {
                                if (status == '200') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Data Berhasil Dihapus',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        $('#dataTable').DataTable().ajax.reload();
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: xhr.responseJSON.text,
                                });
                            }
                        });
                    }
                });
            });
        });

        function loadData() {
            $('#dataTable').DataTable({
                scrollX: true,
                pageLength: 10,
                searching: true,
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: {
                    url: "{{ route('pinjaman.index') }}",
                    type: 'GET',
                },
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'tgl_lahir'
                    },
                    {
                        data: 'nip'
                    },
                    {
                        data: 'jumlah'
                    },
                    {
                        data: 'action',
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        }
    </script>
@endpush
