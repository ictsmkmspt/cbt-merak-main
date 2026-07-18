@extends('layouts/guru_baru')
@section('title', 'Dashboard Guru')
@section('content')
<?php
  include(app_path().'/functions/koneksi.php');
  $sapaan = Auth::user()->jk == "L" ? "Pak" : "Ibu";
?>
<style>
/* HERO */
.dash-hero {
  background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 60%, #60a5fa 100%);
  border-radius: 20px;
  padding: 32px 28px;
  color: #fff;
  margin-bottom: 20px;
  position: relative;
  overflow: hidden;
  box-shadow: 0 8px 32px rgba(29,78,216,.25);
}
.dash-hero::before {
  content:'';position:absolute;top:-60px;right:-60px;
  width:220px;height:220px;background:rgba(255,255,255,.07);border-radius:50%;
}
.dash-hero::after {
  content:'';position:absolute;bottom:-40px;right:120px;
  width:130px;height:130px;background:rgba(255,255,255,.05);border-radius:50%;
}
.dash-hero-badge {
  display:inline-flex;align-items:center;gap:5px;
  background:rgba(255,255,255,.18);border:1px solid rgba(255,255,255,.3);
  border-radius:20px;padding:4px 13px;
  font-size:10.5px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;margin-bottom:12px;
}
.dash-hero-greeting { font-size:12.5px;color:rgba(255,255,255,.82);margin-bottom:3px; }
.dash-hero-name { font-size:24px;font-weight:800;margin-bottom:8px;line-height:1.2; }
.dash-hero-desc { font-size:12.5px;color:rgba(255,255,255,.78);line-height:1.7;max-width:480px; }
.dash-hero-school {
  display:inline-flex;align-items:center;gap:5px;
  background:rgba(255,255,255,.15);border-radius:8px;
  padding:5px 12px;font-size:11.5px;font-weight:600;margin-top:12px;
}

