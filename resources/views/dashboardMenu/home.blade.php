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
                    <div id="container2" style="width:100%; height:400px;"></div>
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
@endsection

@push('scripts')
    <script>
        function renderChartSimpanan(tahun = null, bulan = null) {
            $.ajax({
                url: "{{ route('laporan.getDataAjax') }}",
                method: 'GET',
                data: {
                    tahun: tahun,
                    bulan: bulan
                },
                success: function(response) {
                    Highcharts.chart('container2', {
                        title: {
                            text: `Jumlah Simpanan dan Anggota (${tahun}/${bulan})`,
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
                            data: [response.count_jumlah_all]
                        }, {
                            name: 'Jumlah Anggota',
                            data: [response.jumlah_anggota]
                        }],
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

        function filterData() {
            const tahun = $('#tahun').val();
            const bulan = $('#bulan').val();
            renderChartSimpanan(tahun, bulan);
        }

        // Panggil default saat halaman pertama kali dimuat
        $(document).ready(function() {
            const tahun = $('#tahun').val();
            const bulan = $('#bulan').val();
            renderChartSimpanan(tahun, bulan);
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
                    text: 'Persentase Pinjaman dan Simpanan'
                },
                tooltip: {
                    valueSuffix: '%'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: [{
                            enabled: true,
                            distance: 20
                        }, {
                            enabled: true,
                            distance: -40,
                            format: '{point.percentage:.1f}%',
                            style: {
                                fontSize: '1.2em',
                                textOutline: 'none',
                                opacity: 0.7
                            },
                            filter: {
                                operator: '>',
                                property: 'percentage',
                                value: 10
                            }
                        }]
                    }
                },
                series: [{
                    name: 'Percentage',
                    colorByPoint: true,
                    data: [{
                            name: 'Water',
                            y: 55.02
                        },
                        {
                            name: 'Fat',
                            sliced: true,
                            selected: true,
                            y: 26.71
                        },
                        {
                            name: 'Carbohydrates',
                            y: 1.09
                        },
                        {
                            name: 'Protein',
                            y: 15.5
                        },
                        {
                            name: 'Ash',
                            y: 1.68
                        }
                    ]
                }]
            });
        });
    </script>
@endpush
