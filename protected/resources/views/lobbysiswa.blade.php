@extends('layouts/lobby')
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
<style>
.lobby-page {
  min-height: 100vh;
  background: #f7f9fc;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 40px 16px;
}
.lobby-wrap { width: 100%; max-width: 560px; text-align: center; }
.lobby-logo {
  width: 80px; height: 80px;
  border-radius: 20px;
  background: #fff;
  box-shadow: 0 6px 24px rgba(26,79,160,.12);
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 20px;
  font-size: 38px;
}
.lobby-title { font-size: 22px; font-weight: 700; color: #0f2a5e; margin-bottom: 6px; }
.lobby-sub { font-size: 13px; color: #9aaabf; margin-bottom: 40px; }
.lobby-cards {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
  margin-bottom: 28px;
}
.lobby-card {
  background: #fff;
  border-radius: 16px;
  padding: 32px 20px;
  border: 1.5px solid #edf1f7;
  box-shadow: 0 4px 16px rgba(26,79,160,.07);
  text-decoration: none;
  transition: all .2s;
  display: block;
}
.lobby-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 28px rgba(26,79,160,.13);
  border-color: #b5d0f5;
  text-decoration: none;
}
.lobby-card-icon {
  width: 56px; height: 56px;
  border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 16px;
  font-size: 26px;
}
.ic-blue { background: #eef4ff; }
.ic-yellow { background: #fffbe6; }
.lobby-card h3 { font-size: 16px; font-weight: 700; color: #0f2a5e; margin-bottom: 6px; }
.lobby-card p { font-size: 12px; color: #9aaabf; margin: 0 0 18px; line-height: 1.6; }
.lobby-btn {
  display: inline-block;
  padding: 9px 24px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 600;
  border: none;
  cursor: pointer;
}
.btn-blue-solid { background: #1a4fa0; color: #fff; }
.btn-yellow-solid { background: #f5c518; color: #1a2a40; }
.lobby-back {
  display: inline-flex; align-items: center; gap: 6px;
  font-size: 13px; color: #9aaabf; text-decoration: none;
  transition: color .2s;
}
.lobby-back:hover { color: #1a4fa0; text-decoration: none; }
@media(max-width:480px){
  .lobby-cards { grid-template-columns: 1fr; }
}
</style>

<div class="lobby-page">
  <div class="lobby-wrap">
    <div class="lobby-logo">
      @if($logosekolah)
        <img src="{{ url('img/'.$logosekolah) }}" style="width:58px;height:58px;object-fit:contain;border-radius:14px">
      @else
        <img src="{{ url('img/logo.png') }}" style="width:58px;height:58px;object-fit:contain;border-radius:14px"
             onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
        <span style="display:none;font-size:30px">🏫</span>
      @endif
    </div>
    <h1 class="lobby-title">{{ $namasekolah ?: 'CBT Sekolah' }}</h1>
    <p class="lobby-sub">Pilih mode yang sesuai untuk melanjutkan</p>

    <div class="lobby-cards">
      <a href="{{ route('siswa.index') }}" class="lobby-card">
        <div class="lobby-card-icon ic-blue">📝</div>
        <h3>Ujian</h3>
        <p>Masuk untuk mengerjakan soal ujian yang telah dijadwalkan</p>
        <span class="lobby-btn btn-blue-solid">Mulai Ujian</span>
      </a>
      <a href="{{ url('/latihan') }}" class="lobby-card">
        <div class="lobby-card-icon ic-yellow">📖</div>
        <h3>Latihan</h3>
        <p>Masuk untuk belajar dan berlatih mengerjakan soal materi</p>
        <span class="lobby-btn btn-yellow-solid">Mulai Latihan</span>
      </a>
    </div>

    <a href="{{ url('/') }}" class="lobby-back">← Kembali ke Beranda</a>
  </div>
</div>
@endsection
