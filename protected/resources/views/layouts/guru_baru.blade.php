<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>@yield('title')</title>
<link rel="stylesheet" href="{{ url('lib/fontawesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ url('css/admin.css') }}">
{{-- <link rel="stylesheet" href="{{ url('css/footable.bootstrap.css') }}"> --}}
<link rel="icon" href="{{ url('img/favicon.ico') }}">
<script src="{{url('js/modernizr.js')}}"></script>
<link rel="stylesheet" href="{{ url('lib/Hover/hover.css') }}">
<link rel="stylesheet" href="{{ url('lib/weather-icons/css/weather-icons.css') }}">
<link rel="stylesheet" href="{{ url('lib/jquery-toggles/toggles-full.css') }}">
<link rel="stylesheet" href="{{ url('lib/morrisjs/morris.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  /* ================= TEMA GURU — selaras dengan halaman Welcome ================= */
  :root {
    --biru: #1a4fa0;
    --biru-tua: #163d80;
    --kuning: #f5c518;
    --kuning-tua: #e8b800;
    --bg-soft: #f7f9fc;
    --teks-judul: #0f2a5e;
    --teks-muted: #7a8fa6;
    --border-soft: #e8edf3;
  }

  body { background: var(--bg-soft) !important; font-family: 'Segoe UI', Arial, sans-serif; }

  /* HEADER ATAS */
  .headerpanel { background: #fff !important; border-bottom: 1.5px solid var(--border-soft); box-shadow: 0 2px 12px rgba(30,80,160,.06); }
  .logopanel { background: var(--biru) !important; }
  .logopanel h2 a { color: #fff !important; font-weight: 700; letter-spacing: .3px; }
  .btn-logged { background: transparent !important; border: none; }
  .btn-logged h4 { color: var(--teks-judul) !important; font-weight: 600; }

  /* SIDEBAR KIRI */
  .leftpanel { background: #fff !important; border-right: 1px solid var(--border-soft); }
  .leftpanel-profile { background: var(--biru) !important; padding: 18px 14px; }
  .leftpanel-profile .media-heading { color: #fff !important; font-weight: 700; }
  .leftpanel-profile span { color: rgba(255,255,255,.8) !important; font-size: 11px; }
  .leftpanel-profile img { border: 2px solid rgba(255,255,255,.5); }

  .nav-sidebar { background: var(--biru) !important; border: none; }
  .nav-sidebar > li > a { color: rgba(255,255,255,.8) !important; }
  .nav-sidebar > li.active > a,
  .nav-sidebar > li.active > a:hover { background: var(--biru-tua) !important; color: #fff !important; }

  .nav-quirk > li > a { color: var(--teks-judul) !important; font-weight: 500; font-size: 13px; border-radius: 8px; margin: 2px 8px; transition: all .15s; }
  .nav-quirk > li > a:hover { background: #eef4ff !important; color: var(--biru) !important; }
  .nav-quirk > li.active > a,
  .nav-quirk > li.nav-parent.active > a { background: var(--biru) !important; color: #fff !important; }
  .nav-quirk .children > li > a { color: var(--teks-muted) !important; font-size: 12.5px; }
  .nav-quirk .children > li.active > a,
  .nav-quirk .children > li > a:hover { background: #eef4ff !important; color: var(--biru) !important; }
  .nav-quirk .children > li.active > a { font-weight: 600; border-left: 3px solid var(--kuning); }

  /* PANEL / CARD */
  .panel { border: 1px solid var(--border-soft) !important; border-radius: 12px !important; box-shadow: 0 2px 14px rgba(26,79,160,.06) !important; overflow: hidden; }
  .panel-default > .panel-heading,
  .panel-heading { background: var(--biru) !important; color: #fff !important; border-radius: 0 !important; font-weight: 600; letter-spacing: .2px; }
  .panel-primary > .panel-heading { background: var(--biru) !important; border-color: var(--biru) !important; }
  .panel-primary { border-color: var(--border-soft) !important; }
  .panel-body { background: #fff; }

  .panel-announcement { background: linear-gradient(135deg, var(--biru), var(--biru-tua)) !important; color: #fff; border-radius: 12px !important; }
  .panel-announcement h2, .panel-announcement h4 { color: #fff !important; }

  /* TOMBOL */
  .btn-primary { background: var(--biru) !important; border-color: var(--biru) !important; }
  .btn-primary:hover { background: var(--biru-tua) !important; border-color: var(--biru-tua) !important; }
  .btn-success { background: #1a8a4a !important; border-color: #1a8a4a !important; }
  .btn-warning { background: var(--kuning) !important; border-color: var(--kuning) !important; color: #1a2a40 !important; font-weight: 600; }
  .btn-warning:hover { background: var(--kuning-tua) !important; border-color: var(--kuning-tua) !important; }
  .btn-danger { background: #c0392b !important; border-color: #c0392b !important; }

  /* TABEL */
  .table thead { background: #eef4ff; }
  .table thead th { color: var(--teks-judul) !important; border-bottom: 2px solid var(--border-soft) !important; font-size: 12.5px; text-transform: uppercase; letter-spacing: .3px; }
  .table tbody tr:hover { background: #f7faff !important; }

  /* LABEL */
  .label-primary { background: var(--biru) !important; }
  .label-info { background: #2196d8 !important; }
  .label-warning { background: var(--kuning) !important; color: #1a2a40 !important; }

  /* FORM */
  .form-control:focus { border-color: var(--biru) !important; box-shadow: 0 0 0 3px rgba(26,79,160,.12) !important; }

  /* BREADCRUMB */
  .breadcrumb { background: #fff; border: 1px solid var(--border-soft); border-radius: 8px; }
  .breadcrumb > li + li::before { color: var(--teks-muted); }
  .breadcrumb a { color: var(--biru); }

  /* CONTENTPANEL FOOTER */
  .contentpanel .panel-primary .panel-body { background: #fff !important; color: var(--teks-muted); font-size: 12px; text-align: center; }

  /* ================= ICON MONOKROM — samakan semua warna ikon dengan tema ================= */
  i.fa, .fa { color: inherit !important; }

  /* Sidebar: ikon mengikuti warna teks link induknya */
  .nav-quirk > li > a i.fa { color: var(--teks-judul) !important; opacity: .65; width: 18px; text-align: center; }
  .nav-quirk > li > a:hover i.fa { color: var(--biru) !important; opacity: 1; }
  .nav-quirk > li.active > a i.fa,
  .nav-quirk > li.nav-parent.active > a i.fa { color: #fff !important; opacity: 1; }
  .nav-quirk .children > li > a i.fa { color: var(--teks-muted) !important; opacity: .7; }
  .nav-quirk .children > li.active > a i.fa,
  .nav-quirk .children > li > a:hover i.fa { color: var(--biru) !important; opacity: 1; }

  /* Header atas & profil */
  .headerbar i.fa, .leftpanel-profile i.fa { color: var(--teks-judul) !important; }
  .nav-sidebar i.fa { color: rgba(255,255,255,.85) !important; }

  /* Tombol — ikon ikut warna teks tombol (putih di tombol solid) */
  .btn i.fa { color: inherit !important; }
  .btn-warning i.fa { color: #1a2a40 !important; }

  /* Tabel aksi & label — ikon netral */
  .table i.fa { color: inherit !important; }
  .label i.fa { color: inherit !important; }

  /* Breadcrumb & info text */
  .breadcrumb i.fa, .text-muted i.fa { color: var(--teks-muted) !important; }

  /* Alert box — ikon ikut warna teks alert (jangan dipaksa biru) */
  .alert i.fa { color: inherit !important; }
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

            <!-- <li class="nav-parent"><a href=""><i class="fa fa-th-list"></i> <span>Absensi</span></a>
              <ul class="children">
                <li <?php if ($url == 'input-absen') { echo "class='active'"; } ?>><a href="{{ url('/input-absen') }}">Input Absen</a></li>
                <li <?php if ($url == 'rekap-absen') { echo "class='active'"; } ?>><a href="{{ url('/rekap-absen') }}">Rekap Absen</a></li>
              </ul>
            </li> -->

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
