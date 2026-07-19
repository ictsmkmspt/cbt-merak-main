@extends('layouts/siswa_baru')
@section('title', 'Latihan')
@section('breadcrumb')
  <li><a href="{{ url('/siswa') }}">Home</a></li>
  <li><a href="{{ url('/latihan') }}">Latihan</a></li>
  <li class="active">Detail: {{ $materi->judul }}</li>
@endsection
@section('content')
<style>
.materi-hero {
  background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 60%, #60a5fa 100%);
  border-radius: 20px;
  padding: 28px 30px;
  color: #fff;
  margin-bottom: 22px;
  box-shadow: 0 8px 32px rgba(29,78,216,.24);
}
.materi-hero-title { font-size: 22px; font-weight: 800; line-height: 1.3; }

.materi-panel {
  background: #fff; border-radius: 18px; border: 1px solid #e5e7eb;
  box-shadow: 0 2px 14px rgba(30,58,138,.06);
  overflow: hidden; margin-bottom: 20px;
}
.materi-panel-body { padding: 24px 26px; }
.materi-panel-body img { max-width: 100%; height: auto; border-radius: 10px; }

.guru-card { background: #fff; border-radius: 18px; border: 1px solid #e5e7eb; box-shadow: 0 2px 14px rgba(30,58,138,.06); padding: 20px; }
.guru-avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; }
.guru-name { font-size: 14px; font-weight: 700; color: #1e3a8a; }
.guru-role { font-size: 11.5px; color: #94a3b8; }

.hideGambar{ overflow:hidden; height:120px; border-radius: 10px; }
.showGambar{
  text-align: center; background: #dbeafe; color: #1e3a8a;
  padding: 12px 0; cursor: pointer; border-radius: 10px; font-size: 13px; font-weight: 600;
  margin-bottom: 14px;
}
.showGambar:hover{ background: #bfdbfe; }

.soallatihan-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; }
.soallatihan-card {
  background: #fff; border: 1px solid #e5e7eb; border-radius: 14px;
  padding: 16px 18px; transition: all .2s ease;
  border-bottom: 3px solid #1d4ed8;
}
.soallatihan-card.selesai { border-bottom-color: #059669; background: #f9fafb; }
.soallatihan-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,.07); }
.soallatihan-title { font-size: 14px; font-weight: 700; color: #1e3a8a; margin-bottom: 4px; }
.soallatihan-title a { color: #1e3a8a; text-decoration: none; }
.soallatihan-title a:hover { color: #1d4ed8; }
.soallatihan-title.done { color: #94a3b8; }
.soallatihan-desc { font-size: 12px; color: #94a3b8; margin-bottom: 10px; line-height: 1.5; }
.badge-selesai {
  display: inline-block; font-size: 10.5px; font-weight: 700;
  background: #d1fae5; color: #059669; border-radius: 20px;
  padding: 3px 10px; margin-bottom: 10px;
}
.btn-kerjakan, .btn-lihat-hasil {
  display: block; text-align: center; font-size: 12px; font-weight: 700;
  border-radius: 8px; padding: 8px 0; text-decoration: none !important;
}
.btn-kerjakan { background: #dbeafe; color: #1e3a8a !important; }
.btn-kerjakan:hover { background: #bfdbfe; }
.btn-lihat-hasil { background: #e5e7eb; color: #475569 !important; }
.btn-lihat-hasil:hover { background: #d1d5db; }

@media (max-width: 768px) {
  .materi-hero { padding: 20px 20px; }
  .materi-hero-title { font-size: 17px; }
  .materi-panel-body { padding: 16px 18px; }
  .soallatihan-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
  .soallatihan-card { padding: 10px 12px; }
  .soallatihan-title { font-size: 11.5px; }
  .soallatihan-desc { font-size: 10px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
}
</style>

<div class="materi-hero">
  <div class="materi-hero-title">{{ $materi->judul }}</div>
</div>

<div class="row">
  <div class="col-md-8">
    <div class="materi-panel">
      <div class="materi-panel-body">
        <?php if ($materi->gambar != "") { ?>
          <div class="hideGambar" id="wrap-gambar">
            <img src="{{ url('/img/materi/'.$materi->gambar) }}" alt="img" style="width:100%;">
          </div>
          <div class="showGambar">🖼 Tampilkan Gambar</div>
        <?php } ?>

        {!! $materi->isi !!}

        <?php if ($soals != "EM") { ?>
          <hr style="margin: 22px 0;">
          <h4 style="color:#1e3a8a; font-weight:700;">Soal-soal latihan</h4>
          <hr style="margin: 10px 0 16px;">
          @if($soals->count())
          <div class="soallatihan-grid">
          @foreach($soals as $soal)
            <?php $sudahSelesai = in_array($soal->id, $idSoalSelesai); ?>
            <div class="soallatihan-card {{ $sudahSelesai ? 'selesai' : '' }}">
              @if($sudahSelesai)
                <span class="badge-selesai">✓ Sudah Dikerjakan</span>
                <div class="soallatihan-title done">{{ $soal->paket }}</div>
              @else
                <div class="soallatihan-title"><a href="{{ url('/soal-siswa/'.$soal->id) }}">{{ $soal->paket }}</a></div>
              @endif
              <div class="soallatihan-desc">{{ $soal->deskripsi }}</div>
              @if($sudahSelesai)
                <a href="{{ url('/hasil-siswa/detail/'.$soal->id) }}" class="btn-lihat-hasil">Lihat Hasil</a>
              @else
                <a href="{{ url('/soal-siswa/'.$soal->id) }}" class="btn-kerjakan">Kerjakan</a>
              @endif
            </div>
          @endforeach
          </div>
          @else
            <div class="alert alert-info" style="margin-bottom: 0">Belum ada soal latihan.</div>
          @endif
        <?php } ?>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="guru-card">
      <div style="display:flex; align-items:center; gap:12px;">
        <?php if ($materi->gambar_user != "") { ?>
          <img src="{{ url('/img/'.$materi->gambar_user) }}" alt="img" class="guru-avatar">
        <?php } else { ?>
          <div class="guru-avatar" style="background:#dbeafe; display:flex; align-items:center; justify-content:center; font-size:20px;">👤</div>
        <?php } ?>
        <div>
          <div class="guru-name">{{ Auth::user()->nama }}</div>
          <div class="guru-role">
            <?php echo ($materi->jenis_user == 'A') ? 'Admin' : 'Guru'; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="{{ url('/assets/assets/vendor/jquery.min.js') }}"></script>
<script>
$(document).ready(function(){
  $(".showGambar").click(function(){
    $(this).hide();
    $("#wrap-gambar").removeClass('hideGambar').hide().fadeIn(350);
  });
});
</script>
@endsection
