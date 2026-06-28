
@extends('layouts/welcome')
@section('content')
<!-- <style type="text/css" media="screen">
  body{
    color: #fff;
  }
</style> -->

<link rel="icon" href="{{ ('img/favicon.png') }}">
<hr class="prettyline">
<div class="android-content mdl-layout__content" style="background-color:#f1f1f1;">
<div class="bungkuslogin" style="background-color:rgba(0, 0, 0, 0.75); color:#d5d9e2; padding:15px;">
    <center>
    <?php
        include(app_path() . '/functions/koneksi.php');
        $conn = new mysqli($hostdb, $userdb, $passdb, $namedb);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM schools";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $namasekolah = $row["nama"];
                $logosekolah = $row['logo'];
            }
        } else {
            $namasekolah = "";
        }
        $conn->close();
    ?>
    <h3>Merak Computer Based Test</h3>
    <h2><b>{{ $namasekolah }}</b></h2>
    <h3>Silahkan Login untuk mengakses halaman Aplikasi Ujian</h3>
    <em>Developing & Progress by: <a href="#" target="blank" title="ict@smkmuhsampit.sch.id" style="color: #97b5fc;">ICT smkmuhsampit</a></em>
    <br>
    <a href="{{ url('/') }}"><button type="button" class="btn btn-success btn-lg" data-toggle="tooltip" title="Kembali kehalaman depan"><span class="glyphicon glyphicon-home"></span> Home</button></a>
    <button class="btn btn-primary btn-lg" href="#signup" data-toggle="modal" data-target=".bs-modal-sm" style="margin: 15px 0 15px 0;" id="logtooltip" title="Login ke halaman Anda"><span class="glyphicon glyphicon-lock"></span> Login</button>
    <br><em>version <b><?php echo(config('app.version')) ?></b></em>
    </center>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
</div>

<hr class="prettyline">

<?php
    /*}else{
      echo "selamat datang";
    }*/
  ?>
@endsection