@extends('layouts/siswa_baru')
@section('title', 'Dashboard Siswa')
@section('breadcrumb')
  <li><a href="{{ url('/siswa') }}">Home</a></li>
  <li class="active">Dashboard</li>
@endsection
@section('content')
<?php
  include(app_path() . '/functions/koneksi.php');
  $conn2 = new mysqli($hostdb, $userdb, $passdb, $namedb);
  $namasekolah = '';
  if (!$conn2->connect_error) {
    $r = $conn2->query("SELECT nama FROM schools LIMIT 1");
    if ($r && $r->num_rows > 0) { $row = $r->fetch_assoc(); $namasekolah = $row['nama']; }
  }
  // Ambil nama kelas siswa
  $id_kelas = Auth::user()->id_kelas;
  $nama_kelas = '-';
  $rk = $conn2->query("SELECT nama FROM kelas WHERE id='$id_kelas' LIMIT 1");
  if ($rk && $rk->num_rows > 0) { $rowk = $rk->fetch_assoc(); $nama_kelas = $rowk['nama']; }
?>
<style>
/* HERO CARD */
.hero-card {
  background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 60%, #60a5fa 100%);
  border-radius: 20px;
  padding: 36px 32px;
  color: #fff;
  margin-bottom: 24px;
  position: relative;
  overflow: hidden;
  box-shadow: 0 8px 32px rgba(29,78,216,.28);
}
.hero-card::before {
  content: '';
  position: absolute;
  top: -60px; right: -60px;
  width: 220px; height: 220px;
  background: rgba(255,255,255,.07);
  border-radius: 50%;
}
.hero-card::after {
  content: '';
  position: absolute;
  bottom: -40px; right: 100px;
  width: 140px; height: 140px;
  background: rgba(255,255,255,.05);
  border-radius: 50%;
}
.hero-badge {
  display: inline-flex; align-items: center; gap: 5px;
  background: rgba(255,255,255,.18);
  border: 1px solid rgba(255,255,255,.3);
  border-radius: 20px; padding: 5px 14px;
  font-size: 11px; font-weight: 600; letter-spacing: .8px;
  text-transform: uppercase; margin-bottom: 14px;
}
.hero-greeting { font-size: 13px; color: rgba(255,255,255,.82); margin-bottom: 4px; }
.hero-name { font-size: 28px; font-weight: 800; margin-bottom: 10px; line-height: 1.2; }
.hero-desc { font-size: 13px; color: rgba(255,255,255,.78); max-width: 500px; line-height: 1.7; }
.hero-kelas {
  display: inline-flex; align-items: center; gap: 5px;
  background: rgba(255,255,255,.15); border-radius: 8px;
  padding: 5px 12px; font-size: 12px; font-weight: 600;
  margin-top: 14px;
}

/* NAV CARDS */
.nav-cards {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  margin-bottom: 24px;
}
.nav-card {
  background: #fff;
  border-radius: 18px;
  padding: 28px 20px;
  text-align: center;
  text-decoration: none;
  border: 1px solid #e5e7eb;
  box-shadow: 0 2px 14px rgba(30,58,138,.06);
  transition: all .22s ease;
  display: block;
}
.nav-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 28px rgba(30,58,138,.13);
  text-decoration: none;
}
.nav-card-icon {
  width: 60px; height: 60px;
  border-radius: 16px;
  margin: 0 auto 14px;
  line-height: 60px;
  text-align: center;
  font-size: 30px;
}
.ic-blue   { background: #dbeafe; }
.ic-yellow { background: #fef3c7; }
.ic-green  { background: #d1fae5; }
.ic-purple { background: #ede9fe; }
.nav-card-title {
  font-size: 14px; font-weight: 700; color: #1e3a8a; margin-bottom: 5px;
}
.nav-card-desc { font-size: 11.5px; color: #94a3b8; }

/* Warna border bawah tiap card */
.card-soal   { border-bottom: 3px solid #1d4ed8; }
.card-latihan{ border-bottom: 3px solid #d97706; }
.card-hasil  { border-bottom: 3px solid #059669; }
.card-profil { border-bottom: 3px solid #7c3aed; }

/* INFO BOX */
.info-box {
  background: linear-gradient(135deg, #eff6ff, #fefce8);
  border: 1px solid #e0e7ff; border-radius: 14px;
  padding: 18px 22px;
  display: flex; align-items: center; gap: 14px;
  font-size: 13px; color: #475569;
}
.info-box i { color: #3b82f6; font-size: 22px; flex-shrink: 0; }

@media (max-width: 768px) {
  .nav-cards { grid-template-columns: repeat(2, 1fr); }
  .hero-card { padding: 26px 22px; }
  .hero-name { font-size: 22px; }
}
</style>

{{-- HERO CARD --}}
<div class="hero-card">
  <div class="hero-badge">⭐ Selamat Datang</div>
  <div class="hero-greeting">Assalamu'alaikum,</div>
  <div class="hero-name">{{ Auth::user()->nama }}</div>
  <div class="hero-desc">
    Aplikasi CBT ini dirancang untuk memudahkan proses ujian berbasis komputer.
    Ikutilah instruksi Guru untuk mengoperasikan aplikasi dengan benar.
  </div>
  <div class="hero-kelas">🏫 {{ $nama_kelas }}</div>
</div>

{{-- 4 NAV CARDS --}}
<div class="nav-cards">
  <a href="{{ url('/soal-siswa') }}" class="nav-card card-soal">
    <div class="nav-card-icon ic-blue">📋</div>
    <div class="nav-card-title">Soal Ujian</div>
    <div class="nav-card-desc">Mulai ujian sekarang</div>
  </a>
  <a href="{{ url('/latihan') }}" class="nav-card card-latihan">
    <div class="nav-card-icon ic-yellow">📖</div>
    <div class="nav-card-title">Latihan Materi</div>
    <div class="nav-card-desc">Persiapkan dirimu</div>
  </a>
  <a href="{{ url('/hasil-siswa') }}" class="nav-card card-hasil">
    <div class="nav-card-icon ic-green">📊</div>
    <div class="nav-card-title">Hasil Ujian</div>
    <div class="nav-card-desc">Lihat nilai kamu</div>
  </a>
  <a href="{{ url('/profil-siswa') }}" class="nav-card card-profil">
    <div class="nav-card-icon ic-purple">👤</div>
    <div class="nav-card-title">Profil Saya</div>
    <div class="nav-card-desc">Kelola akun kamu</div>
  </a>
</div>

{{-- INFO BOX --}}
<div class="info-box">
  <span style="font-size:20px">ℹ️</span>
  <span>Pastikan koneksi internet stabil sebelum memulai ujian. Jangan menutup atau merefresh halaman saat ujian berlangsung.</span>
</div>

@endsection
