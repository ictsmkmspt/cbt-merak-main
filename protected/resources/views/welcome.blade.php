<?php
include(app_path() . '/functions/koneksi.php');
$conn = new mysqli($hostdb, $userdb, $passdb, $namedb);
$namasekolah = '';
$logosekolah = '';
if (!$conn->connect_error) {
    $result = $conn->query("SELECT * FROM schools LIMIT 1");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $namasekolah = $row['nama'];
        $logosekolah = $row['logo'];
    }
}
?>
@extends('layouts/welcome')
@section('content')

<section class="hero-section">

  {{-- Logo --}}
  <div class="hero-logo-wrap">
    @if($logosekolah)
      <img src="{{ url('img/'.$logosekolah) }}" alt="{{ $namasekolah }}" style="width:90px;height:90px;object-fit:contain;border-radius:18px">
    @else
      <img src="{{ url('img/logo.png') }}" alt="Logo" style="width:90px;height:90px;object-fit:contain;border-radius:18px"
           onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
      <div style="display:none;width:90px;height:90px;align-items:center;justify-content:center;background:#eef4ff;border-radius:18px;font-size:42px;color:#1a4fa0">🏫</div>
    @endif
  </div>

  {{-- Badge --}}
  <div class="hero-badge">Computer Based Test</div>

  {{-- Judul --}}
  <h1 class="hero-title">
    Selamat Datang di<br>
    <span>{{ $namasekolah ?: 'Sistem CBT' }}</span>
  </h1>
  <p class="hero-subtitle">
    Platform ujian berbasis komputer yang modern, cepat, dan mudah digunakan.
    Silakan login sesuai peran Anda.
  </p>

  {{-- Tombol Login --}}
  <div class="btn-group-hero">
    <a href="{{ url('guru') }}" class="btn-hero btn-hero-primary">
      <i class="fa fa-user-circle-o"></i> Login Guru
    </a>
    <a href="{{ url('lobby-siswa') }}" class="btn-hero btn-hero-yellow">
      <i class="fa fa-graduation-cap"></i> Login Siswa
    </a>
  </div>



</section>

@endsection
