@extends('layouts/siswa_baru')
@section('title', 'Latihan')
@section('breadcrumb')
  <li><a href="{{ url('/siswa') }}">Home</a></li>
  <li class="active">Latihan</li>
@endsection
@section('content')
@if(session('info_latihan'))
  <div class="alert alert-info alert-dismissible" role="alert" style="margin-bottom: 20px;">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ session('info_latihan') }}
  </div>
@endif
<div class="row">
  @if($materis->count())
  @foreach($materis as $materi)
  <div class="col-md-6 col-sm-12" style="margin-bottom: 20px;">
    <div class="card" style="height: 100%;">
      <div class="card-header bg-white center">
        <h4 class="card-title"><a href="{{ url('/latihan/read/'.$materi->id.'/'.str_slug($materi->judul)) }}">{{ $materi->judul }}</a></h4>
      </div>
      <a href="take-course.html">
      <?php if ($materi->gambar != "") { ?>
        <div style="overflow: hidden; height: 150px">
          <img src="{{ url('/img/materi/'.$materi->gambar) }}" alt="img">
        </div>
      <?php } ?>
      </a>
      <div class="card-block">
        <p class="m-b-0">
          <?php
            $isi = str_replace('<div', '<p', $materi->isi);
            $isi = str_replace('</div', '</p', $isi);
            $isi = substr($materi->isi, 0, 180);
            echo $isi;
          ?>
        </p>
        <p><span class="label label-primary"></span></p>
      </div>
    </div>
  </div>
  @endforeach
  @endif
</div>
@endsection
