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
<style>
.cbt-main { padding: 80px 20px 40px; }
.lobby-wrap {
  background: rgba(255,255,255,.85);
  backdrop-filter: blur(24px);
  border: 1px solid rgba(255,255,255,.9);
  border-radius: 28px;
  padding: 44px 40px;
  width: 100%;
  max-width: 460px;
  box-shadow: 0 4px 6px rgba(99,102,241,.04), 0 20px 60px rgba(99,102,241,.1);
  text-align: center;
}
.lobby-logo-wrap { margin-bottom: 22px; }
.lobby-logo {
  width: 80px; height: 80px;
  border-radius: 50%; object-fit: cover;
  border: 3px solid #fff;
  box-shadow: 0 4px 20px rgba(99,102,241,.2);
}
.lobby-logo-fb {
  width: 80px; height: 80px; border-radius: 50%;
  background: linear-gradient(135deg,#dbeafe,#e0e7ff);
  border: 3px solid #fff; display: flex;
  align-items: center; justify-content: center;
  margin: 0 auto;
  box-shadow: 0 4px 20px rgba(99,102,241,.2);
}
.lobby-logo-fb i { font-size: 34px; color: #3b82f6; }
.lobby-school { font-size: 17px; font-weight: 800; color: #1e3a8a; margin-bottom: 4px; }
.lobby-subtitle { font-size: 12px; color: #94a3b8; margin-bottom: 28px; }
.lobby-divider { display:flex;align-items:center;gap:10px;margin-bottom:22px; }
.lobby-divider-line { flex:1;height:1px;background:linear-gradient(90deg,transparent,#e2e8f0,transparent); }
.lobby-divider-text { font-size:10px;color:#cbd5e1;font-weight:500;letter-spacing:1px;text-transform:uppercase; }
.lobby-cards { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px; }
.lobby-card {
  display: flex; flex-direction: column; align-items: center; gap: 6px;
  padding: 22px 16px; border-radius: 16px; border: none; cursor: pointer;
  text-decoration: none; font-family: 'Inter',sans-serif;
  transition: all .25s cubic-bezier(.4,0,.2,1);
}
.lobby-card:hover { transform: translateY(-3px); text-decoration: none; }
.lobby-card:active { transform: translateY(-1px); }
.lobby-card-ujian {
  background: linear-gradient(135deg,#1d4ed8,#3b82f6);
  box-shadow: 0 4px 15px rgba(59,130,246,.3); color: #fff;
}
.lobby-card-ujian:hover { box-shadow: 0 8px 25px rgba(59,130,246,.45); color: #fff; }
.lobby-card-latihan {
  background: linear-gradient(135deg,#d97706,#f59e0b);
  box-shadow: 0 4px 15px rgba(245,158,11,.3); color: #fff;
}
.lobby-card-latihan:hover { box-shadow: 0 8px 25px rgba(245,158,11,.45); color: #fff; }
.lobby-card-icon {
  width: 44px; height: 44px; border-radius: 12px;
  background: rgba(255,255,255,.2);
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 2px;
}
.lobby-card-label { font-size: 12px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
.lobby-card-desc { font-size: 10px; opacity: .8; font-weight: 400; }
.lobby-info {
  display: flex; align-items: center; justify-content: center; gap: 6px;
  background: linear-gradient(135deg,#eff6ff,#fefce8);
  border: 1px solid #e0e7ff; border-radius: 10px;
  padding: 9px 14px; font-size: 11px; color: #475569; margin-bottom: 16px;
}
.lobby-info i { font-size: 14px; color: #3b82f6; }
.lobby-back { display:block;text-align:center;font-size:12px;color:#94a3b8;text-decoration:none;transition:color .2s; }
.lobby-back:hover { color: #3b82f6; }
@media(max-width:480px){
  .lobby-cards { grid-template-columns: 1fr; }
  .lobby-wrap { padding: 36px 22px; }
}
</style>

<div class="cbt-main">
  <div class="lobby-wrap">

    {{-- LOGO --}}
    <div class="lobby-logo-wrap">
      @if($logosekolah)
        <img src="{{ url('img/'.$logosekolah) }}" alt="{{ $namasekolah }}" class="lobby-logo">
      @else
        <div class="lobby-logo-fb"><i class="material-icons">school</i></div>
      @endif
    </div>

    <div class="lobby-school">{{ $namasekolah ?: 'CBT Sekolah' }}</div>
    <div class="lobby-subtitle">Login Siswa — Pilih mode yang sesuai</div>

    <div class="lobby-divider">
      <div class="lobby-divider-line"></div>
      <div class="lobby-divider-text">Masuk sebagai siswa</div>
      <div class="lobby-divider-line"></div>
    </div>

    <div class="lobby-cards">
      <a href="{{ url('/siswa') }}" class="lobby-card lobby-card-ujian">
        <div class="lobby-card-icon">
          <i class="material-icons" style="font-size:22px">assignment</i>
        </div>
        <span class="lobby-card-label">Ujian</span>
        <span class="lobby-card-desc">Kerjakan soal ujian</span>
      </a>
      <a href="{{ url('/latihan') }}" class="lobby-card lobby-card-latihan">
        <div class="lobby-card-icon">
          <i class="material-icons" style="font-size:22px">menu_book</i>
        </div>
        <span class="lobby-card-label">Latihan</span>
        <span class="lobby-card-desc">Belajar & berlatih</span>
      </a>
    </div>

    <div class="lobby-info">
      <i class="material-icons">info_outline</i>
      Gunakan akun yang diberikan oleh guru / administrator
    </div>

    <a href="{{ url('/') }}" class="lobby-back">← Kembali ke Beranda</a>
  </div>
</div>
@endsection
