@extends('layouts/welcome')
@section('content')
<?php
  include(app_path() . '/functions/koneksi.php');
  $conn = new mysqli($hostdb, $userdb, $passdb, $namedb);
  $namasekolah = ''; $logosekolah = '';
  if (!$conn->connect_error) {
    $r = $conn->query("SELECT * FROM schools LIMIT 1");
    if ($r && $r->num_rows > 0) {
      $row = $r->fetch_assoc();
      $namasekolah = $row['nama'];
      $logosekolah = $row['logo'];
    }
  }
?>
<div class="cbt-main">
  <div class="cbt-card">

    {{-- LOGO SEKOLAH --}}
    <div class="cbt-logo-wrap">
      <div id="card-logo-wrap">
        @if($logosekolah)
          <img src="{{ url('img/'.$logosekolah) }}" alt="{{ $namasekolah }}" class="cbt-logo">
        @else
          <div class="cbt-logo-fallback">
            <i class="material-icons">school</i>
          </div>
        @endif
      </div>
    </div>

    {{-- NAMA & SUBTITLE --}}
    <div class="cbt-school">{{ $namasekolah ?: 'Selamat Datang' }}</div>
    <div class="cbt-subtitle">Computer Based Test &mdash; Ujian Berbasis Komputer</div>

    {{-- DIVIDER --}}
    <div class="cbt-divider">
      <div class="cbt-divider-line"></div>
      <div class="cbt-divider-text">Masuk sebagai</div>
      <div class="cbt-divider-line"></div>
    </div>

    {{-- TOMBOL LOGIN --}}
    <div class="cbt-btn-group">
      <a href="{{ url('/auth/login') }}" class="cbt-btn cbt-btn-guru" style="text-decoration:none">
        <div class="cbt-btn-icon"><i class="material-icons" style="font-size:22px">admin_panel_settings</i></div>
        <span class="cbt-btn-label">Guru</span>
        <span class="cbt-btn-desc">Administrator</span>
      </a>
      <a href="{{ url('/lobby-siswa') }}" class="cbt-btn cbt-btn-siswa" style="text-decoration:none">
        <div class="cbt-btn-icon"><i class="material-icons" style="font-size:22px">school</i></div>
        <span class="cbt-btn-label">Siswa</span>
        <span class="cbt-btn-desc">Peserta Ujian</span>
      </a>
    </div>

    {{-- INFO --}}
    <div class="cbt-info">
      <i class="material-icons">info_outline</i>
      Gunakan email dan password yang diberikan oleh administrator
    </div>

  </div>
</div>
@endsection
