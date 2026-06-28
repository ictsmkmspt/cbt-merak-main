@extends('layouts/siswa_baru')
@section('title', 'Selamat datang')
@section('breadcrumb')
  <li><a href="{{ url('/siswa') }}">Home</a></li>
  <li class="active">Anda berada di Home</li>
@endsection
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/606d1db1f7ce18270937c696/1f2l3o04s';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header bg-white">
      <div class="media">
        <div class="media-body">
          <h4 class="card-title">Selamat Datang</h4>
        </div>
      </div>
    </div>
    <div style="padding: 15px">
      Assalamu'alaikum  <b>{{ Auth::user()->nama }}</b>. <br><br>Aplikasi ujian ini dirancang untuk memudahkan proses ujian. <br>Ikutilah instruksi Guru untuk mengoperasikan aplikasi ini dengan benar.
    </div>
  </div>
</div>
@endsection