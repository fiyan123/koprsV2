@extends('layouts.admin')
@section('title', 'Saldo Koperasi')
@section('breadcrumb')
    <x-dashboard.breadcrumb title="Data Saldo Koperasi" page="Home" active="Saldo Koperasi" route="{{ route('home') }}" />
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-flex justify-content-end align-items-center">
                    <a href="{{ route('saldo.create') }}" class="btn btn-primary">Tambah Saldo</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered display responsive nowrap" style="width:100%">
                            <thead>
                                <tr class="fw-bolder">
                                    <th>No</th>
                                    <th>Jumlah Saldo</th>
                                    <th>Jenis Saldo</th>
                                    <th>Status</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
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
        $(document).ready(function () {
            loadData();
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
                    url: "{{ route('saldo.index') }}",
                    type: 'GET',
                },
                columnDefs: [{
                    defaultContent: "-",
                    targets: "_all"
                }],
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'jumlah_saldo', name: 'jumlah_saldo' },
                    { data: 'type_saldo', name: 'type_saldo' },
                    { data: 'status_saldo', name: 'status_saldo' },
                    { data: 'description', name: 'description' },
                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        }
    </script>
@endpush
