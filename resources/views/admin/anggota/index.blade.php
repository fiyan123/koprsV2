@extends('layouts.admin')
@section('title', 'Anggota')
@section('breadcrumb')
    <x-dashboard.breadcrumb title="Data Anggota" page="Home" active="Anggota" route="{{ route('home') }}" />
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-flex justify-content-end align-items-center">
                    <a href="{{ route('anggota.create') }}" class="btn btn-primary">Tambah Data</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered display responsive nowrap" style="width:100%">
                            <thead>
                                <tr class="fw-bolder">
                                    <th scope="col">No</th>
                                    <th scope="col" class="min-w-100px">Nama</th>
                                    <th scope="col" class="min-w-100px">Email</th>
                                    <th scope="col" class="min-w-100px">NIP</th>
                                    <th scope="col" class="min-w-100px">Tanggal Lahir</th>
                                    <th scope="col" class="min-w-100px">Alamat</th>
                                    <th scope="col" class="min-w-100px">Saldo</th>
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
                    title: 'Apakah anda yakin?',
                    text: "Data akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('anggota') }}/" + id,
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res, status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil dihapus',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    $('#dataTable').DataTable().ajax.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: xhr.responseJSON?.message || 'Terjadi kesalahan.',
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
                    url: "{{ route('anggota.index') }}",
                    type: 'GET',
                },
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'tgl_lahir' },
                    { data: 'nip' },
                    { data: 'alamat' },
                    { data: 'saldo_akhir' },
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
