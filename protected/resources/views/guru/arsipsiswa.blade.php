@extends('layouts/guru_baru')
@section('title', 'Arsip Siswa')
@section('content')
<script src="{{ url('/assets/assets/vendor/jquery.min.js') }}"></script>

<div class="col-sm-12 col-md-12 dash-left">
  <ol class="breadcrumb">
    <li><a href="{{ url('/guru') }}">Home</a></li>
    <li><a href="{{ url('/data-siswa') }}">Siswa</a></li>
    <li class="active">Arsip Siswa</li>
  </ol>

  <div class="panel panel-default">
    <div class="panel-heading" style="background:#072047; color:#fff">Arsip Siswa</div>
    <div class="panel-body">

      <div class="alert alert-warning" style="margin-bottom:15px">
        <i class="fa fa-info-circle"></i> Siswa di daftar ini ikut diarsipkan otomatis karena kelasnya diarsipkan.
        Aktifkan kembali kelas terkait di menu <a href="{{ url('/arsip-kelas') }}"><b>Arsip Kelas</b></a> untuk mengembalikan siswa ini.
      </div>

      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th style="width:40px">#</th>
              <th>Nama Siswa</th>
              <th>No Induk</th>
              <th>Asal Kelas</th>
              <th style="width:100px">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = $siswa_arsip->firstItem(); ?>
            @if($siswa_arsip->count())
            @foreach($siswa_arsip as $s)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $s->nama }}</td>
              <td>{{ $s->no_induk }}</td>
              <td>{{ $s->nama_kelas ?: '-' }}</td>
              <td><span class="label label-default">Diarsipkan</span></td>
            </tr>
            @endforeach
            @else
            <tr><td colspan="5" class="alert alert-info text-center">Belum ada siswa yang diarsipkan.</td></tr>
            @endif
          </tbody>
        </table>
        {!! $siswa_arsip->render() !!}
      </div>

    </div>
  </div>
</div>
@endsection
