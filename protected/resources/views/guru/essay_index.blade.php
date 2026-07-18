@extends('layouts/guru_baru')
@section('title', 'Koreksi Essay')
@section('content')
<?php include(app_path().'/functions/koneksi.php'); ?>

<div class="col-md-12 dash-left">
  <ol class="breadcrumb">
    <li><a href="{{ url('/guru') }}">Home</a></li>
    <li class="active">Koreksi Essay</li>
  </ol>

  <div class="panel panel-default">
    <div class="panel-heading" style="background:#072047;color:#fff">
      ✏️ Daftar Paket Soal — Koreksi Essay
    </div>
    <div class="panel-body">

      <div class="alert alert-info">
        <i class="fa fa-info-circle"></i>
        Di bawah ini adalah daftar paket soal yang memiliki butir soal <b>Essay</b>.
        Klik <b>Koreksi</b> untuk mulai menilai jawaban siswa.
      </div>

      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th style="width:40px">#</th>
              <th>Paket Soal</th>
              <th>Deskripsi</th>
              <th style="width:80px">KKM</th>
              <th style="width:120px">Jenis</th>
              <th style="width:120px;text-align:center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = $soals->firstItem(); ?>
            @if($soals->count())
            @foreach($soals as $soal)
            <tr>
              <td>{{ $no++ }}</td>
              <td><b>{{ $soal->paket }}</b></td>
              <td>{{ $soal->deskripsi }}</td>
              <td>{{ $soal->kkm }}</td>
              <td>
                @if($soal->jenis == 1)
                  <span class="label label-primary">Ujian</span>
                @else
                  <span class="label label-warning">Latihan</span>
                @endif
              </td>
              <td style="text-align:center">
                <a href="{{ url('/essay/koreksi/'.$soal->id) }}"
                   class="btn btn-primary btn-xs">
                  <i class="fa fa-pencil-square-o"></i> Koreksi
                </a>
              </td>
            </tr>
            @endforeach
            @else
            <tr>
              <td colspan="6" class="alert alert-warning text-center">
                Belum ada paket soal yang memiliki butir essay.
              </td>
            </tr>
            @endif
          </tbody>
        </table>
        {!! $soals->render() !!}
      </div>

    </div>
  </div>
</div>
@endsection
