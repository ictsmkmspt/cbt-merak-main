@extends('layouts/siswa_baru')
@section('title', 'Detail Soal')
@section('breadcrumb')
  <li><a href="{{ url('/siswa') }}">Home</a></li>
  <li><a href="{{ url('/soal-siswa') }}">Soal Ujian</a></li>
  <li class="active">Detail Soal</li>
@endsection
@section('content')

<div class="col-md-6">
    <div class="card">
        <div class="card-header bg-white">
            <div class="media">
                <div class="media-body">
                    <button type="button" id="btnmulai" class="btn btn-primary btn-lg" data-toggle="collapse" data-target="#tayo">403</button>
                </div>
            </div>
        </div>
        <div style="padding: 5px">
            <div id="tayo" class="collapse">
		<p>Forbidden access</p>
            </div>
        </div>
    </div>
</div>

@endsection
