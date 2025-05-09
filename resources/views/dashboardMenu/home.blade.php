@extends('layouts.admin')

@section('content')
    <div class="row mb-4">
        <!-- Filter Section -->
        <div class="col-12">
            <div class="card p-3">
                <div class="row align-items-end">
                    <div class="col-md-4 mb-3">
                        <label for="tahun" class="form-label">Data Tahun</label>
                        <select class="form-control" id="tahun">
                            @php $currentYear = \Carbon\Carbon::now()->year; @endphp
                            @for ($year = $currentYear; $year >= 2020; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="bulan" class="form-label">Data Bulan</label>
                        <select class="form-control" id="bulan" name="bulan">
                            @php $currentMonth = \Carbon\Carbon::now()->month; @endphp
                            @for ($month = 1; $month <= 12; $month++)
                                @php $carbonMonth = \Carbon\Carbon::create()->month($month); @endphp
                                <option value="{{ $carbonMonth->format('m') }}"
                                    {{ $month == $currentMonth ? 'selected' : '' }}>
                                    {{ $carbonMonth->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <button type="button" class="btn btn-primary w-50" id="btnFilter" onclick="filterData()">
                            <i class="ri-search-line"></i> Cari Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card card-tale text-center p-3">
                <p class="mb-2">Total Nasabah</p>
                <h3 id="total-nasabah" class="fs-30 mb-0">0</h3>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card card-dark-blue text-center p-3">
                <p class="mb-2">Total Simpanan</p>
                <h3 id="total-simpanan" class="fs-30 mb-0">0</h3>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card card-light-blue text-center p-3">
                <p class="mb-2">Total Pinjaman</p>
                <h3 id="total-pinjaman" class="fs-30 mb-0">0</h3>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div id="container1" style="width:100%; height:400px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div id="container3" style="width:100%; height:400px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div id="container2" style="width:100%; height:400px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function renderChartSimpanan(tahun = null, bulan = null) {
            $.ajax({
                url: "{{ route('getRekapKeuangan') }}",
                method: 'GET',
                data: {
                    tahun: tahun,
                    bulan: bulan
                },
                success: function(response) {
                    const jumlahSimpanan = parseFloat(response.count_jumlah_all.replace(/,/g, '')) || 0;
                    const jumlahPinjaman = parseFloat(response.total_jumlah_pinjaman_all.replace(/,/g, '')) ||
                    0;
                    const jumlahAnggota = response.count_nasabah_all || 0;

                    Highcharts.chart('container2', {
                        title: {
                            text: `Jumlah Simpanan, Pinjaman dan Anggota (${tahun}/${bulan})`,
                            align: 'left'
                        },
                        yAxis: {
                            title: {
                                text: 'Jumlah'
                            }
                        },
                        xAxis: {
                            categories: [`${tahun}/${bulan}`]
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                        },
                        plotOptions: {
                            series: {
                                label: {
                                    connectorAllowed: false
                                },
                            }
                        },
                        series: [{
                                name: 'Jumlah Simpanan',
                                data: [jumlahSimpanan],
                                color: '#007bff'
                            },
                            {
                                name: 'Jumlah Pinjaman',
                                data: [jumlahPinjaman],
                                color: '#28a745'
                            },
                            {
                                name: 'Jumlah Anggota',
                                data: [jumlahAnggota],
                                color: '#ffc107'
                            }
                        ],
                        responsive: {
                            rules: [{
                                condition: {
                                    maxWidth: 500
                                },
                                chartOptions: {
                                    legend: {
                                        layout: 'horizontal',
                                        align: 'center',
                                        verticalAlign: 'bottom'
                                    }
                                }
                            }]
                        }
                    });
                },
                error: function(xhr) {
                    console.error("Gagal memuat data:", xhr.responseText);
                }
            });
        }

        function loadBarCharts() {
            const tahun = $('#tahun').val();
            const bulan = $('#bulan').val();

            $.ajax({
                url: "{{ route('getRekapKeuangan') }}",
                method: 'GET',
                data: {
                    tahun,
                    bulan
                },
                success: function(response) {
                    const jumlahSimpanan = parseFloat(response.count_jumlah_all.replace(/,/g, '')) || 0;
                    const jumlahPinjaman = parseFloat(response.total_jumlah_pinjaman_all.replace(/,/g, '')) ||
                        0;
                    const jumlahNasabah = response.count_nasabah_all || 0;

                    // Container 1: Simpanan
                    Highcharts.chart('container1', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Data Simpanan'
                        },
                        xAxis: {
                            categories: ['Jumlah Nasabah', 'Total Simpanan']
                        },
                        yAxis: {
                            title: {
                                text: 'Nilai (Rp)'
                            }
                        },
                        series: [{
                            name: 'Simpanan',
                            data: [jumlahNasabah, jumlahSimpanan],
                            color: '#007bff'
                        }]
                    });

                    // Container 3: Pinjaman
                    Highcharts.chart('container3', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Data Pinjaman'
                        },
                        xAxis: {
                            categories: ['Jumlah Nasabah', 'Total Pinjaman']
                        },
                        yAxis: {
                            title: {
                                text: 'Nilai (Rp)'
                            }
                        },
                        series: [{
                            name: 'Pinjaman',
                            data: [jumlahNasabah, jumlahPinjaman],
                            color: '#28a745'
                        }]
                    });
                },
                error: function(xhr) {
                    console.error("Gagal mengambil data rekap:", xhr.responseText);
                }
            });
        }

        function renderData(tahun = null, bulan = null) {
            $.ajax({
                url: "{{ route('getRekapKeuangan') }}",
                method: 'GET',
                data: {
                    tahun: tahun,
                    bulan: bulan
                },
                success: function(response) {
                    console.log(response);
                    $('#total-nasabah').text(response.count_nasabah_all);
                    $('#total-simpanan').text(response.count_jumlah_all);
                    $('#total-pinjaman').text(response.total_jumlah_pinjaman_all);
                },
                error: function(xhr) {
                    console.error("Gagal memuat data:", xhr.responseText);
                }
            });
        }

        function filterData() {
            const tahun = $('#tahun').val();
            const bulan = $('#bulan').val();
            renderChartSimpanan(tahun, bulan);
            loadBarCharts(tahun, bulan);
            renderData(tahun, bulan);
        }

        // Panggil default saat halaman pertama kali dimuat
        $(document).ready(function() {
            const tahun = $('#tahun').val();
            const bulan = $('#bulan').val();
            renderChartSimpanan(tahun, bulan);
            loadBarCharts(tahun, bulan);
            renderData(tahun, bulan);
        });
    </script>
@endpush
