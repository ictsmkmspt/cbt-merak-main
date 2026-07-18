@extends('layouts/guru_baru')
@section('title', 'Koreksi Essay - Daftar Siswa')
@section('content')
<?php include(app_path().'/functions/koneksi.php'); ?>

<div class="col-md-12 dash-left">
  <ol class="breadcrumb">
    <li><a href="{{ url('/guru') }}">Home</a></li>
    <li><a href="{{ url('/essay') }}">Koreksi Essay</a></li>
    <li class="active">{{ $soal->paket }}</li>
  </ol>

  <div class="panel panel-default">
    <div class="panel-heading" style="background:#072047;color:#fff">
      ✏️ Koreksi Essay — <b>{{ $soal->paket }}</b>
    </div>
    <div class="panel-body">

      @if(session('success'))
        <div class="alert alert-success">
          <i class="fa fa-check"></i> {{ session('success') }}
        </div>
      @endif

      <div class="alert alert-info">
        <i class="fa fa-info-circle"></i>
        Klik <b>Koreksi</b> pada siswa yang ingin dinilai jawaban essaynya.
        Status <span class="label label-success">Selesai</span> berarti semua soal essay sudah dikoreksi.
      </div>

      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th style="width:40px">#</th>
              <th>Nama Siswa</th>
              <th style="width:120px">Kelas</th>
              <th style="width:120px;text-align:center">Soal Essay</th>
              <th style="width:120px;text-align:center">Status</th>
              <th style="width:120px;text-align:center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @if($siswa_list->count())
            <?php $no = 1; ?>
            @foreach($siswa_list as $siswa)
            <?php
              // Ambil nama kelas
              $conn2 = new mysqli($hostdb, $userdb, $passdb, $namedb);
              $rk = $conn2->query("SELECT nama FROM kelas WHERE id='".$siswa->id_kelas."' LIMIT 1");
              $nama_kelas = '-';
              if ($rk && $rk->num_rows > 0) {
                $rowk = $rk->fetch_assoc();
                $nama_kelas = $rowk['nama'];
              }
              $conn2->close();
              $selesai = ($siswa->sudah_koreksi >= $siswa->total_essay && $siswa->total_essay > 0);
            ?>
            <tr>
              <td>{{ $no++ }}</td>
              <td><b>{{ $siswa->nama }}</b></td>
              <td>{{ $nama_kelas }}</td>
              <td style="text-align:center">
                <span class="label label-info">{{ $siswa->total_essay }} soal</span>
              </td>
              <td style="text-align:center">
                @if($selesai)
                  <span class="label label-success">✅ Selesai</span>
                @else
                  <span class="label label-warning">
                    {{ $siswa->sudah_koreksi }}/{{ $siswa->total_essay }} dikoreksi
                  </span>
                @endif
              </td>
              <td style="text-align:center">
                <a href="{{ url('/essay/koreksi/'.$soal->id.'/'.$siswa->id_user) }}"
                   class="btn btn-{{ $selesai ? 'success' : 'primary' }} btn-xs">
                  <i class="fa fa-pencil-square-o"></i>
                  {{ $selesai ? 'Lihat Ulang' : 'Koreksi' }}
                </a>
              </td>
            </tr>
            @endforeach
            @else
            <tr>
              <td colspan="6" class="alert alert-warning text-center">
                Belum ada siswa yang mengumpulkan jawaban untuk paket soal ini.
              </td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>

      <a href="{{ url('/essay') }}" class="btn btn-default btn-sm">
        <i class="fa fa-arrow-left"></i> Kembali
      </a>

    </div>
  </div>
</div>
@endsection
