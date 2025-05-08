@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-4 mb-4 stretch-card transparent">
            <div class="card card-tale">
                <div class="card-body">
                    <p class="mb-4">Total Nasabah</p>
                    <p class="fs-30 mb-2" id="total-nasabah">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4 stretch-card transparent">
            <div class="card card-dark-blue">
                <div class="card-body">
                    <p class="mb-4">Total Simpanan</p>
                    <p class="fs-30 mb-2" id="total-simpanan">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4 stretch-card transparent">
            <div class="card card-light-blue">
                <div class="card-body">
                    <p class="mb-4">Total Pinjaman</p>
                    <p class="fs-30 mb-2" id="total-pinjaman">0</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-3">
                <div id="container2" style="width:100%; height:400px;"></div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card mb-3">
                <div id="container3" style="width:100%; height:400px;"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            Highcharts.chart('container2', {
                title: {
                    text: 'Kenaikan Pinjaman dan Simpanan',
                    align: 'left'
                },
                yAxis: {
                    title: {
                        text: 'Hitungan Angka Pinjaman dan Simpanan'
                    }
                },

                xAxis: {
                    accessibility: {
                        rangeDescription: 'Range: 2010 to 2022'
                    }
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
                        pointStart: 2010
                    }
                },

                series: [{
                    name: 'Karyawan',
                    data: [
                        43934, 48656, 65165, 81827, 112143, 142383,
                        171533, 165174, 155157, 161454, 154610, 168960, 171558
                    ]
                }, {
                    name: 'Nasabah',
                    data: [
                        24916, 37941, 29742, 29851, 32490, 30282,
                        38121, 36885, 33726, 34243, 31050, 33099, 33473
                    ]
                }, {
                    name: 'Perusahaan',
                    data: [
                        11744, 30000, 16005, 19771, 20185, 24377,
                        32147, 30912, 29243, 29213, 25663, 28978, 30618
                    ]
                }, {
                    name: 'Perorangan',
                    data: [
                        null, null, null, null, null, null, null,
                        null, 11164, 11218, 10077, 12530, 16585
                    ]
                }, {
                    name: 'Lainnya',
                    data: [
                        21908, 5548, 8105, 11248, 8989, 11816, 18274,
                        17300, 13053, 11906, 10073, 11471, 11648
                    ]
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
