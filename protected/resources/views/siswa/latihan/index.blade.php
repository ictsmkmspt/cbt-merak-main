@extends('layouts/siswa_baru')
@section('title', 'Latihan')
@section('breadcrumb')
  <li><a href="{{ url('/siswa') }}">Home</a></li>
  <li class="active">Latihan</li>
@endsection
@section('content')
<style>
.latihan-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 18px;
}
.latihan-card {
  background: #fff;
  border-radius: 18px;
  border: 1px solid #e5e7eb;
  box-shadow: 0 2px 14px rgba(30,58,138,.06);
  overflow: hidden;
  transition: all .22s ease;
  border-bottom: 3px solid #1d4ed8;
  display: flex; flex-direction: column;
}
.latihan-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 28px rgba(30,58,138,.13);
}
.latihan-thumb {
  height: 140px; overflow: hidden;
  background: #dbeafe;
  display: flex; align-items: center; justify-content: center;
}
.latihan-thumb img { width: 100%; height: 100%; object-fit: cover; }
.latihan-thumb-placeholder { font-size: 40px; }
.latihan-body { padding: 20px 20px 18px; flex: 1; display: flex; flex-direction: column; }
.latihan-title {
  font-size: 15px; font-weight: 700; color: #1e3a8a;
  margin-bottom: 8px;
}
.latihan-title a { color: #1e3a8a; text-decoration: none; }
.latihan-title a:hover { color: #1d4ed8; }
.latihan-excerpt {
  font-size: 12.5px; color: #94a3b8; line-height: 1.6;
  flex: 1; margin-bottom: 14px;
  display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
}
.latihan-btn {
  display: inline-block; text-align: center;
  background: #dbeafe; color: #1e3a8a !important;
  font-size: 12.5px; font-weight: 700;
  border-radius: 10px; padding: 9px 0;
  text-decoration: none !important;
  transition: background .2s ease;
}
.latihan-btn:hover { background: #bfdbfe; }

@media (max-width: 768px) {
  .latihan-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
  .latihan-thumb { height: 85px; }
  .latihan-thumb-placeholder { font-size: 26px; }
  .latihan-body { padding: 12px 12px 10px; }
  .latihan-title { font-size: 12px; margin-bottom: 5px; }
  .latihan-excerpt { font-size: 10.5px; margin-bottom: 10px; -webkit-line-clamp: 2; }
  .latihan-btn { font-size: 10.5px; padding: 7px 0; }
}
</style>

@if(session('info_soal_kosong'))
<div class="alert alert-warning" style="margin-bottom: 14px;">
  <i class="fa fa-exclamation-triangle"></i> {{ session('info_soal_kosong') }}
</div>
@endif

@if($latihanBelumDikerjakan->count())
<style>
.todo-panel {
  background: #fff; border-radius: 18px; border: 1px solid #e5e7eb;
  box-shadow: 0 2px 14px rgba(30,58,138,.06);
  padding: 20px 22px; margin-bottom: 22px;
}
.todo-title { font-size: 14px; font-weight: 700; color: #1e3a8a; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; }
.todo-count { background: #dbeafe; color: #1e3a8a; font-size: 11px; font-weight: 700; border-radius: 20px; padding: 2px 10px; }
.todo-item {
  display: flex; align-items: center; justify-content: space-between;
  padding: 10px 0; border-bottom: 1px solid #f1f5f9;
}
.todo-item:last-child { border-bottom: none; }
.todo-item-name { font-size: 13px; font-weight: 600; color: #1e3a8a; }
.todo-item-name a { color: #1e3a8a; text-decoration: none; }
.todo-item-name a:hover { color: #1d4ed8; }
.todo-btn {
  background: #dbeafe; color: #1e3a8a !important; font-size: 11.5px; font-weight: 700;
  border-radius: 8px; padding: 6px 14px; text-decoration: none !important; white-space: nowrap;
}
.todo-btn:hover { background: #bfdbfe; }
</style>
<div class="todo-panel">
  <div class="todo-title">📝 Latihan belum dikerjakan <span class="todo-count">{{ $latihanBelumDikerjakan->count() }}</span></div>
  @foreach($latihanBelumDikerjakan as $lat)
    <div class="todo-item">
      <div class="todo-item-name"><a href="{{ url('/soal-siswa/'.$lat->id) }}">{{ $lat->paket }}</a></div>
      <a href="{{ url('/soal-siswa/'.$lat->id) }}" class="todo-btn">Kerjakan</a>
    </div>
  @endforeach
</div>
@endif

<div class="latihan-grid">
  @if($materis->count())
  @foreach($materis as $materi)
  <div class="latihan-card">
    <?php if ($materi->gambar != "") { ?>
      <div class="latihan-thumb">
        <img src="{{ url('/img/materi/'.$materi->gambar) }}" alt="img">
      </div>
    <?php } else { ?>
      <div class="latihan-thumb"><span class="latihan-thumb-placeholder">📖</span></div>
    <?php } ?>
    <div class="latihan-body">
      <div class="latihan-title"><a href="{{ url('/latihan/read/'.$materi->id.'/'.str_slug($materi->judul)) }}">{{ $materi->judul }}</a></div>
      <div class="latihan-excerpt">
        <?php
          $isi = strip_tags($materi->isi);
          echo \Illuminate\Support\Str::limit($isi, 110);
        ?>
      </div>
      <a href="{{ url('/latihan/read/'.$materi->id.'/'.str_slug($materi->judul)) }}" class="latihan-btn">Baca Materi &amp; Latihan →</a>
    </div>
  </div>
  @endforeach
  @else
  <div class="alert alert-info" style="grid-column: 1 / -1;">
    <i class="fa fa-info-circle"></i> Belum ada materi latihan tersedia.
  </div>
  @endif
</div>
@endsection
