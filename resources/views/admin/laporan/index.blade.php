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
                            <select class="form-control" id="bulan">
                                <option value="null">Pilih Bulan</option>
                                @for ($month = 1; $month <= 12; $month++)
                                    @php
                                        $carbonMonth = \Carbon\Carbon::create()->month($month);
                                    @endphp
                                    <option value="{{ $carbonMonth->format('m') }}">{{ $carbonMonth->format('F') }}</option>
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
                                <a href="{{ route('simpanan.index') }}" class="btn btn-sm btn-success mb-3">
                                    <i class="fas fa-file-excel me-1"></i> Export Simpanan
                                </a>
                            </div>

                            <div class="mt-2">
                                <div class="d-flex">
                                    <div style="width: 150px;">Total Simpanan</div>
                                    <div class="me-3">:</div>
                                    <div>Rp. 10.000.000</div>
                                </div>
                                <div class="d-flex">
                                    <div style="width: 150px;">Jumlah Anggota</div>
                                    <div class="me-3">:</div>
                                    <div>120</div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Pinjaman Section -->
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold mb-0">Data Pinjaman</h5>
                                <a href="{{ route('pinjaman.index') }}" class="btn btn-sm btn-primary mb-3">
                                    <i class="fas fa-file-export me-1"></i> Export Pinjaman
                                </a>
                            </div>

                            <div class="mt-2">
                                <div class="d-flex">
                                    <div style="width: 150px;">Total Pinjaman</div>
                                    <div class="me-3">:</div>
                                    <div>Rp. 25.000.000</div>
                                </div>
                                <div class="d-flex">
                                    <div style="width: 150px;">Jumlah Peminjam</div>
                                    <div class="me-3">:</div>
                                    <div>85</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
