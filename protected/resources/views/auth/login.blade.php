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
.login-page {
  min-height: calc(100vh - 62px);
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f7f9fc;
  padding: 40px 16px;
}
.login-card {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 8px 40px rgba(26,79,160,.11);
  padding: 44px 48px;
  width: 100%;
  max-width: 420px;
  border: 1px solid #edf1f7;
}
.login-logo {
  width: 72px; height: 72px;
  border-radius: 18px;
  background: #eef4ff;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 18px;
  font-size: 34px;
}
.login-school {
  text-align: center;
  margin-bottom: 28px;
}
.login-school h2 {
  font-size: 17px; font-weight: 700; color: #0f2a5e; margin-bottom: 4px;
}
.login-school p {
  font-size: 12px; color: #9aaabf;
}
.form-label {
  font-size: 12px; font-weight: 600; color: #4a6080;
  display: block; margin-bottom: 6px; letter-spacing: .3px;
}
.form-input {
  width: 100%;
  padding: 11px 14px;
  border: 1.5px solid #e0e8f0;
  border-radius: 9px;
  font-size: 14px;
  color: #0f2a5e;
  background: #f7f9fc;
  transition: border .2s;
  outline: none;
  margin-bottom: 16px;
}
.form-input:focus { border-color: #1a4fa0; background: #fff; }
.btn-login {
  width: 100%;
  padding: 13px;
  background: #1a4fa0;
  color: #fff;
  border: none;
  border-radius: 9px;
  font-size: 15px;
  font-weight: 700;
  cursor: pointer;
  transition: background .2s;
  margin-top: 6px;
  letter-spacing: .3px;
}
.btn-login:hover { background: #163d80; }
.btn-home {
  display: block;
  text-align: center;
  margin-top: 16px;
  font-size: 13px;
  color: #7a8fa6;
  text-decoration: none;
}
.btn-home:hover { color: #1a4fa0; }
.alert-error {
  background: #fff2f2;
  border: 1px solid #ffd0d0;
  border-radius: 8px;
  padding: 10px 14px;
  margin-bottom: 16px;
  font-size: 12px;
  color: #c0392b;
}
.remember-row {
  display: flex; align-items: center; gap: 8px; margin-bottom: 18px;
}
.remember-row input { width: 15px; height: 15px; accent-color: #1a4fa0; }
.remember-row label { font-size: 12px; color: #7a8fa6; cursor: pointer; margin: 0; }
</style>

<div class="login-page">
  <div class="login-card">
    <div class="login-logo">
      @if($logosekolah)
        <img src="{{ url('img/'.$logosekolah) }}" style="width:52px;height:52px;object-fit:contain;border-radius:12px">
      @else
        <img src="{{ url('img/logo.png') }}" style="width:52px;height:52px;object-fit:contain;border-radius:12px"
             onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
        <span style="display:none;font-size:28px">🏫</span>
      @endif
    </div>
    <div class="login-school">
      <h2>{{ $namasekolah ?: 'CBT Sekolah' }}</h2>
      <p>Login untuk mengakses halaman guru / admin</p>
    </div>

    @if (count($errors) > 0)
      <div class="alert-error">
        @foreach ($errors->all() as $error)
          ⚠ {{ $error }}<br>
        @endforeach
      </div>
    @endif

    <form method="POST" action="{{ url('/auth/login') }}">
      {!! csrf_field() !!}
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-input" placeholder="nama@sekolah.sch.id" required autofocus>
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-input" placeholder="••••••••" required>
      <div class="remember-row">
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">Ingat saya</label>
      </div>
      <button type="submit" class="btn-login">Masuk →</button>
    </form>

    <a href="{{ url('/') }}" class="btn-home">← Kembali ke Beranda</a>
  </div>
</div>
@endsection
