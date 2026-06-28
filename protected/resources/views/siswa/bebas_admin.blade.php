@extends('layouts/siswa_disabled')
@section('title', 'Profil')
@section('breadcrumb')
  <li><a href="{{ url('/siswa') }}">Home</a></li>
  <li class="active">Non Aktif</li>
@endsection
@section('content')

<div class="col-md-6">
    <div class="card">
        
        <div style="padding: 5px">
           
		<p>Akun ini Non Aktif. <br><br>Segera hubungi Tata Usaha untuk menyelesaikan administrasi sekolah anda. </p>
            </div>
        </div>
    </div>
</div>

@endsection
