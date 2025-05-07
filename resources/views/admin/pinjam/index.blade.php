@extends('layouts.admin')
@section('content')

<div class="main-panel">
  <div class="content-wrapper">

    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h4 class="card-title">Data Pinjam</h4>
                    <a href="{{ route('dashboard') }}">Dashboard / Pinjam</a>
            </div>
            <a href="{{route('Pinjam.create')}}" class="btn btn-primary">Tambah Data</a>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Profile</th>
                    <th>VatNo.</th>
                    <th>Created</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Jacob</td>
                    <td>53275531</td>
                    <td>12 May 2017</td>
                    <td><label class="badge badge-danger">Pending</label></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection
