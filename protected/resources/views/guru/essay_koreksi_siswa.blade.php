@extends('layouts/guru_baru')
@section('title', 'Koreksi Essay Siswa')
@section('content')
<script src="{{ url('/assets/assets/vendor/jquery.min.js') }}"></script>
<script src="{{ url('/lib/mathjax/2.7.2/MathJax.js?config=TeX-AMS_HTML') }}"></script>
<?php include(app_path().'/functions/koneksi.php'); ?>

<style>
.essay-card {
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 14px;
  padding: 24px;
  margin-bottom: 20px;
  box-shadow: 0 2px 10px rgba(30,58,138,.06);
}
.essay-card-head {
  display: flex; justify-content: space-between; align-items: center;
  margin-bottom: 16px; padding-bottom: 12px;
  border-bottom: 1px solid #f0f3f8;
}
.essay-no {
  font-size: 13px; font-weight: 700; color: #1e3a8a;
}
.essay-bobot-badge {
  background: #fef3c7; color: #d97706;
  border-radius: 6px; padding: 4px 12px;
  font-size: 12px; font-weight: 700;
}
.essay-soal {
  background: #f8fafc; border-radius: 8px;
  padding: 14px 16px; margin-bottom: 16px;
  font-size: 13.5px; color: #334155; line-height: 1.7;
  border-left: 4px solid #3b82f6;
}
.essay-jawaban {
  background: #fff; border: 1.5px solid #e2e8f0;
  border-radius: 8px; padding: 14px 16px;
  font-size: 13.5px; color: #1e293b; line-height: 1.8;
  min-height: 80px; margin-bottom: 16px;
  white-space: pre-wrap;
}
.essay-jawaban.kosong {
  color: #94a3b8; font-style: italic;
}
.nilai-wrap {
  display: flex; align-items: center; gap: 12px;
  background: #f0f9ff; border-radius: 10px;
  padding: 14px 16px;
}
.nilai-label { font-size: 13px; font-weight: 600; color: #475569; white-space: nowrap; }
.nilai-input {
  width: 90px; padding: 8px 12px;
  border: 1.5px solid #e2e8f0; border-radius: 8px;
  font-size: 15px; font-weight: 700; text-align: center;
  color: #1e3a8a; outline: none; transition: border .2s;
}
.nilai-input:focus { border-color: #3b82f6; }
.nilai-max { font-size: 13px; color: #94a3b8; }
.btn-simpan-nilai {
  padding: 8px 20px; border-radius: 9px; border: none;
  background: #1d4ed8; color: #fff;
  font-size: 13px; font-weight: 700; cursor: pointer;
  transition: all .2s;
}
.btn-simpan-nilai:hover { background: #163d80; transform: translateY(-1px); }
.btn-simpan-nilai.saved { background: #059669; }
.status-koreksi {
  font-size: 11.5px; margin-left: 8px;
}
.total-nilai-box {
  background: linear-gradient(135deg, #1d4ed8, #3b82f6);
  color: #fff; border-radius: 14px; padding: 20px 24px;
  margin-bottom: 20px; display: flex;
  align-items: center; justify-content: space-between;
}
.total-nilai-box h4 { margin: 0; font-size: 15px; opacity: .85; }
.total-nilai-box .nilai-total { font-size: 32px; font-weight: 800; }
</style>

<div class="col-md-12 dash-left">
  <ol class="breadcrumb">
    <li><a href="{{ url('/guru') }}">Home</a></li>
    <li><a href="{{ url('/essay') }}">Koreksi Essay</a></li>
    <li><a href="{{ url('/essay/koreksi/'.$soal->id) }}">{{ $soal->paket }}</a></li>
    <li class="active">{{ $siswa->nama }}</li>
  </ol>

  {{-- INFO SISWA --}}
  <div class="total-nilai-box">
    <div>
      <h4>Siswa: <b>{{ $siswa->nama }}</b></h4>
      <div style="font-size:13px;opacity:.8;margin-top:4px">
        Paket: {{ $soal->paket }} &nbsp;|&nbsp;
        {{ $jawabans->count() }} soal essay
      </div>
    </div>
    <div style="text-align:right">
      <div style="font-size:13px;opacity:.8">Total Nilai Essay</div>
      <div class="nilai-total" id="total-nilai-display">
        {{ $jawabans->sum('nilai_essay') }}
      </div>
    </div>
  </div>

  <div id="notif-global" style="display:none;margin-bottom:15px"></div>

  {{-- DAFTAR SOAL ESSAY --}}
  @if($jawabans->count())
  <?php $no = 1; ?>
  @foreach($jawabans as $j)
  <div class="essay-card" id="card-{{ $j->jawab_id }}">
    <div class="essay-card-head">
      <span class="essay-no">Soal Essay #{{ $no++ }}</span>
      <span class="essay-bobot-badge">Bobot: {{ $j->bobot }} poin</span>
    </div>

    {{-- SOAL --}}
    <div class="essay-soal formula">{!! $j->soal !!}</div>

    {{-- JAWABAN SISWA --}}
    <div style="font-size:12px;font-weight:600;color:#94a3b8;margin-bottom:6px">
      💬 Jawaban Siswa:
    </div>
    @if($j->jawaban_essay)
      <div class="essay-jawaban">{{ $j->jawaban_essay }}</div>
    @else
      <div class="essay-jawaban kosong">— Siswa tidak memberikan jawaban —</div>
    @endif

    {{-- INPUT NILAI --}}
    <div class="nilai-wrap">
      <span class="nilai-label">Nilai:</span>
      <input
        type="number"
        class="nilai-input"
        id="nilai-{{ $j->jawab_id }}"
        value="{{ $j->nilai_essay ?? '' }}"
        min="0"
        max="{{ $j->bobot }}"
        placeholder="0"
      >
      <span class="nilai-max">/ {{ $j->bobot }}</span>
      <button
        class="btn-simpan-nilai {{ $j->status_koreksi == 'sudah' ? 'saved' : '' }}"
        id="btn-{{ $j->jawab_id }}"
        onclick="simpanNilai({{ $j->jawab_id }}, {{ $j->bobot }})"
      >
        {{ $j->status_koreksi == 'sudah' ? '✅ Tersimpan' : '💾 Simpan Nilai' }}
      </button>
      <span class="status-koreksi" id="status-{{ $j->jawab_id }}">
        @if($j->status_koreksi == 'sudah')
          <span style="color:#059669">✅ Sudah dikoreksi</span>
        @else
          <span style="color:#f59e0b">⏳ Belum dikoreksi</span>
        @endif
      </span>
    </div>
  </div>
  @endforeach

  {{-- TOMBOL SELESAI --}}
  <div style="margin-bottom:30px;display:flex;gap:12px">
    <button class="btn btn-success" onclick="selesaiKoreksi()">
      <i class="fa fa-check"></i> Selesai & Kembali ke Daftar Siswa
    </button>
    <a href="{{ url('/essay/koreksi/'.$soal->id) }}" class="btn btn-default">
      <i class="fa fa-arrow-left"></i> Kembali
    </a>
  </div>

  @else
  <div class="alert alert-warning">
    <i class="fa fa-exclamation-triangle"></i>
    Tidak ada jawaban essay dari siswa ini.
  </div>
  @endif

</div>

<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

// Render MathJax untuk soal dengan formula
MathJax.Hub.Queue(["Typeset", MathJax.Hub, document.getElementsByClassName("formula")]);

var totalNilai = {{ $jawabans->sum('nilai_essay') ?? 0 }};

function simpanNilai(id_jawab, bobot) {
  var nilai = parseInt($("#nilai-"+id_jawab).val());
  if (isNaN(nilai) || nilai < 0) {
    alert("Nilai tidak boleh kosong atau negatif."); return;
  }
  if (nilai > bobot) {
    alert("Nilai tidak boleh melebihi bobot ("+bobot+")."); return;
  }

  var nilaiLama = parseInt($("#btn-"+id_jawab).data('nilai-lama')) || 0;

  $.post('{{ url("/essay/simpan-nilai") }}', {
    id_jawab: id_jawab,
    nilai: nilai,
    bobot: bobot
  }, function(res){
    if (res.startsWith('ok')) {
      // Update tombol
      $("#btn-"+id_jawab)
        .addClass('saved')
        .text('✅ Tersimpan')
        .data('nilai-lama', nilai);
      // Update status
      $("#status-"+id_jawab).html('<span style="color:#059669">✅ Sudah dikoreksi</span>');
      // Update total nilai
      totalNilai = totalNilai - nilaiLama + nilai;
      $("#total-nilai-display").text(totalNilai);

      // Notif
      $("#notif-global")
        .removeClass('alert-danger')
        .addClass('alert alert-success')
        .html('<i class="fa fa-check"></i> Nilai berhasil disimpan.')
        .show();
      setTimeout(function(){ $("#notif-global").fadeOut(); }, 2000);
    } else {
      alert("Gagal: " + res);
    }
  });
}

function selesaiKoreksi() {
  $.post('{{ url("/essay/selesai") }}', {
    id_soal: {{ $soal->id }},
    id_user: {{ $siswa->id }}
  }, function(res){
    if (res === 'ok') {
      window.location.href = '{{ url("/essay/koreksi/".$soal->id) }}';
    }
  });
}
</script>
@endsection
