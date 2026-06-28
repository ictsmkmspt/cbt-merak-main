@extends('layouts/guru_baru')
@section('title', 'Selamat datang di aplikasi ujian berbasis komputer.')
@section('content')
<?php
  include(app_path().'/functions/koneksi.php');
  $sapaan = Auth::user()->jk;
  if ($sapaan == "L") {
    $sapaan = "Pak";
  }else{
    $sapaan = "Ibu";
  }
?>
<div class="col-sm-12 col-md-8 col-lg-8 dash-left">
  <ol class="breadcrumb">
    <li><a href="{{ url('/guru') }}">Home</a></li>
    <li class="active">Anda berada di halaman depan</li>
  </ol>
  <div class="panel panel-announcement">
    <ul class="panel-options">
      <li><a class="panel-remove"><i class="fa fa-remove"></i></a></li>
    </ul>
    <div class="panel-body">
      <h2>Assalamu'alaikum warahmatullahi wabarakatuh {{ $sapaan." ".Auth::user()->nama }} <br>di halaman Guru <span class="text-primary">Aplikasi Ujian Berbasis Komputer</span>.</h2>
      <h4>Silahkan kelola seluruh menu yang ada disini. Setiap aktifitas Anda akan selalu tercatat oleh sistem.</a></h4>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" style="background: #072047; color: #fff"> Selamat Datang di Aplikasi Ujian Berbasis Komputer <b>{{ $school->nama }}</b> </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-4 col-md-4">
          <?php if ($user->gambar == "") { ?>
            <img src="img/noimage.jpg" alt="foto guru" class="img-rounded img-responsive" />
          <?php }else{ ?>
            <img src="img/{{$user->gambar}}" alt="{{$user->gambar}}" class="img-rounded img-responsive" />
          <?php } ?>
        </div>
        <div class="col-sm-8 col-md-8">
          <blockquote>
            <p>{{ $user->nama }}</p>
            <small><cite title="Source Title">{{ $user->no_induk }}</cite></small> </blockquote>
            <p><i class="fa fa-envelope-o"></i> {{ $user->email }} <br/>
            <i class="fa fa-venus-mars"></i>
            <?php if($user->jk == "L"){echo "Laki-laki";}else{echo "Perempuan";} ?></p>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="col-sm-12 col-md-4 col-lg-4 dash-right">
  <div class="panel panel-danger">
    <div class="panel-heading">
      <h4 class="panel-title">Konfigurasi Admin CBT</h4>
    </div>
    <div class="panel-body">
      <div class="panel-title">
        <h4>PERATURAN BEBAS ADMIN CBT</h4>        
      </div>
      <div id="bgstatus" style="float:left" class="panel-footer">
        @if($school->bypass_ujian == 0) <h5>Status: Perbolehkan Ujian</h5>
        @else <h5>Status: Suspended Ujian</h5>
        @endif
      </div>
      
      <div style="float:right; padding-top:16px" class="col-2-2">
        <button id="btnReset" type="button"
          class="btn btn-primary"
          data-toggle="collapse" data-placement="right" title="Reset Filter Pencarian"
          onclick="window.location='{{ url("bebasadmin-toggle") }}'">
          <i class="fa fa-lock" aria-hidden="true"></i> Bypass Status
        </button>
      </div>
    </div>
  </div>

  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">Aktifitas Terkini</h4>
    </div>
    <div class="panel-body">
      <ul class="media-list user-list">
      @if($aktifitas->count())
      @foreach($aktifitas as $data)
      <?php
        $tanggal_aktifitas = explode(" ", $data->created_at);
        $tanggal_aktifitas = explode("-", $tanggal_aktifitas[0]);
        $tanggal_aktifitas = $tanggal_aktifitas[2].' '.$bulanpendek[$tanggal_aktifitas[1]].' '.$tanggal_aktifitas[0];
        if ($data->gambar != "") {
          $gambar_aktifitas = $data->gambar;
        }else{
          $gambar_aktifitas = 'noimage.jpg';
        }
      ?>
        <li class="media">
          <div class="media-left">
            <a href="#">
              <img class="media-object img-thumbnail" src="{{ url('img/'.$gambar_aktifitas) }}" alt="">
            </a>
          </div>
          <div class="media-body">
            <h4 class="media-heading nomargin"><a href="#">{{ $data->nama_user }}</a></h4>
            {{ $data->nama }}
            <small class="date"><i class="fa fa-clock-o"></i> {{ $tanggal_aktifitas }}</small>
          </div>
        </li>
      @endforeach
      @endif
      </ul>
      <a href="{{ url('/aktifitas') }}" class="btn btn-success" style="display: block; width: 100%; margin: 10px 0 0 0">Selengkapnya</a>
    </div>
  </div>
</div>
@endsection