/* STAT CARDS */
.stat-cards {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 14px;
  margin-bottom: 20px;
}
@media (max-width: 767px) {
  .stat-cards {
    grid-template-columns: 1fr 1fr;
  }
  .stat-icon { width: 44px; height: 44px; font-size: 20px; }
  .stat-info-value { font-size: 22px; }
  .stat-card { padding: 16px 14px; gap: 10px; }
}
.stat-card {
  background: #fff;
  border-radius: 16px;
  padding: 22px 20px;
  display: flex;
  align-items: center;
  gap: 16px;
  border: 1px solid #e5e7eb;
  box-shadow: 0 2px 14px rgba(30,58,138,.06);
  text-decoration: none;
  transition: all .2s ease;
}
.stat-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 24px rgba(30,58,138,.12);
  text-decoration: none;
}
.stat-icon {
  width: 54px; height: 54px;
  border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
  font-size: 26px; flex-shrink: 0;
}
.ic-blue   { background: #dbeafe; }
.ic-yellow { background: #fef3c7; }
.ic-green  { background: #d1fae5; }
.ic-purple { background: #ede9fe; }
.stat-info-label { font-size: 11.5px; color: #94a3b8; font-weight: 500; margin-bottom: 3px; }
.stat-info-value { font-size: 28px; font-weight: 800; color: #1e3a8a; line-height: 1; }
.stat-info-sub { font-size: 11px; color: #94a3b8; margin-top: 3px; }
.stat-card-materi  { border-bottom: 3px solid #1d4ed8; }
.stat-card-soal    { border-bottom: 3px solid #d97706; }
.stat-card-laporan { border-bottom: 3px solid #059669; }
.stat-card-profil  { border-bottom: 3px solid #7c3aed; }

/* PANEL kanan */
.dash-right-panel { padding-left: 8px; }
</style>

{{-- KIRI --}}
<div class="col-sm-12 col-md-8 col-lg-8 dash-left">
  <ol class="breadcrumb">
    <li><a href="{{ url('/guru') }}">Home</a></li>
    <li class="active">Dashboard</li>
  </ol>

  {{-- HERO --}}
  <div class="dash-hero">
    <div class="dash-hero-badge">⭐ Selamat Datang</div>
    <div class="dash-hero-greeting">Assalamu'alaikum, {{ $sapaan }}</div>
    <div class="dash-hero-name">{{ Auth::user()->nama }}</div>
    <div class="dash-hero-desc">
      Setiap aktivitas Anda akan selalu tercatat oleh sistem.
      Kelola seluruh menu yang tersedia untuk mendukung proses pembelajaran.
    </div>
    <div class="dash-hero-school">🏫 {{ $school->nama }}</div>
  </div>

{{-- STAT CARDS --}}
  <div class="stat-cards">
    <a href="{{ url('/materi') }}" class="stat-card stat-card-materi">
      <div class="stat-icon ic-blue">📚</div>
      <div>
        <div class="stat-info-label">Total Materi</div>
        <div class="stat-info-value">{{ $jumlah_materi }}</div>
        <div class="stat-info-sub">Materi diunggah</div>
      </div>
    </a>
    <a href="{{ url('/soal-guru') }}" class="stat-card stat-card-soal">
      <div class="stat-icon ic-yellow">📝</div>
      <div>
        <div class="stat-info-label">Total Soal</div>
        <div class="stat-info-value">{{ $jumlah_soal }}</div>
        <div class="stat-info-sub">Paket soal</div>
      </div>
    </a>
    <a href="{{ url('/hasil-guru') }}" class="stat-card stat-card-laporan">
      <div class="stat-icon ic-green">📊</div>
      <div>
        <div class="stat-info-label">Total Laporan</div>
        <div class="stat-info-value">{{ $jumlah_laporan }}</div>
        <div class="stat-info-sub">Paket dinilai</div>
      </div>
    </a>
    <a href="{{ url('/profil-guru') }}" class="stat-card stat-card-profil">
      <div class="stat-icon ic-purple">👤</div>
      <div>
        <div class="stat-info-label"></div>
        <div class="stat-info-value" style="font-size:15px;line-height:1.3">Profil</div>
        <div class="stat-info-sub">Akun saya</div>
      </div>
    </a>
  </div>

  {{-- PROFIL GURU --}}
  <div class="panel panel-default">
    <div class="panel-heading">Profil Saya</div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-3 col-md-3" style="text-align:center">
          <?php if ($user->gambar == "") { ?>
            <img src="{{ url('img/noimage.jpg') }}" alt="foto" class="img-circle img-responsive" style="width:80px;height:80px;object-fit:cover;margin:0 auto;border:3px solid #e5e7eb">
          <?php } else { ?>
            <img src="{{ url('img/'.$user->gambar) }}" alt="{{ $user->nama }}" class="img-circle img-responsive" style="width:80px;height:80px;object-fit:cover;margin:0 auto;border:3px solid #e5e7eb">
          <?php } ?>
        </div>
        <div class="col-sm-9 col-md-9">
          <h4 style="color:#1e3a8a;font-weight:700;margin-bottom:4px">{{ $user->nama }}</h4>
          <p style="color:#94a3b8;font-size:12px;margin-bottom:12px">{{ $user->job ?? ($user->status == 'A' ? 'Administrator' : 'Guru') }}</p>
          <p style="font-size:13px;color:#475569;margin-bottom:5px">📧 {{ $user->email }}</p>
          <p style="font-size:13px;color:#475569;margin-bottom:5px">🪪 {{ $user->no_induk ?: '-' }}</p>
          <p style="font-size:13px;color:#475569">👤 {{ $user->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
        </div>
      </div>
    </div>
  </div>

</div>

{{-- KANAN --}}
<div class="col-sm-12 col-md-4 col-lg-4 dash-right">

  {{-- BYPASS --}}
  <div class="panel panel-default" style="border-left:4px solid #dc2626">
    <div class="panel-heading" style="background:#fff;color:#dc2626;font-weight:700;border-bottom:1px solid #fee2e2">
      🔒 Konfigurasi Bypass Ujian
    </div>
    <div class="panel-body">
      <p style="font-size:13px;color:#475569;margin-bottom:14px">
        Status saat ini:
        @if($school->bypass_ujian == 0)
          <strong style="color:#059669">✅ Ujian diperbolehkan</strong>
        @else
          <strong style="color:#dc2626">🚫 Ujian disuspend</strong>
        @endif
      </p>
      <button onclick="window.location='{{ url('bebasadmin-toggle') }}'"
        class="btn btn-danger btn-block" style="border-radius:9px;font-weight:700">
        🔄 Ubah Status Bypass
      </button>
    </div>
  </div>

  {{-- AKTIFITAS --}}
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">⚡ Aktifitas Terkini</h4>
    </div>
    <div class="panel-body">
      <ul class="media-list user-list">
        @if($aktifitas->count())
        @foreach($aktifitas as $data)
        <?php
          $tgl = explode(" ", $data->created_at);
          $tgl = explode("-", $tgl[0]);
          $tgl = $tgl[2].' '.$bulanpendek[$tgl[1]].' '.$tgl[0];
          $gbr = $data->gambar != "" ? $data->gambar : 'noimage.jpg';
        ?>
        <li class="media">
          <div class="media-left">
            <a href="#">
              <img class="media-object img-thumbnail" src="{{ url('img/'.$gbr) }}" alt="">
            </a>
          </div>
          <div class="media-body">
            <h4 class="media-heading nomargin"><a href="#">{{ $data->nama_user }}</a></h4>
            {{ $data->nama }}
            <small class="date"><i class="fa fa-clock-o"></i> {{ $tgl }}</small>
          </div>
        </li>
        @endforeach
        @endif
      </ul>
      <a href="{{ url('/aktifitas') }}" class="btn btn-success" style="display:block;width:100%;margin:10px 0 0 0">Selengkapnya</a>
    </div>
  </div>

</div>
@endsection
