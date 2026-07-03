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
.login-wrap {
  background: rgba(255,255,255,.85);
  backdrop-filter: blur(24px);
  border: 1px solid rgba(255,255,255,.9);
  border-radius: 28px;
  padding: 44px 40px;
  width: 100%;
  max-width: 420px;
  box-shadow: 0 4px 6px rgba(99,102,241,.04), 0 20px 60px rgba(99,102,241,.1);
  text-align: center;
}
.login-logo-wrap { margin-bottom: 22px; }
.login-logo {
  width: 80px; height: 80px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid #fff;
  box-shadow: 0 4px 20px rgba(99,102,241,.2);
}
.login-logo-fb {
  width: 80px; height: 80px;
  border-radius: 50%;
  background: linear-gradient(135deg,#dbeafe,#e0e7ff);
  border: 3px solid #fff;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto;
  box-shadow: 0 4px 20px rgba(99,102,241,.2);
}
.login-logo-fb i { font-size: 34px; color: #3b82f6; }
.login-school { font-size: 17px; font-weight: 800; color: #1e3a8a; margin-bottom: 4px; }
.login-subtitle { font-size: 12px; color: #94a3b8; margin-bottom: 28px; }
.login-divider { display:flex;align-items:center;gap:10px;margin-bottom:22px; }
.login-divider-line { flex:1;height:1px;background:linear-gradient(90deg,transparent,#e2e8f0,transparent); }
.login-divider-text { font-size:10px;color:#cbd5e1;font-weight:500;letter-spacing:1px;text-transform:uppercase; }
.frm-group { margin-bottom: 16px; text-align: left; }
.frm-label { display:block;font-size:12px;font-weight:600;color:#475569;margin-bottom:6px;letter-spacing:.3px; }
.frm-input {
  width: 100%; padding: 11px 14px;
  border: 1.5px solid #e2e8f0; border-radius: 10px;
  font-size: 14px; color: #1e293b; background: #f8fafc;
  font-family: 'Inter',sans-serif; transition: all .2s; outline: none;
}
.frm-input:focus { border-color: #3b82f6; background: #fff; box-shadow: 0 0 0 3px rgba(59,130,246,.1); }
.frm-input::placeholder { color: #cbd5e1; }
.pw-wrap { position: relative; }
.pw-toggle {
  position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
  background: none; border: none; cursor: pointer; color: #94a3b8;
  display: flex; align-items: center; padding: 0;
}
.frm-remember { display:flex;align-items:center;gap:8px;margin-bottom:20px;cursor:pointer;font-size:13px;color:#64748b;text-align:left; }
.frm-remember input[type="checkbox"] { width:15px;height:15px;accent-color:#3b82f6;cursor:pointer; }
.frm-error {
  background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px;
  padding: 10px 14px; font-size: 12px; color: #dc2626; margin-bottom: 16px; text-align: left;
}
.frm-btn {
  width: 100%; padding: 13px; border-radius: 12px; border: none; color: #fff;
  font-size: 14px; font-weight: 700; font-family: 'Inter',sans-serif; cursor: pointer;
  background: linear-gradient(135deg,#1d4ed8,#3b82f6);
  box-shadow: 0 4px 15px rgba(59,130,246,.3);
  transition: all .25s; letter-spacing: .3px;
}
.frm-btn:hover { box-shadow: 0 6px 20px rgba(59,130,246,.45); transform: translateY(-1px); }
.frm-back { display:block;text-align:center;margin-top:16px;font-size:12px;color:#94a3b8;text-decoration:none;transition:color .2s; }
.frm-back:hover { color: #3b82f6; }
</style>

<div class="cbt-main">
  <div class="login-wrap">

    {{-- LOGO --}}
    <div class="login-logo-wrap">
      @if($logosekolah)
        <img src="{{ url('img/'.$logosekolah) }}" alt="{{ $namasekolah }}" class="login-logo">
      @else
        <div class="login-logo-fb"><i class="material-icons">school</i></div>
      @endif
    </div>

    <div class="login-school">{{ $namasekolah ?: 'CBT Sekolah' }}</div>
    <div class="login-subtitle">Login</div>

    <div class="login-divider">
      <div class="login-divider-line"></div>
      <div class="login-divider-text">Masuk dengan akun Anda</div>
      <div class="login-divider-line"></div>
    </div>

    @if (count($errors) > 0)
      <div class="frm-error">
        @foreach ($errors->all() as $error)
          ⚠ {{ $error }}<br>
        @endforeach
      </div>
    @endif

    <form method="POST" action="{{ url('/auth/login') }}">
      {!! csrf_field() !!}
      <div class="frm-group">
        <label class="frm-label">Email</label>
        <input type="email" name="email" class="frm-input" placeholder="nama@sekolah.sch.id" required autofocus>
      </div>
      <div class="frm-group">
        <label class="frm-label">Password</label>
        <div class="pw-wrap">
          <input type="password" name="password" id="pwInput" class="frm-input" placeholder="Password" required style="padding-right:44px">
          <button type="button" class="pw-toggle" onclick="togglePw()">
            <i class="material-icons" id="eyeIcon" style="font-size:18px">visibility</i>
          </button>
        </div>
      </div>
      <label class="frm-remember">
        <input type="checkbox" name="remember"> Ingat saya
      </label>
      <button type="submit" class="frm-btn">Masuk →</button>
    </form>

    <a href="{{ url('/') }}" class="frm-back">← Kembali ke Beranda</a>
  </div>
</div>

<script>
function togglePw() {
  var inp  = document.getElementById('pwInput');
  var icon = document.getElementById('eyeIcon');
  if (inp.type === 'password') { inp.type = 'text'; icon.textContent = 'visibility_off'; }
  else { inp.type = 'password'; icon.textContent = 'visibility'; }
}
</script>
@endsection
