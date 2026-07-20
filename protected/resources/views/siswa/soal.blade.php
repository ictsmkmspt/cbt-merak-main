@extends('layouts/siswa_baru')
@section('title', 'Soal Ujian')
@section('breadcrumb')
  <li><a href="{{ url('/siswa') }}">Home</a></li>
  <li class="active">Soal Ujian</li>
@endsection
@section('content')
<?php include(app_path().'/functions/koneksi.php'); ?>
<style>
.ujian-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 18px;
}
.ujian-card {
  background: #fff;
  border-radius: 18px;
  border: 1px solid #e5e7eb;
  box-shadow: 0 2px 14px rgba(30,58,138,.06);
  overflow: hidden;
  transition: all .22s ease;
  border-bottom: 3px solid #1d4ed8;
}
.ujian-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 28px rgba(30,58,138,.13);
}
.ujian-card-body { padding: 22px 22px 18px; }
.ujian-icon {
  width: 46px; height: 46px;
  background: #dbeafe;
  border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  font-size: 22px;
  margin-bottom: 14px;
}
.ujian-title {
  font-size: 15px; font-weight: 700; color: #1e3a8a;
  margin-bottom: 6px;
}
.ujian-title a { color: #1e3a8a; text-decoration: none; }
.ujian-title a:hover { color: #1d4ed8; }
.ujian-desc {
  font-size: 12.5px; color: #94a3b8; line-height: 1.6;
  margin-bottom: 14px;
  min-height: 20px;
}
.ujian-meta {
  display: flex; gap: 10px; flex-wrap: wrap;
  margin-bottom: 16px;
}
.ujian-chip {
  font-size: 11px; font-weight: 600; color: #475569;
  background: #f1f5f9; border-radius: 20px;
  padding: 4px 12px;
  display: inline-flex; align-items: center; gap: 4px;
}
.ujian-btn {
  display: inline-block; width: 100%; text-align: center;
  background: #1d4ed8; color: #fff !important;
  font-size: 13px; font-weight: 700;
  border-radius: 10px; padding: 10px 0;
  text-decoration: none !important;
  transition: background .2s ease;
}
.ujian-btn:hover { background: #1e40af; }

@media (max-width: 768px) {
  .ujian-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
  .ujian-card-body { padding: 12px 12px 10px; }
  .ujian-icon { width: 34px; height: 34px; font-size: 16px; margin-bottom: 8px; border-radius: 9px; }
  .ujian-title { font-size: 12px; margin-bottom: 4px; }
  .ujian-desc { font-size: 10.5px; margin-bottom: 8px; min-height: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
  .ujian-meta { gap: 5px; margin-bottom: 10px; }
  .ujian-chip { font-size: 9.5px; padding: 3px 8px; }
  .ujian-btn { font-size: 10.5px; padding: 7px 0; border-radius: 8px; }
}
</style>

@if(session('info_soal_kosong'))
<div class="alert alert-warning" style="grid-column: 1 / -1; margin-bottom: 14px;">
  <i class="fa fa-exclamation-triangle"></i> {{ session('info_soal_kosong') }}
</div>
@endif

<div class="ujian-grid">
  @if($distribusisoal->count())
  <?php $adaSoal = false; ?>
  @foreach($distribusisoal as $data_soal)
  <?php
    $id_user = Auth::user()->id;
    $cek_jawab = $conn->query("SELECT * FROM jawabs WHERE id_soal='$data_soal->id_soal' AND id_user='$id_user' AND status='Y'")->num_rows;
    if ($cek_jawab == 0) {
      $adaSoal = true;
  ?>
  <div class="ujian-card">
    <div class="ujian-card-body">
      <div class="ujian-icon">📋</div>
      <?php $url_mulai = $data_soal->token_ujian ? url('/verifikasi-token/'.$data_soal->id_soal) : url('/soal-siswa/'.$data_soal->id_soal); ?>
      <div class="ujian-title"><a href="{{ $url_mulai }}">{{ $data_soal->paket }}</a></div>
      <div class="ujian-desc">{{ $data_soal->deskripsi ?: 'Tidak ada deskripsi.' }}</div>
      <div class="ujian-meta">
        @if($data_soal->waktu)
        <span class="ujian-chip">⏱ {{ round($data_soal->waktu/60) }} menit</span>
        @endif
        @if($data_soal->kkm)
        <span class="ujian-chip">🎯 KKM {{ $data_soal->kkm }}</span>
        @endif
        @if($data_soal->token_ujian)
        <span class="ujian-chip">🔒 Perlu token</span>
        @endif
      </div>
      <a href="{{ $url_mulai }}" class="ujian-btn">
        @if($data_soal->token_ujian) 🔒 Masukkan Token @else Mulai Ujian @endif
      </a>
    </div>
  </div>
  <?php } ?>
  @endforeach
  @if(!$adaSoal)
  <div class="alert alert-info" style="grid-column: 1 / -1;">
    <i class="fa fa-info-circle" aria-hidden="true"></i> Semua ujian sudah kamu kerjakan.
  </div>
  @endif
  @else
  <div class="alert alert-info" style="grid-column: 1 / -1;">
    <i class="fa fa-info-circle" aria-hidden="true"></i> Belum ada paket soal untuk dikerjakan.
  </div>
  @endif
</div>
@endsection
