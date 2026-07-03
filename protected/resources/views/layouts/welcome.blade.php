<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="{{ url('img/favicon.ico') }}">
<title>CBT - {{ isset($namasekolah) ? $namasekolah : 'Selamat Datang' }}</title>
<meta name="logo-sekolah" content="{{ isset($logosekolah) && $logosekolah ? url('img/'.$logosekolah) : '' }}">
<meta name="nama-sekolah" content="{{ isset($namasekolah) ? $namasekolah : '' }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body,.cbt-page{min-height:100vh;font-family:'Inter','Segoe UI',sans-serif;background:#f0f4ff}
.cbt-page{position:relative;display:flex;flex-direction:column;min-height:100vh;overflow:hidden}

.blob{position:fixed;border-radius:50%;filter:blur(80px);opacity:.5;pointer-events:none;z-index:0}
.blob-1{width:500px;height:500px;background:radial-gradient(circle,#bfdbfe,#dbeafe);top:-150px;left:-150px;animation:float1 10s ease-in-out infinite}
.blob-2{width:400px;height:400px;background:radial-gradient(circle,#fef9c3,#fef3c7);bottom:-100px;right:-100px;animation:float2 12s ease-in-out infinite}
.blob-3{width:300px;height:300px;background:radial-gradient(circle,#e0e7ff,#c7d2fe);top:50%;right:10%;animation:float1 9s ease-in-out infinite reverse}
@keyframes float1{0%,100%{transform:translate(0,0) scale(1)}50%{transform:translate(30px,20px) scale(1.05)}}
@keyframes float2{0%,100%{transform:translate(0,0) scale(1)}50%{transform:translate(-20px,-30px) scale(1.05)}}

.cbt-main{position:relative;z-index:10;flex:1;display:flex;align-items:center;justify-content:center;padding:80px 20px 40px}

.cbt-card{background:rgba(255,255,255,.85);backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.9);border-radius:28px;padding:52px 48px;text-align:center;max-width:460px;width:100%;box-shadow:0 4px 6px rgba(99,102,241,.04),0 20px 60px rgba(99,102,241,.1),0 0 0 1px rgba(255,255,255,.6) inset}

.cbt-logo-wrap{display:inline-flex;align-items:center;justify-content:center;margin-bottom:28px}
.cbt-logo{width:100px;height:100px;border-radius:50%;object-fit:cover;border:3px solid #fff;box-shadow:0 4px 20px rgba(99,102,241,.2)}
.cbt-logo-fallback{width:100px;height:100px;border-radius:50%;background:linear-gradient(135deg,#dbeafe,#e0e7ff);border:3px solid #fff;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 20px rgba(99,102,241,.2)}
.cbt-logo-fallback i{font-size:44px;color:#3b82f6}

.cbt-school{font-size:19px;font-weight:800;color:#1e3a8a;margin-bottom:6px;line-height:1.3}
.cbt-subtitle{font-size:12.5px;color:#94a3b8;margin-bottom:32px}

.cbt-divider{display:flex;align-items:center;gap:12px;margin-bottom:24px}
.cbt-divider-line{flex:1;height:1px;background:linear-gradient(90deg,transparent,#e2e8f0,transparent)}
.cbt-divider-text{font-size:11px;color:#cbd5e1;font-weight:500;letter-spacing:1px;text-transform:uppercase;white-space:nowrap}

.cbt-btn-group{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:24px}
.cbt-btn{position:relative;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;padding:20px 16px;border-radius:16px;border:none;cursor:pointer;text-decoration:none;font-family:inherit;transition:all .25s cubic-bezier(.4,0,.2,1)}
.cbt-btn:hover{transform:translateY(-3px);text-decoration:none}
.cbt-btn:active{transform:translateY(-1px)}
.cbt-btn-guru{background:linear-gradient(135deg,#1d4ed8,#3b82f6);box-shadow:0 4px 15px rgba(59,130,246,.3);color:#fff}
.cbt-btn-guru:hover{box-shadow:0 8px 25px rgba(59,130,246,.45);color:#fff}
.cbt-btn-guru .cbt-btn-icon{background:rgba(255,255,255,.2);color:#fff}
.cbt-btn-siswa{background:linear-gradient(135deg,#d97706,#f59e0b);box-shadow:0 4px 15px rgba(245,158,11,.3);color:#fff}
.cbt-btn-siswa:hover{box-shadow:0 8px 25px rgba(245,158,11,.45);color:#fff}
.cbt-btn-siswa .cbt-btn-icon{background:rgba(255,255,255,.2);color:#fff}
.cbt-btn-icon{width:42px;height:42px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;margin-bottom:2px}
.cbt-btn-label{font-size:12px;font-weight:700;letter-spacing:1px;text-transform:uppercase}
.cbt-btn-desc{font-size:10px;opacity:.8;font-weight:400}

.cbt-info{display:flex;align-items:center;justify-content:center;gap:6px;background:linear-gradient(135deg,#eff6ff,#fefce8);border:1px solid #e0e7ff;border-radius:10px;padding:10px 16px;font-size:11.5px;color:#475569}
.cbt-info i{font-size:14px;color:#3b82f6}
.cbt-footer{position:relative;z-index:10;text-align:center;padding:20px;font-size:11px;color:#94a3b8}

/* NAVBAR */
.cbt-navbar{position:fixed;top:0;left:0;right:0;z-index:100;background:rgba(255,255,255,.82);backdrop-filter:blur(20px);border-bottom:1px solid rgba(255,255,255,.9);padding:0 32px;height:58px;display:flex;align-items:center;justify-content:space-between;box-shadow:0 1px 0 rgba(30,58,138,.04)}
.cbt-navbar-brand{display:flex;align-items:center;gap:10px}
.cbt-navbar-logo{width:34px;height:34px;border-radius:10px;object-fit:contain;border:1px solid rgba(255,255,255,.9)}
.cbt-navbar-logo-fb{width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,#dbeafe,#e0e7ff);display:flex;align-items:center;justify-content:center}
.cbt-navbar-logo-fb i{font-size:18px;color:#3b82f6}
.cbt-navbar-name{font-size:13.5px;font-weight:800;color:#1e3a8a;letter-spacing:.1px}
.cbt-navbar-name span{color:#d97706}

/* MODAL */
.modal-overlay{display:none;position:fixed;inset:0;z-index:999;background:rgba(15,23,60,.45);backdrop-filter:blur(6px);align-items:center;justify-content:center}
.modal-overlay.active{display:flex;animation:fadeIn .2s ease}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}

.login-card{background:rgba(255,255,255,.97);backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.9);border-radius:24px;padding:40px 36px;width:100%;max-width:380px;box-shadow:0 20px 60px rgba(30,58,138,.15);animation:slideUp .25s cubic-bezier(.4,0,.2,1);position:relative}
@keyframes slideUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}

.login-close{position:absolute;top:16px;right:16px;width:32px;height:32px;border-radius:8px;border:none;background:rgba(99,102,241,.08);color:#64748b;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:18px;transition:all .2s}
.login-close:hover{background:rgba(239,68,68,.1);color:#ef4444}

.login-tabs{display:flex;background:#f1f5f9;border-radius:12px;padding:4px;margin-bottom:24px;gap:4px}
.login-tab{flex:1;padding:8px;border:none;border-radius:9px;font-size:12px;font-weight:600;cursor:pointer;font-family:inherit;transition:all .2s;background:transparent;color:#94a3b8}
.login-tab.active-guru{background:#fff;color:#1d4ed8;box-shadow:0 2px 8px rgba(59,130,246,.15)}
.login-tab.active-siswa{background:#fff;color:#d97706;box-shadow:0 2px 8px rgba(245,158,11,.15)}

.login-header{text-align:center;margin-bottom:24px}
.login-icon{width:56px;height:56px;border-radius:16px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:14px}
.login-icon-guru{background:linear-gradient(135deg,#1d4ed8,#3b82f6);box-shadow:0 4px 15px rgba(59,130,246,.35)}
.login-icon-siswa{background:linear-gradient(135deg,#d97706,#f59e0b);box-shadow:0 4px 15px rgba(245,158,11,.35)}
.login-icon i{font-size:26px;color:#fff}

.login-title-guru{font-size:18px;font-weight:800;color:#1e3a8a;margin-bottom:4px}
.login-title-siswa{font-size:18px;font-weight:800;color:#92400e;margin-bottom:4px}
.login-subtitle{font-size:12px;color:#94a3b8}

.login-form-group{margin-bottom:16px}
.login-label{display:block;font-size:12px;font-weight:600;color:#475569;margin-bottom:6px;letter-spacing:.3px}
.login-input{width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;color:#1e293b;background:#f8fafc;font-family:inherit;transition:all .2s;outline:none}
.login-input:focus{border-color:#3b82f6;background:#fff;box-shadow:0 0 0 3px rgba(59,130,246,.1)}
.login-input-siswa:focus{border-color:#f59e0b;box-shadow:0 0 0 3px rgba(245,158,11,.1)}
.login-input::placeholder{color:#cbd5e1}

.pw-wrap{position:relative}
.pw-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;display:flex;align-items:center;padding:0}

.login-remember{display:flex;align-items:center;gap:8px;margin-bottom:20px;cursor:pointer;font-size:13px;color:#64748b}
.login-remember input[type="checkbox"]{width:15px;height:15px;cursor:pointer}
.login-remember input[type="checkbox"].guru-check{accent-color:#3b82f6}
.login-remember input[type="checkbox"].siswa-check{accent-color:#f59e0b}

.login-error{display:none;background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:10px 14px;font-size:12px;color:#dc2626;margin-bottom:16px}

.login-submit{width:100%;padding:13px;border-radius:12px;border:none;color:#fff;font-size:14px;font-weight:700;font-family:inherit;cursor:pointer;transition:all .25s;letter-spacing:.3px}
.login-submit-guru{background:linear-gradient(135deg,#1d4ed8,#3b82f6);box-shadow:0 4px 15px rgba(59,130,246,.3)}
.login-submit-guru:hover{box-shadow:0 6px 20px rgba(59,130,246,.45);transform:translateY(-1px)}
.login-submit-siswa{background:linear-gradient(135deg,#d97706,#f59e0b);box-shadow:0 4px 15px rgba(245,158,11,.3)}
.login-submit-siswa:hover{box-shadow:0 6px 20px rgba(245,158,11,.45);transform:translateY(-1px)}
.login-submit:active{transform:translateY(0)}
.login-footer{text-align:center;margin-top:16px;font-size:12px;color:#94a3b8}

@media(max-width:480px){
  .cbt-card{padding:36px 20px}
  .cbt-btn-group{grid-template-columns:1fr}
  .login-card{padding:32px 24px;margin:0 16px}
}
</style>
</head>
<body>
<div class="cbt-page">
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>
  <div class="blob blob-3"></div>

  <nav class="cbt-navbar">
    <div class="cbt-navbar-brand">
      <div id="nav-logo-wrap">
        <div class="cbt-navbar-logo-fb"><i class="material-icons">school</i></div>
      </div>
      <span class="cbt-navbar-name" id="nav-school-name">CBT <span>●</span> Sekolah</span>
    </div>
  </nav>

  @yield('content')

  <div class="cbt-footer">&copy; {{ date('Y') }} {{ isset($namasekolah) ? $namasekolah : '' }} &mdash; CBT v1.4.5</div>
</div>

<!-- MODAL LOGIN -->
<div class="modal-overlay" id="modalLogin" onclick="closeOnOverlay(event)">
  <div class="login-card">
    <button class="login-close" onclick="closeModal()"><i class="material-icons" style="font-size:18px;">close</i></button>
    <div class="login-tabs">
      <button class="login-tab active-guru" id="tab-guru" onclick="switchTab('guru')">🔑 &nbsp;Login Guru</button>
      <button class="login-tab" id="tab-siswa" onclick="switchTab('siswa')">🎓 &nbsp;Login Siswa</button>
    </div>
    <div class="login-header">
      <div class="login-icon login-icon-guru" id="modal-icon">
        <i class="material-icons" id="modal-icon-i">admin_panel_settings</i>
      </div>
      <div id="modal-title" class="login-title-guru">Login Guru</div>
      <div class="login-subtitle">Masukkan email dan password Anda</div>
    </div>
    <div class="login-error" id="loginError"></div>

    <!-- FORM GURU -->
    <div id="form-guru">
      <form method="POST" action="{{ url('/auth/login') }}">
        {!! csrf_field() !!}
        <div class="login-form-group">
          <label class="login-label">Email</label>
          <input type="email" name="email" class="login-input" placeholder="nama@sekolah.sch.id" required>
        </div>
        <div class="login-form-group">
          <label class="login-label">Password</label>
          <div class="pw-wrap">
            <input type="password" name="password" id="pwGuru" class="login-input" placeholder="••••••••" required style="padding-right:44px">
            <button type="button" class="pw-toggle" onclick="togglePw('pwGuru','eyeGuru')">
              <i class="material-icons" id="eyeGuru" style="font-size:18px">visibility</i>
            </button>
          </div>
        </div>
        <label class="login-remember">
          <input type="checkbox" name="remember" class="guru-check"> Ingat saya
        </label>
        <button type="submit" class="login-submit login-submit-guru">Masuk &rarr;</button>
      </form>
    </div>

    <!-- FORM SISWA -->
    <div id="form-siswa" style="display:none">
      <div class="login-form-group">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:8px">
          <a href="{{ url('/siswa') }}" style="text-decoration:none">
            <button type="button" class="login-submit login-submit-siswa" style="background:linear-gradient(135deg,#1d4ed8,#3b82f6)">
              📝 Ujian
            </button>
          </a>
          <a href="{{ url('/latihan') }}" style="text-decoration:none">
            <button type="button" class="login-submit login-submit-siswa">
              📖 Latihan
            </button>
          </a>
        </div>
        <p style="font-size:11px;color:#94a3b8;text-align:center;margin-top:8px">Pilih mode untuk melanjutkan</p>
      </div>
    </div>

    <div class="login-footer">Lupa password? Hubungi administrator</div>
  </div>
</div>

<script>
function openModal(role) {
  document.getElementById('modalLogin').classList.add('active');
  applyTab(role);
}
function closeModal() { document.getElementById('modalLogin').classList.remove('active'); }
function closeOnOverlay(e) { if (e.target === document.getElementById('modalLogin')) closeModal(); }
document.addEventListener('keydown', function(e){ if (e.key === 'Escape') closeModal(); });
function switchTab(role) { applyTab(role); }
function applyTab(role) {
  var isGuru = (role === 'guru');
  document.getElementById('tab-guru').className  = 'login-tab' + (isGuru ? ' active-guru' : '');
  document.getElementById('tab-siswa').className = 'login-tab' + (!isGuru ? ' active-siswa' : '');
  document.getElementById('modal-icon').className = 'login-icon ' + (isGuru ? 'login-icon-guru' : 'login-icon-siswa');
  document.getElementById('modal-icon-i').textContent = isGuru ? 'admin_panel_settings' : 'school';
  document.getElementById('modal-title').className = isGuru ? 'login-title-guru' : 'login-title-siswa';
  document.getElementById('modal-title').textContent = isGuru ? 'Login Guru' : 'Login Siswa';
  document.getElementById('form-guru').style.display  = isGuru ? 'block' : 'none';
  document.getElementById('form-siswa').style.display = isGuru ? 'none'  : 'block';
}
function togglePw(inputId, iconId) {
  var inp = document.getElementById(inputId);
  var ico = document.getElementById(iconId);
  if (inp.type === 'password') { inp.type = 'text'; ico.textContent = 'visibility_off'; }
  else { inp.type = 'password'; ico.textContent = 'visibility'; }
}
document.addEventListener('DOMContentLoaded', function() {
  var logoMeta  = document.querySelector('meta[name="logo-sekolah"]');
  var schoolMeta = document.querySelector('meta[name="nama-sekolah"]');
  var logoUrl   = logoMeta  ? logoMeta.getAttribute('content')  : '';
  var namaSchool = schoolMeta ? schoolMeta.getAttribute('content') : 'CBT Sekolah';

  // Update nama di navbar
  var navName = document.getElementById('nav-school-name');
  if (navName && namaSchool) {
    navName.innerHTML = namaSchool + ' <span>●</span> CBT';
  }

  if (logoUrl) {
    var img = new Image();
    img.onload = function() {
      // Logo di navbar
      var navWrap = document.getElementById('nav-logo-wrap');
      if (navWrap) navWrap.innerHTML = '<img src="'+logoUrl+'" class="cbt-navbar-logo" alt="logo">';

      // Logo di card utama
      var cardLogo = document.getElementById('card-logo-wrap');
      if (cardLogo) cardLogo.innerHTML = '<img src="'+logoUrl+'" class="cbt-logo" alt="logo">';

      // Logo di modal
      var modalIcon = document.getElementById('modal-icon');
      if (modalIcon) {
        modalIcon.innerHTML = '<img src="'+logoUrl+'" style="width:40px;height:40px;border-radius:10px;object-fit:contain">';
        modalIcon.className = 'login-icon';
        modalIcon.style.cssText = 'background:#fff;border:1px solid #e2e8f0;width:56px;height:56px;border-radius:16px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:14px';
      }
    };
    img.src = logoUrl;
  }
});
</script>
</body>
</html>
