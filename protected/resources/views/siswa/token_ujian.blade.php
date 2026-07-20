@extends('layouts/siswa_baru')
@section('title', 'Masukkan Token Ujian')
@section('breadcrumb')
  <li><a href="{{ url('/siswa') }}">Home</a></li>
  <li><a href="{{ url('/soal-siswa') }}">Soal Ujian</a></li>
  <li class="active">Masukkan Token</li>
@endsection
@section('content')
<style>
.token-wrap {
  max-width: 420px; margin: 20px auto;
  background: #fff; border-radius: 20px; border: 1px solid #e5e7eb;
  box-shadow: 0 8px 32px rgba(29,78,216,.10);
  padding: 32px 30px; text-align: center;
}
.token-icon {
  width: 56px; height: 56px; border-radius: 16px;
  background: #dbeafe; display: flex; align-items: center; justify-content: center;
  font-size: 26px; margin: 0 auto 16px;
}
.token-title { font-size: 17px; font-weight: 800; color: #1e3a8a; margin-bottom: 6px; }
.token-desc { font-size: 12.5px; color: #94a3b8; margin-bottom: 20px; line-height: 1.6; }
.token-input {
  width: 100%; text-align: center; letter-spacing: 6px;
  font-size: 22px; font-weight: 700; color: #1e3a8a;
  border: 2px solid #dbeafe; border-radius: 12px; padding: 12px 0;
  margin-bottom: 16px; text-transform: uppercase;
}
.token-input:focus { outline: none; border-color: #1d4ed8; }
.token-btn {
  width: 100%; background: #1d4ed8; color: #fff; border: none;
  font-size: 13px; font-weight: 700; border-radius: 10px; padding: 11px 0;
  cursor: pointer;
}
.token-btn:hover { background: #1e40af; }
</style>

<div class="token-wrap">
  <div class="token-icon">🔒</div>
  <div class="token-title">{{ $soal->paket }}</div>
  <div class="token-desc">Ujian ini dikunci dengan token. Minta token ujian ke guru/pengawas di kelas.</div>

  @if(session('error_token'))
    <div class="alert alert-danger" style="font-size:12.5px;">{{ session('error_token') }}</div>
  @endif

  <form method="POST" action="{{ url('/verifikasi-token/'.$soal->id) }}">
    {!! csrf_field() !!}
    <input type="text" name="token" class="token-input" maxlength="10" placeholder="TOKEN" autofocus required>
    <button type="submit" class="token-btn">Masuk Ujian</button>
  </form>
</div>
@endsection
