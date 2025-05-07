@extends('layouts.admin')
@section('title', 'Simpanan')
@section('breadcrumb')
    <x-dashboard.breadcrumb title="Data Simpanan" page="Home" active="Simpanan" route="{{ route('home') }}" />
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-flex justify-content-end align-items-center">
                    <a href="{{ route('simpanan.create') }}" class="btn btn-primary">Tambah Data</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered">
                            <thead>
                                <tr class="fw-bolder">
                                    <th scope="col">No</th>
                                    <th scope="col" class="min-w-100px">Nama</th>
                                    <th scope="col" class="min-w-100px">Alamat</th>
                                    <th scope="col" class="min-w-100px">NIP</th>
                                    <th scope="col" class="min-w-80px">Nomor HP</th>
                                    <th scope="col" class="min-w-80px">Jumlah</th>
                                    <th scope="col" class="min-w-80px">Bukti Transfer</th>
                                    <th scope="col" class="min-w-80px">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="">
                            </tbody>
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
                let id = $(this).attr('id')
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('simpanan.destroy') }}",
                            type: 'post',
                            data: {
                                id: id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res, status) {
                                if (status = '200') {
                                    setTimeout(() => {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Data Berhasil Dihapus',
                                            showConfirmButton: false,
                                            timer: 1500
                                        }).then((res) => {
                                            $('#dataTable').DataTable()
                                                .ajax.reload()
                                        })
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: xhr.responseJSON.text,
                                })
                            }
                        })
                    }
                })
            });
        });

        function loadData() {
            table = $('#dataTable').DataTable({
                pageLength: 10,
                searching: true,
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: {
                    url: "{{ route('simpanan.index') }}",
                    type: 'GET',
                },

                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                columns: [{
                        data: 'DT_RowIndex',
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                    },
                    {
                        data: 'alamat',
                        name: 'alamat',
                    },
                    {
                        data: 'nip',
                        name: 'nip',
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp',
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah',
                    },
                    {
                        data: 'bukti_tf',
                        name: 'bukti_tf',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        }
    </script>
@endpush
