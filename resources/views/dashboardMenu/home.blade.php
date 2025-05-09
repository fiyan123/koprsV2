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
                    const jumlahAnggota = parseInt(response.count_nasabah_all) || 0;

                    Highcharts.chart('container2', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: `Jumlah Simpanan, Pinjaman dan Anggota (${tahun}/${bulan})`,
                            align: 'left'
                        },
                        xAxis: {
                            categories: ['Data Keuangan'],
                            crosshair: true
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Jumlah'
                            },
                            labels: {
                                formatter: function() {
                                    return this.value.toLocaleString('id-ID');
                                }
                            }
                        },
                        tooltip: {
                            shared: false, // <== Ini kunci agar tidak digabung
                            useHTML: true,
                            pointFormat: '<b>{series.name}: {point.y:,.0f}</b>',
                            valueDecimals: 2
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.2,
                                borderWidth: 0
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
                        ]
                    });
                },
                error: function(xhr) {
                    console.error("Gagal memuat data:", xhr.responseText);
                }
            });
        }

        function loadBarChart1() {
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
                    const jumlahNasabah = parseInt(response.count_nasabah_all) || 0;

                    // Container 1: Simpanan (Pie)
                    Highcharts.chart('container1', {
                        chart: {
                            type: 'pie'
                        },
                        title: {
                            text: `Komposisi Data Simpanan (${tahun}/${bulan})`
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.y:,.0f}</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    format: '<b>{point.name}</b>: {point.y:,.0f}',
                                    style: {
                                        fontSize: '13px'
                                    }
                                }
                            }
                        },
                        series: [{
                            name: 'Simpanan',
                            colorByPoint: true,
                            data: [{
                                    name: 'Jumlah Nasabah',
                                    y: jumlahNasabah
                                },
                                {
                                    name: 'Total Simpanan',
                                    y: jumlahSimpanan
                                }
                            ]
                        }]
                    });
                },
                error: function(xhr) {
                    console.error("Gagal mengambil data rekap:", xhr.responseText);
                }
            });
        }

        function loadBarChart2() {
            const tahun = $('#tahun').val();
            const bulan = $('#bulan').val();

            $.ajax({
                url: "{{ route('getTotalPinjamanHome') }}",
                method: 'GET',
                data: {
                    tahun,
                    bulan
                },
                success: function(response) {
                    const totalPinjaman = parseFloat(response.data.replace(/,/g, '')) || 0;
                    const totalBayar = parseFloat(response.total_bayar.replace(/,/g, '')) || 0;
                    const totalDenda = parseFloat(response.total_denda.replace(/,/g, '')) || 0;
                    const totalKeuntungan = parseFloat(response.total_keuntungan.replace(/,/g, '')) || 0;

                    Highcharts.chart('container3', {
                        chart: {
                            type: 'pie',
                            zooming: {
                                type: 'xy'
                            },
                            panning: {
                                enabled: true,
                                type: 'xy'
                            },
                            panKey: 'shift'
                        },
                        title: {
                            text: `Komposisi Detail Pinjaman (${tahun}/${bulan})`
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.y:,.0f}</b>'
                        },
                        series: [{
                            name: 'Detail',
                            colorByPoint: true,
                            data: [{
                                    name: 'Total Pinjaman',
                                    y: totalPinjaman
                                },
                                {
                                    name: 'Total Pembayaran',
                                    y: totalBayar
                                },
                                {
                                    name: 'Total Denda',
                                    y: totalDenda
                                },
                                {
                                    name: 'Total Keuntungan',
                                    y: totalKeuntungan
                                }
                            ]
                        }]
                    });
                },
                error: function(xhr) {
                    console.error("Gagal mengambil data pinjaman:", xhr.responseText);
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
            loadBarChart1(tahun, bulan);
            loadBarChart2(tahun, bulan);
            renderData(tahun, bulan);
        }

        // Panggil default saat halaman pertama kali dimuat
        $(document).ready(function() {
            const tahun = $('#tahun').val();
            const bulan = $('#bulan').val();
            renderChartSimpanan(tahun, bulan);
            loadBarChart1(tahun, bulan);
            loadBarChart2(tahun, bulan);
            renderData(tahun, bulan);
        });
    </script>
@endpush
