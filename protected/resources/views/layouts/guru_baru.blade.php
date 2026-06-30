<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>@yield('title')</title>
<link rel="stylesheet" href="{{ url('lib/fontawesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ url('css/admin.css') }}">
<link rel="icon" href="{{ url('img/favicon.ico') }}">
<script src="{{url('js/modernizr.js')}}"></script>
<link rel="stylesheet" href="{{ url('lib/Hover/hover.css') }}">
<link rel="stylesheet" href="{{ url('lib/weather-icons/css/weather-icons.css') }}">
<link rel="stylesheet" href="{{ url('lib/jquery-toggles/toggles-full.css') }}">
<link rel="stylesheet" href="{{ url('lib/morrisjs/morris.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
/* =====================================================================
   TEMA GURU — Minimalis Modern, selaras dengan halaman Welcome
   Palet: Putih + Biru soft (#1a4fa0) + Kuning soft (#f5c518)
   ===================================================================== */
:root {
  --biru: #1a4fa0;
  --biru-tua: #163d80;
  --biru-soft: #eef4ff;
  --kuning: #f5c518;
  --kuning-tua: #e8b800;
  --kuning-soft: #fffbe6;
  --bg: #f5f7fb;
  --surface: #ffffff;
  --judul: #0f2a5e;
  --teks: #3a4a60;
  --muted: #93a3b8;
  --border: #e9eef5;
  --radius: 14px;
  --radius-sm: 10px;
  --shadow: 0 2px 16px rgba(26,79,160,.06);
  --shadow-md: 0 6px 28px rgba(26,79,160,.10);
}

* { box-sizing: border-box; }
body {
  background: var(--bg) !important;
  font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Arial, sans-serif;
  color: var(--teks);
  -webkit-font-smoothing: antialiased;
}
a { transition: color .15s ease; }

/* ============ HEADER ATAS ============ */
.headerpanel {
  background: var(--surface) !important;
  border-bottom: 1px solid var(--border);
  box-shadow: 0 1px 0 rgba(15,42,94,.02);
}
.logopanel {
  background: var(--biru) !important;
  display: flex;
  align-items: center;
}
.logopanel h2 { margin: 0; font-size: 16px; }
.logopanel h2 a {
  color: #fff !important;
  font-weight: 700;
  letter-spacing: .2px;
}
.headerbar { background: transparent; }
.menutoggle { color: var(--judul) !important; }
.btn-logged {
  background: transparent !important;
  border: none !important;
  box-shadow: none !important;
}
.btn-logged h4 { color: var(--judul) !important; font-weight: 600; font-size: 13px; margin: 0; }
.dropdown-menu {
  border: 1px solid var(--border) !important;
  border-radius: var(--radius-sm) !important;
  box-shadow: var(--shadow-md) !important;
  padding: 6px !important;
}
.dropdown-menu > li > a {
  border-radius: 8px;
  font-size: 13px;
  color: var(--teks) !important;
  padding: 8px 12px !important;
}
.dropdown-menu > li > a:hover { background: var(--biru-soft) !important; color: var(--biru) !important; }

