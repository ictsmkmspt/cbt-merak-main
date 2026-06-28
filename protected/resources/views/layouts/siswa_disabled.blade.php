<!DOCTYPE html>
<html class="bootstrap-layout">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>@yield('title')</title>

<!-- Prevent the demo from appearing in search engines (REMOVE THIS) -->
<meta name="robots" content="noindex">

<!-- Material Design Icons  -->
<!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
<link href="{{ url('/assets/assets/css/googlefont.css') }}" rel="stylesheet">

<!-- Roboto Web Font -->
<!-- <link href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en" rel="stylesheet"> -->

<!-- App CSS -->
<link type="text/css" href="{{ url('/assets/assets/libs/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
<link type="text/css" href="{{ url('/assets/assets/css/style.min.css') }}" rel="stylesheet">
</head>

<body class="layout-container ls-top-navbar si-l3-md-up" onkeydown="return (event.keyCode != 116)">
<script type = "text/javascript">  
  window.onload = function () {  
    document.onkeydown = function (e) {  
      return (e.which || e.keyCode) != 116;  
    };  
  }  
</script>
<!-- Navbar -->
<nav style="background: red !important" class="navbar navbar-dark bg-primary navbar-full navbar-fixed-top"> 
  
  <!-- Toggle sidebar -->
  <button class="navbar-toggler pull-xs-left" type="button" data-toggle="sidebar" data-target="#sidebarLeft"><i class="fa fa-bars" aria-hidden="true"></i></button>
  
  <!-- Brand --> 
  <a href="{{ url('/siswa') }}" class="navbar-brand"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Non Aktif</a> 
  
  <!-- Search -->
  <!-- <form class="form-inline pull-xs-left hidden-sm-down">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Search">
      <span class="input-group-btn">
      <button class="btn" type="button"><i class="material-icons">search</i></button>
      </span> </div>
  </form> -->
  <!-- // END Search -->
  
  <ul class="nav navbar-nav hidden-sm-down">
    
    <!-- Menu -->
    <!-- <li class="nav-item"> <a class="nav-link" href="forum.html">Forum</a> </li>
    <li class="nav-item"> <a class="nav-link" href="get-help.html">Get Help</a> </li> -->
  </ul>
  <?php
    if (Auth::user()->gambar != "") {
      $foto = Auth::user()->gambar;
    }else{
      $foto = 'siswa.png';
    }
  ?>
  <!-- Menu -->
  <ul class="nav navbar-nav pull-xs-right">
    <!-- User dropdown -->
    <li class="nav-item dropdown"> <a class="nav-link active dropdown-toggle p-a-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"> <img src="{{ url('/img/'.$foto) }}" alt="Avatar" class="img-circle" width="40"> </a>
      <div class="dropdown-menu dropdown-menu-right dropdown-menu-list" aria-labelledby="Preview">
        <a class="dropdown-item" href="{{ url('/profil-siswa') }}"><i class="fa fa-user-circle" aria-hidden="true"></i> <span class="icon-text">Profile</span></a> <a class="dropdown-item" href="{{ url('/auth/logout') }}">Logout</a> </div>
    </li>
    <!-- // END User dropdown -->
    
  </ul>
  <!-- // END Menu --> 
  
</nav>
<!-- // END Navbar --> 
<!-- Sidebar -->
<?php
  $url = Request::segment(1);
?>
<div style="background: #fff !important" class="sidebar sidebar-left sidebar-light sidebar-visible-md-up si-si-3 ls-top-navbar-xs-up sidebar-transparent-md" id="sidebarLeft" data-scrollable>
  <div class="sidebar-heading">Navigasi</div>
  <ul class="sidebar-menu">
    <li <?php if ($url == "siswa") { echo "class='sidebar-menu-item active'"; } ?>> <a class="sidebar-menu-button" href="{{ url('/siswa') }}"> <i class="sidebar-menu-icon fa fa-home" aria-hidden="true"></i> Home </a> </li>
    <li class="sidebar-menu-item"> <a class="sidebar-menu-button" href="{{ url('/auth/logout') }}"> <i class="sidebar-menu-icon fa fa-sign-out" aria-hidden="true"></i> Logout </a> </li>
  </ul>
  <p class="text-danger">version: <?php echo(config('app.version')) ?></p>
  <!-- // END Components Menu --> 
</div>
<!-- // END Sidebar --> 

<!-- Content -->
<div class="layout-content" data-scrollable>
  <div class="container-fluid">
    <ol class="breadcrumb">
      @yield('breadcrumb')
    </ol>
    <div class="row">
      @yield('content')
    </div>
    <div class="row">
      <div class="col-md-12" style="color: #b3bfd1; font-size:12px">
        <hr>
        Copyright &copy; 2016-2017 Tipamedia. <br><br>Has been modified and develop by Merak ICT Team for SMK Muhammadiyah Sampit (internal use only). <br>All copyright belong to Tipamedia.
      </div>
    </div>
  </div>
</div>

<!-- jQuery --> 
<script src="{{ url('/assets/assets/vendor/jquery.min.js') }}"></script>

<!-- Bootstrap --> 
<script src="{{ url('/assets/assets/vendor/tether.min.js') }}"></script>
<script src="{{ url('/assets/assets/vendor/bootstrap.min.js') }}"></script>
<!-- AdminPlus --> 
<script src="{{ url('/assets/assets/vendor/adminplus.js') }}"></script>

<!-- App JS --> 
<script src="{{ url('/assets/assets/js/main.min.js') }}"></script>

<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
</script>
</body>
</html>