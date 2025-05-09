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
                                <tr class="fw-bold text-center">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    {{-- <th>Jenis Simpanan</th> --}}
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan di-load melalui AJAX -->
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
            const table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('simpanan.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center" },
                    { data: 'nama', name: 'nama' },
                    { data: 'nip', name: 'nip' },
                    { data: 'jumlah', name: 'jumlah' },
                    { data: 'status', name: 'status' },
                    // { data: 'jenis_simpanan', name: 'jenis_simpanan' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center" }
                ],
                columnDefs: [{
                    defaultContent: "-",
                    targets: "_all"
                }]
            });

            // DELETE HANDLER
            $(document).on('click', '.delete', function() {
                const id = $(this).attr('id');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('simpanan.destroy') }}",
                            type: 'POST',
                            data: {
                                id: id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Data berhasil dihapus.',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: xhr.responseJSON.message || 'Terjadi kesalahan.',
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