/* ============ SIDEBAR KIRI ============ */
.leftpanel {
  background: var(--surface) !important;
  border-right: 1px solid var(--border);
}
.leftpanel-profile {
  background: linear-gradient(135deg, var(--biru), var(--biru-tua)) !important;
  padding: 22px 16px;
  margin: 0;
}
.leftpanel-profile img {
  border: 2.5px solid rgba(255,255,255,.55);
  border-radius: 12px;
}
.leftpanel-profile .media-heading { color: #fff !important; font-weight: 700; font-size: 14px; margin-bottom: 2px; }
.leftpanel-profile span { color: rgba(255,255,255,.78) !important; font-size: 11px; }

.nav-sidebar { background: var(--biru-tua) !important; border: none; }
.nav-sidebar > li { flex: 1; }
.nav-sidebar > li > a {
  color: rgba(255,255,255,.75) !important;
  border: none !important;
  border-radius: 0 !important;
  padding: 10px 0;
}
.nav-sidebar > li.active > a,
.nav-sidebar > li.active > a:hover,
.nav-sidebar > li > a:hover { background: rgba(255,255,255,.08) !important; color: #fff !important; }

.nav-quirk { padding: 6px 0; }
.nav-quirk > li > a {
  color: var(--judul) !important;
  font-weight: 500;
  font-size: 13px;
  border-radius: var(--radius-sm);
  margin: 2px 10px;
  padding: 10px 14px;
  transition: all .15s ease;
}
.nav-quirk > li > a:hover { background: var(--biru-soft) !important; color: var(--biru) !important; }
.nav-quirk > li.active > a,
.nav-quirk > li.nav-parent.active > a {
  background: var(--biru) !important;
  color: #fff !important;
  box-shadow: 0 4px 14px rgba(26,79,160,.25);
}
.nav-quirk .children { padding: 2px 0 8px; }
.nav-quirk .children > li > a {
  color: var(--muted) !important;
  font-size: 12.5px;
  padding: 8px 14px 8px 30px;
  border-radius: 8px;
  margin: 1px 10px 1px 18px;
}
.nav-quirk .children > li > a:hover { background: var(--biru-soft) !important; color: var(--biru) !important; }
.nav-quirk .children > li.active > a {
  background: var(--biru-soft) !important;
  color: var(--biru) !important;
  font-weight: 700;
  border-left: 3px solid var(--kuning);
  padding-left: 27px;
}

/* ============ ICON — monokrom mengikuti tema ============ */
i.fa, .fa { color: inherit !important; }
.nav-quirk > li > a i.fa { color: var(--judul) !important; opacity: .6; width: 18px; text-align: center; }
.nav-quirk > li > a:hover i.fa { color: var(--biru) !important; opacity: 1; }
.nav-quirk > li.active > a i.fa,
.nav-quirk > li.nav-parent.active > a i.fa { color: #fff !important; opacity: 1; }
.nav-quirk .children > li > a i.fa { color: var(--muted) !important; opacity: .75; }
.nav-quirk .children > li.active > a i.fa,
.nav-quirk .children > li > a:hover i.fa { color: var(--biru) !important; opacity: 1; }
.headerbar i.fa, .leftpanel-profile i.fa { color: var(--judul) !important; }
.nav-sidebar i.fa { color: rgba(255,255,255,.85) !important; }
.btn i.fa { color: inherit !important; }
.btn-warning i.fa { color: #1a2a40 !important; }
.table i.fa, .label i.fa, .alert i.fa { color: inherit !important; }
.breadcrumb i.fa, .text-muted i.fa { color: var(--muted) !important; }

/* ============ PANEL / CARD ============ */
.panel {
  border: 1px solid var(--border) !important;
  border-radius: var(--radius) !important;
  box-shadow: var(--shadow) !important;
  overflow: hidden;
  margin-bottom: 22px;
  transition: box-shadow .2s ease;
}
.panel:hover { box-shadow: var(--shadow-md) !important; }
.panel-default > .panel-heading,
.panel-heading {
  background: var(--surface) !important;
  color: var(--judul) !important;
  border-bottom: 1px solid var(--border) !important;
  border-radius: 0 !important;
  font-weight: 700;
  font-size: 14px;
  letter-spacing: .1px;
  padding: 16px 20px;
}
.panel-primary > .panel-heading {
  background: var(--biru) !important;
  color: #fff !important;
  border-color: var(--biru) !important;
}
.panel-primary { border-color: var(--border) !important; }
.panel-body { background: var(--surface); padding: 20px; }

.panel-announcement {
  background: linear-gradient(135deg, var(--biru), var(--biru-tua)) !important;
  color: #fff;
  border-radius: var(--radius) !important;
  border: none !important;
  box-shadow: var(--shadow-md) !important;
}
.panel-announcement h2, .panel-announcement h4 { color: #fff !important; }
.panel-announcement .panel-options a { color: rgba(255,255,255,.7) !important; }

/* ============ TOMBOL ============ */
.btn {
  border-radius: 9px !important;
  font-weight: 600;
  font-size: 13px;
  padding: 9px 18px;
  transition: all .18s ease;
  border-width: 0 !important;
}
.btn-xs { padding: 5px 11px; border-radius: 7px !important; font-size: 11.5px; }
.btn-sm { padding: 7px 14px; border-radius: 8px !important; font-size: 12.5px; }

.btn-primary { background: var(--biru) !important; color: #fff !important; box-shadow: 0 3px 10px rgba(26,79,160,.22); }
.btn-primary:hover { background: var(--biru-tua) !important; transform: translateY(-1px); box-shadow: 0 5px 16px rgba(26,79,160,.3); }

.btn-success { background: #1a8a4a !important; color: #fff !important; box-shadow: 0 3px 10px rgba(26,138,74,.2); }
.btn-success:hover { background: #156b39 !important; transform: translateY(-1px); }

.btn-warning { background: var(--kuning) !important; color: #1a2a40 !important; font-weight: 700; box-shadow: 0 3px 10px rgba(245,197,24,.25); }
.btn-warning:hover { background: var(--kuning-tua) !important; transform: translateY(-1px); }

.btn-danger { background: #e0594a !important; color: #fff !important; box-shadow: 0 3px 10px rgba(224,89,74,.2); }
.btn-danger:hover { background: #c8432f !important; transform: translateY(-1px); }

.btn-default { background: #f0f3f8 !important; color: var(--teks) !important; border: 1px solid var(--border) !important; }
.btn-default:hover { background: #e6ebf3 !important; }

/* ============ TABEL ============ */
.table { border-radius: var(--radius-sm); overflow: hidden; }
.table thead { background: var(--biru-soft); }
.table thead th {
  color: var(--judul) !important;
  border-bottom: 2px solid var(--border) !important;
  font-size: 11.5px;
  text-transform: uppercase;
  letter-spacing: .4px;
  font-weight: 700;
  padding: 12px 14px;
}
.table tbody td { padding: 12px 14px; border-color: var(--border) !important; font-size: 13px; vertical-align: middle; }
.table tbody tr { transition: background .12s ease; }
.table tbody tr:hover { background: #fafcff !important; }
.table-bordered, .table-bordered td, .table-bordered th { border-color: var(--border) !important; }

/* ============ LABEL / BADGE ============ */
.label { border-radius: 6px; font-weight: 600; font-size: 10.5px; padding: 4px 9px; letter-spacing: .2px; }
.label-primary { background: var(--biru) !important; }
.label-info { background: #2196d8 !important; }
.label-success { background: #1a8a4a !important; }
.label-warning { background: var(--kuning) !important; color: #1a2a40 !important; }
.label-danger { background: #e0594a !important; }
.label-default { background: #aab6c7 !important; }

/* ============ FORM ============ */
.form-control {
  border: 1.5px solid var(--border) !important;
  border-radius: 9px !important;
  font-size: 13px;
  padding: 9px 13px;
  background: #fafcff;
  transition: all .15s ease;
}
.form-control:focus {
  border-color: var(--biru) !important;
  box-shadow: 0 0 0 3px rgba(26,79,160,.12) !important;
  background: #fff;
}
label, .control-label { color: var(--judul); font-weight: 600; font-size: 12.5px; }

/* ============ BREADCRUMB ============ */
.breadcrumb {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-sm);
  padding: 11px 16px;
  font-size: 12.5px;
  box-shadow: var(--shadow);
  margin-bottom: 18px;
}
.breadcrumb > li + li::before { color: var(--muted); padding: 0 8px; }
.breadcrumb a { color: var(--biru); font-weight: 500; }
.breadcrumb .active { color: var(--judul); font-weight: 600; }

/* ============ ALERT ============ */
.alert { border-radius: var(--radius-sm); border-width: 1.5px; font-size: 13px; padding: 12px 16px; }
.alert-success { background: #eafaf1; border-color: #b8e6cb; color: #1a8a4a; }
.alert-danger  { background: #fff2f2; border-color: #ffd0d0; color: #c0392b; }
.alert-warning { background: var(--kuning-soft); border-color: #f5e7a8; color: #8a6d00; }
.alert-info    { background: var(--biru-soft); border-color: #c3d8f5; color: var(--biru); }

/* ============ PAGINATION ============ */
.pagination > li > a, .pagination > li > span {
  border-radius: 8px !important;
  margin: 0 2px;
  border: 1px solid var(--border) !important;
  color: var(--teks) !important;
  font-size: 12.5px;
}
.pagination > li.active > a { background: var(--biru) !important; border-color: var(--biru) !important; color: #fff !important; }
.pagination > li > a:hover { background: var(--biru-soft) !important; color: var(--biru) !important; }

/* ============ MODAL ============ */
.modal-content { border-radius: var(--radius) !important; border: none !important; box-shadow: var(--shadow-md) !important; }
.modal-header { background: var(--biru) !important; color: #fff !important; border-radius: var(--radius) var(--radius) 0 0 !important; border-bottom: none !important; }
.modal-header .close { color: #fff !important; opacity: .85; }

/* ============ FOOTER ============ */
.contentpanel .panel-primary { box-shadow: none !important; }
.contentpanel .panel-primary .panel-body {
  background: transparent !important;
  color: var(--muted);
  font-size: 11.5px;
  text-align: center;
  padding: 14px;
}
.contentpanel .panel-primary .panel-body .text-danger { color: var(--kuning-tua) !important; }

/* ============ MEDIA LIST (aktifitas) ============ */
.media-list .media { padding: 12px 0; border-bottom: 1px solid var(--border); }
.media-list .media:last-child { border-bottom: none; }
.media-heading { color: var(--judul); font-size: 13px; font-weight: 700; }
.media-list .date { color: var(--muted); font-size: 11px; }
.media-object.img-thumbnail { border-radius: 10px; border-color: var(--border); }

/* ============ MAINPANEL ============ */
.mainpanel { background: var(--bg); }
.contentpanel { padding: 24px; }
</style>
</head>
<body>
<header>
  <div class="headerpanel" style="background: #fcfdff">
    <div class="logopanel" style="background: #00050f">
      <h2><a href="{{ url('/guru') }}" style="color: #fff">CBT SMK Muh Sampit</a></h2>
    </div>
    <div class="headerbar">
      <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
      <div class="header-right">
        <ul class="headermenu">
          <li>
            <div class="btn-group">
              <button type="button" class="btn btn-logged" data-toggle="dropdown">
                <h4 style="color:gray"><?php
                  $namapendek = explode(" ", Auth::user()->nama);
                  echo $namapendek[0];
                ?>
                <span class="caret"></span></h4>
              </button>
              <ul class="dropdown-menu pull-right">
                <li><a href="{{ url('/profil-guru') }}"><i class="fa fa-user"></i> Profil</a></li>
                <li><a href="{{ url('/auth/logout') }}"><i class="fa fa-sign-out"></i> Log Out</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</header>
<section>
<?php
  include(app_path() . '/functions/koneksi.php');
  if (Auth::user()->status != "S" or Auth::user()->status != "C") {
  $id_kelas = $user->id_kelas;

  $sql = "SELECT * FROM kelas WHERE id = '$id_kelas'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
  	while($row = $result->fetch_assoc()) {
  		$kelas_siswa = $row["nama"];
  	}
  } else {
	$kelas_siswa = "Maaf, Anda belum mendapat kelas";
  }
  $tgl_log_user = explode(" ", Auth::user()->updated_at);
  $bulan_log_user = explode("-", $tgl_log_user[0]);
  $url = Request::segment(1);
?>
  <div class="leftpanel">
    <div class="leftpanelinner">
      <div class="media leftpanel-profile">
        <div class="media-left">
          <a href="#">
            <?php if ($user->gambar == "") { ?>
            <img src="{{ url('img/guru.png') }}" alt="foto guru" class="media-object img-thumbnail" />
            <?php }else{ ?>
            <img src="{{ url('img/'.$user->gambar) }}" alt="{{$user->gambar}}" class="media-object img-thumbnail" />
            <?php } ?>
          </a>
        </div>
        <div class="media-body">
          <h4 class="media-heading">
            <?php
              $namapendek = explode(" ", Auth::user()->nama);
              echo $namapendek[0];
            ?>
          </h4>
          <span>{!! Auth::user()->job !!}</span>
        </div>
      </div>
      
      <ul class="nav nav-tabs nav-justified nav-sidebar">
        <li class="tooltips active" data-toggle="tooltip" title="Main Menu"><a data-toggle="tab" data-target="#mainmenu"><i class="tooltips fa fa-home"></i></a></li>
        <li class="tooltips" data-toggle="tooltip" title="Log Out"><a href="{{ url('/auth/logout') }}"><i class="fa fa-sign-out"></i></a></li>
      </ul>

      <div class="tab-content">

        <!-- ################# MAIN MENU ################### -->

        <div class="tab-pane active" id="mainmenu">
          <ul class="nav nav-pills nav-stacked nav-quirk">
            <li <?php if ($url == 'guru') { echo "class='active'"; } ?>><a href="{{ url('/guru') }}"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
          </ul>

          <ul class="nav nav-pills nav-stacked nav-quirk">
            <li class="nav-parent <?php if ($url == 'data-guru' or $url == 'detail-guru' or $url == 'kelas' or $url == 'detail-kelas' or $url == 'data-siswa' or $url == 'detail-kelas-siswa' or $url == 'iuran-siswa' or $url == 'iuran-bykelas' or $url == 'mapel') { echo " active"; } ?>"><a href=""><i class="fa fa-database"></i> <span>Master Data</span></a>
              <ul class="children">
                <li <?php if ($url == 'data-guru' or $url == 'detail-guru') { echo "class='active'"; } ?>><a href="{{ url('/data-guru') }}"><i class="fa fa-user"></i> Guru</a></li>
                <li <?php if ($url == 'kelas' or $url == 'detail-kelas') { echo "class='active'"; } ?>><a href="{{ url('/kelas') }}"><i class="fa fa-building"></i> Kelas</a></li>
                <li <?php if ($url == 'data-siswa' or $url == 'detail-kelas-siswa') { echo "class='active'"; } ?>><a href="{{ url('/data-siswa') }}"><i class="fa fa-user"></i> Siswa</a></li>
                @if(Auth::user()->status=="A")
                <li <?php if ($url == 'iuran-siswa' or $url == 'iuran-bykelas') { echo "class='active'"; } ?>><a href="{{ url('/iuran-siswa') }}"><i class="fa fa-shopping-bag"></i> Iuran</a></li>
                <li <?php if ($url == 'mapel') { echo "class='active'"; } ?>><a href="{{ url('/mapel') }}"><i class="fa fa-book"></i> Mata Pelajaran</a></li>
                @endif
                
              </ul>
            </li>

            <li class="nav-parent <?php if ($url == 'arsip-kelas' or $url == 'arsip-siswa') { echo " active"; } ?>"><a href=""><i class="fa fa-archive"></i> <span>Arsip</span></a>
              <ul class="children">
                <li <?php if ($url == 'arsip-kelas') { echo "class='active'"; } ?>><a href="{{ url('/arsip-kelas') }}"><i class="fa fa-building"></i> Arsip Kelas</a></li>
                <li <?php if ($url == 'arsip-siswa') { echo "class='active'"; } ?>><a href="{{ url('/arsip-siswa') }}"><i class="fa fa-user"></i> Arsip Siswa</a></li>
              </ul>
            </li>

            <li class="nav-parent <?php if ($url == 'materi' or $url == 'soal-guru' or $url == 'detail-soal' or $url == 'ubah-detail-soal' or $url == 'edit-soal' or $url == 'detail-soal' or $url == 'hasil-guru' or $url == 'detail-hasil') { echo " active"; } ?>"><a href=""><i class="fa fa-graduation-cap"></i> <span>E-Learning</span></a>
              <ul class="children">
                <li <?php if ($url == 'materi') { echo "class='active'"; } ?>><a href="{{ url('/materi') }}"><i class="fa fa-book"></i> Materi</a></li>
                <li <?php if ($url == 'soal-guru' or $url == 'detail-soal' or $url == 'ubah-detail-soal') { echo "class='active'"; } ?>><a href="{{ url('/soal-guru') }}"><i class="fa fa-pencil-square-o"></i> Soal</a></li>
                <li <?php if ($url == 'hasil-guru' or $url == 'detail-hasil') { echo "class='active'"; } ?>><a href="{{ url('/hasil-guru') }}"><i class="fa fa-bar-chart"></i> Laporan</a></li>
              </ul>
            </li>

            <li <?php if ($url == 'profil-guru') { echo "class='active'"; } ?>><a href="{{ url('/profil-guru') }}"><i class="fa fa-cog"></i> Pengaturan</a></li>
            
            
            <li><a href="{{ url('/auth/logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
          </ul>
        </div><!-- tab-pane -->
      </div><!-- tab-content -->
    </div><!-- leftpanelinner -->
  </div>
  <div class="mainpanel">
    <div class="contentpanel">
      <div class="row">
        @yield('content')
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-primary">
            <div class="panel-body">
              Copyright &COPY; 2016 Tipamedia
              <span class="pull-right text-danger"> version: 
                <?php echo(config('app.version')) ?> </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- </div> -->
<?php
  }else{
	  return redirect('url(siswa)');
  }
?>
</section>
<!-- <script src="{{url('lib/jquery/jquery.js')}}"></script> -->
<script src="{{ url('/assets/assets/vendor/jquery.min.js') }}"></script>
<script src="{{ url('lib/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ url('lib/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ url('lib/jquery-toggles/toggles.js') }}"></script>

<script src="{{ url('js/quirk.js') }}"></script>
<script src="{{ url('/js/jquery.backstretch.min.js') }}"></script>
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  // $.backstretch("{{ url('/img/bg2.jpg') }}", {speed: 150});
</script>
{{-- <script src="{{url('js/footable.js')}}"></script> --}}
</body>
</html>
