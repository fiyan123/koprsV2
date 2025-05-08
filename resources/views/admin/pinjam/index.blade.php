@extends('layouts.admin')
@section('title', 'Pinjaman')
@section('breadcrumb')
    <x-dashboard.breadcrumb title="Data Pinjaman" page="Home" active="Pinjaman" route="{{ route('home') }}" />
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-flex justify-content-end align-items-center">
                    <a href="{{ route('pinjaman.create') }}" class="btn btn-primary">Tambah Data</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered">
                            <thead>
                                <tr class="fw-bolder">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>NIP</th>
                                    <th>Jumlah Pinjaman</th>
                                    <th>Durasi (bulan)</th>
                                    <th>Bunga (%)</th>
                                    <th>Angsuran / Bulan</th>
                                    <th>Total Bayar</th>
                                    <th>No Rekening</th>
                                    <th>Status</th>
                                    <th>Actions</th>
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
            columns: [
                { data: 'DT_RowIndex' },
                { data: 'nama' },
                { data: 'alamat' },
                { data: 'nip' },
                { data: 'jumlah' },
                { data: 'durasi' },
                { data: 'bunga' },
                { data: 'angsuran_per_bulan' },
                { data: 'total_bayar' },
                { data: 'no_rek' },
                { data: 'status' },
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
