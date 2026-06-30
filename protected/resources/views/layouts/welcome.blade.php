<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ url('img/favicon.ico') }}">
  <title>CBT - {{ isset($namasekolah) ? $namasekolah : 'Selamat Datang' }}</title>
  <meta name="logo-sekolah" content="{{ isset($logosekolah) && $logosekolah ? url('img/'.$logosekolah) : url('img/logo.png') }}">
  <link rel="stylesheet" href="{{ url('/assets/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      background: #f7f9fc;
      min-height: 100vh;
    }

    /* ===== NAVBAR ===== */
    .navbar-welcome {
      background: #fff;
      border-bottom: 1.5px solid #e8edf3;
      padding: 0 40px;
      height: 62px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 100;
      box-shadow: 0 2px 12px rgba(30,80,160,.06);
    }
    .navbar-brand-text {
      font-size: 17px;
      font-weight: 700;
      color: #1a4fa0;
      letter-spacing: .3px;
    }
    .navbar-brand-text span {
      color: #f5c518;
    }
    .navbar-links a {
      color: #4a6080;
      text-decoration: none;
      font-size: 13px;
      font-weight: 500;
      margin-left: 28px;
      letter-spacing: .3px;
      transition: color .2s;
    }
    .navbar-links a:hover { color: #1a4fa0; }
    .navbar-links a.btn-login-nav {
      background: #1a4fa0;
      color: #fff;
      border-radius: 6px;
      padding: 7px 18px;
      font-size: 13px;
    }
    .navbar-links a.btn-login-nav:hover { background: #163d80; }

    /* ===== HERO ===== */
    .hero-section {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      text-align: center;
      padding: 100px 20px 60px;
    }
    .hero-logo-wrap {
      width: 110px;
      height: 110px;
      border-radius: 28px;
      background: #fff;
      box-shadow: 0 8px 32px rgba(26,79,160,.13);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 28px;
      overflow: hidden;
    }
    .hero-logo-wrap img {
      width: 90px;
      height: 90px;
      object-fit: contain;
    }
    .hero-badge {
      display: inline-block;
      background: #eef4ff;
      color: #1a4fa0;
      font-size: 11px;
      font-weight: 600;
      letter-spacing: 1.5px;
      padding: 5px 16px;
      border-radius: 20px;
      margin-bottom: 18px;
      text-transform: uppercase;
    }
    .hero-title {
      font-size: 30px;
      font-weight: 700;
      color: #0f2a5e;
      line-height: 1.25;
      margin-bottom: 10px;
      max-width: 600px;
    }
    .hero-title span { color: #f5c518; }
    .hero-subtitle {
      font-size: 14px;
      color: #7a8fa6;
      margin-bottom: 36px;
      max-width: 440px;
      line-height: 1.7;
    }

    /* ===== TOMBOL LOGIN ===== */
    .btn-group-hero {
      display: flex;
      gap: 14px;
      justify-content: center;
      flex-wrap: wrap;
    }
    .btn-hero {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      padding: 18px 52px;
      border-radius: 12px;
      font-size: 16px;
      font-weight: 700;
      text-decoration: none;
      cursor: pointer;
      border: none;
      transition: all .2s;
      letter-spacing: .3px;
    }
    .btn-hero-primary {
      background: #1a4fa0;
      color: #fff;
      box-shadow: 0 4px 16px rgba(26,79,160,.25);
    }
    .btn-hero-primary:hover {
      background: #163d80;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(26,79,160,.32);
      color: #fff;
      text-decoration: none;
    }
    .btn-hero-yellow {
      background: #f5c518;
      color: #1a2a40;
      box-shadow: 0 4px 16px rgba(245,197,24,.28);
    }
    .btn-hero-yellow:hover {
      background: #e8b800;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(245,197,24,.38);
      color: #1a2a40;
      text-decoration: none;
    }



    /* ===== FOOTER ===== */
    .footer-welcome {
      text-align: center;
      padding: 20px;
      font-size: 12px;
      color: #b0bec5;
      border-top: 1px solid #edf1f7;
      background: #fff;
    }

    /* ===== MODAL POPUP LOGIN ===== */
    .modal-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(10,25,60,.45);
      backdrop-filter: blur(4px);
      z-index: 999;
      align-items: center;
      justify-content: center;
    }
    .modal-overlay.active { display: flex; }
    .modal-box {
      background: #fff;
      border-radius: 18px;
      padding: 40px 44px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 16px 60px rgba(26,79,160,.18);
      position: relative;
      animation: popIn .22s ease;
    }
    @keyframes popIn {
      from { transform: scale(.93); opacity: 0; }
      to   { transform: scale(1);   opacity: 1; }
    }
    .modal-close {
      position: absolute; top: 16px; right: 18px;
      background: none; border: none; font-size: 20px;
      color: #9aaabf; cursor: pointer; line-height: 1;
    }
    .modal-close:hover { color: #0f2a5e; }
    .modal-logo {
      width: 56px; height: 56px; border-radius: 14px;
      background: #eef4ff; display: flex; align-items: center;
      justify-content: center; margin: 0 auto 14px; font-size: 26px;
    }
    .modal-title { text-align:center; margin-bottom: 24px; }
    .modal-title h3 { font-size: 17px; font-weight: 700; color: #0f2a5e; margin-bottom: 3px; }
    .modal-title p  { font-size: 12px; color: #9aaabf; }
    .modal-input {
      width: 100%; padding: 11px 14px;
      border: 1.5px solid #e0e8f0; border-radius: 9px;
      font-size: 14px; color: #0f2a5e; background: #f7f9fc;
      outline: none; margin-bottom: 13px; transition: border .2s;
    }
    .modal-input:focus { border-color: #1a4fa0; background: #fff; }
    .modal-label {
      font-size: 12px; font-weight: 600; color: #4a6080;
      display: block; margin-bottom: 5px; letter-spacing: .3px;
    }
    .modal-btn {
      width: 100%; padding: 13px; background: #1a4fa0; color: #fff;
      border: none; border-radius: 9px; font-size: 15px; font-weight: 700;
      cursor: pointer; margin-top: 4px; transition: background .2s;
    }
    .modal-btn:hover { background: #163d80; }
    .modal-footer-link {
      text-align: center; margin-top: 14px; font-size: 12px; color: #9aaabf;
    }
    .modal-footer-link a { color: #1a4fa0; text-decoration: none; }
    .modal-remember {
      display: flex; align-items: center; gap: 8px; margin-bottom: 16px;
    }
    .modal-remember input { width:15px; height:15px; accent-color:#1a4fa0; }
    .modal-remember label { font-size:12px; color:#7a8fa6; margin:0; cursor:pointer; }

    @media (max-width: 600px) {
      .navbar-welcome { padding: 0 16px; }
      .navbar-links a:not(.btn-login-nav) { display: none; }
      .hero-title { font-size: 22px; }
      .btn-hero { padding: 12px 22px; font-size: 13px; }
      .info-card { min-width: 140px; }
    }
  </style>
</head>
<body>

  {{-- NAVBAR --}}
  <nav class="navbar-welcome">
    <div class="navbar-brand-text">
      CBT <span>●</span> {{ isset($namasekolah) ? $namasekolah : 'Sekolah' }}
    </div>
    <div class="navbar-links">
      <a href="/">Beranda</a>
    </div>
  </nav>

  @yield('content')

  <footer class="footer-welcome">
    &copy; {{ date('Y') }} {{ isset($namasekolah) ? $namasekolah : '' }} &mdash; Computer Based Test
  </footer>

  <script src="{{ url('/assets/assets/vendor/jquery.min.js') }}"></script>
  <script src="{{ url('lib/bootstrap/js/bootstrap.js') }}"></script>

  {{-- MODAL POPUP LOGIN --}}
  <div class="modal-overlay" id="loginModal" onclick="if(event.target===this)closeModal()">
    <div class="modal-box">
      <button class="modal-close" onclick="closeModal()">✕</button>
      <div class="modal-logo" id="modal-logo-wrap">
      <img id="modal-logo-img" src="" style="width:40px;height:40px;object-fit:contain;border-radius:10px">
    </div>
      <div class="modal-title">
        <h3>Login Guru / Admin</h3>
        <p>Masukkan email dan password Anda</p>
      </div>
      <form method="POST" action="{{ url('/auth/login') }}">
        {!! csrf_field() !!}
        <label class="modal-label">Email</label>
        <input type="email" name="email" class="modal-input" placeholder="nama@sekolah.sch.id" required>
        <label class="modal-label">Password</label>
        <input type="password" name="password" class="modal-input" placeholder="••••••••" required>
        <div class="modal-remember">
          <input type="checkbox" name="remember" id="rem">
          <label for="rem">Ingat saya</label>
        </div>
        <button type="submit" class="modal-btn">Masuk →</button>
      </form>
      <div class="modal-footer-link">
        Login sebagai siswa? <a href="{{ url('/lobby-siswa') }}">Klik di sini</a>
      </div>
    </div>
  </div>

  <script>
    function openModal()  { document.getElementById('loginModal').classList.add('active'); }
    function closeModal() { document.getElementById('loginModal').classList.remove('active'); }
    document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeModal(); });
    // Load logo sekolah ke modal
    document.addEventListener('DOMContentLoaded', function() {
      var logo = document.querySelector('meta[name="logo-sekolah"]');
      if (logo) {
        var img = document.getElementById('modal-logo-img');
        img.src = logo.getAttribute('content');
        img.onerror = function() {
          this.style.display = 'none';
          this.parentElement.innerHTML = '<span style="font-size:26px">🏫</span>';
        };
      }
    });
  </script>
</body>
</html>
