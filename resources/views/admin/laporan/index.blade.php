@extends('layouts.admin')

@section('title', 'Laporan Data')

@section('breadcrumb')
    <x-dashboard.breadcrumb title="Data Laporan" page="Home" active="Laporan" route="{{ route('laporan') }}" />
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <div class="row mb-3">
                        <div class="col-md-3 mb-3">
                            <label for="tahun" class="form-label">Data Tahun</label>
                            <select class="form-control" id="tahun">
                                @php
                                    $currentYear = \Carbon\Carbon::now()->year;
                                @endphp
                                @for ($year = $currentYear; $year >= 2020; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="bulan" class="form-label">Data Bulan</label>
                            <select class="form-control" id="bulan" name="bulan">
                                @php
                                    $currentMonth = \Carbon\Carbon::now()->month;
                                @endphp
                                @for ($month = 1; $month <= 12; $month++)
                                    @php
                                        $carbonMonth = \Carbon\Carbon::create()->month($month);
                                    @endphp
                                    <option value="{{ $carbonMonth->format('m') }}"
                                        {{ $month == $currentMonth ? 'selected' : '' }}>
                                        {{ $carbonMonth->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3 mb-3 d-flex align-items-end">
                            <button type="button" class="btn btn-primary w-50" id="btnFilter" onclick="filterData()">
                                <i class="ri-search-line"></i> Cari
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">

                        <!-- Simpanan Section -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold mb-0">Data Simpanan</h5>
                                <a href="#" id="exportSimpanan" class="btn btn-sm btn-success mb-3">
                                    <i class="fas fa-file-excel me-1"></i> Export Simpanan
                                </a>
                            </div>

                            <div class="mt-2">
                                <div class="d-flex">
                                    <div style="width: 150px;">Total Simpanan</div>
                                    <div class="me-3">:</div>
                                    <div class="jumlah-simpanan">0</div>
                                </div>
                                <div class="d-flex">
                                    <div style="width: 150px;">Jumlah Anggota</div>
                                    <div class="me-3">:</div>
                                    <div class="jumlah-anggota-menyimpan">0</div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Pinjaman Section -->
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold mb-0">Data Pinjaman</h5>
                                <a href="#" id="exportPinjaman" class="btn btn-sm btn-success mb-3">
                                    <i class="fas fa-file-export me-1"></i> Export Pinjaman
                                </a>
                            </div>

                            <div class="mt-2">
                                <div class="d-flex">
                                    <div style="width: 150px;">Total Pinjaman</div>
                                    <div class="me-3">:</div>
                                    <div class="jumlah-pinjaman">0</div>
                                </div>
                                <div class="d-flex">
                                    <div style="width: 150px;">Jumlah Peminjam</div>
                                    <div class="me-3">:</div>
                                    <div class="jumlah-peminjam">0</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function fetchData(tahun = null, bulan = null) {
            $.ajax({
                url: "{{ route('laporan.getDataAjax') }}",
                method: 'GET',
                data: {
                    tahun: tahun,
                    bulan: bulan
                },
                success: function(response) {
                    const jumlahSimpanan = new Intl.NumberFormat('id-ID').format(response.jumlah_simpanan);
                    $('.jumlah-simpanan').text('Rp. ' + jumlahSimpanan);
                    $('.jumlah-anggota-menyimpan').text(response.jumlah_anggota);
                },
                error: function(xhr) {
                    console.error("Gagal memuat data:", xhr.responseText);
                }
            });
        }

        function fetchDataPinjaman(tahun = null, bulan = null) {
            $.ajax({
                url: "{{ route('laporan.getPinjaman') }}",
                method: 'GET',
                data: {
                    tahun: tahun,
                    bulan: bulan
                },
                success: function(response) {
                    // Ubah dari string "100,000.00" ke number (hapus koma dulu)
                    const rawJumlahPinjaman = parseFloat(response.total_jumlah_pinjaman_all.replace(/,/g, ''));

                    const jumlahPinjaman = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(rawJumlahPinjaman);

                    $('.jumlah-pinjaman').text(jumlahPinjaman);
                    $('.jumlah-peminjam').text(response.total_user_pinjaman_all);
                },
                error: function(xhr) {
                    console.error("Gagal memuat data:", xhr.responseText);
                }
            });
        }

        function filterData() {
            const tahun = $('#tahun').val();
            const bulan = $('#bulan').val();
            fetchData(tahun, bulan);
            fetchDataPinjaman(tahun, bulan);
        }

        $(document).ready(function() {
            fetchData();
            fetchDataPinjaman();
        });

        document.getElementById('exportSimpanan').addEventListener('click', function(e) {
            e.preventDefault();
            let tahun = document.getElementById('tahun').value;
            let bulan = document.getElementById('bulan').value;

            // Arahkan ke route dengan query string, contoh:
            let url = `{{ route('laporan.simpanan') }}?tahun=${tahun}&bulan=${bulan}`;
            window.location.href = url;
        });

        document.getElementById('exportPinjaman').addEventListener('click', function(e) {
            e.preventDefault();
            let tahun = document.getElementById('tahun').value;
            let bulan = document.getElementById('bulan').value;

            let url = `{{ route('laporan.pinjaman') }}?tahun=${tahun}&bulan=${bulan}`;
            window.location.href = url;
        });
    </script>
@endpush
