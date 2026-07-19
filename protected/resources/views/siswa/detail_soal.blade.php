<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="stylesheet" href="{{ url('/assets/assets/libs/countdown/css/jquery.countdown.css') }}">
<link rel="stylesheet" href="{{ url('/assets/examples/css/sweetalert.min.css') }}">
<style type="text/css">
  #defaultCountdown { width: 240px; height: 57px; }
  .pagination { background: #fff; color: #000 !important; }

  .page {
    display: inline-block;
    padding: 0px 9px;
    margin: 8px 4px 0 0;
    border-radius: 3px;
    border: solid 1px #c0c0c0;
    background: #e9e9e9;
    box-shadow: inset 0px 1px 0px rgba(255,255,255, .8), 0px 1px 3px rgba(0,0,0, .1);
    font-size: .875em;
    font-weight: bold;
    text-decoration: none;
    color: #717171;
    text-shadow: 0px 1px 0px rgba(255,255,255, 1);
  }

  .page:hover, .page.gradient:hover {
    background: #fefefe;
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#FEFEFE), to(#f0f0f0));
    background: -moz-linear-gradient(0% 0% 270deg,#FEFEFE, #f0f0f0);
  }

  .page.active {
    border: none;
    background: #616161;
    box-shadow: inset 0px 0px 8px rgba(0,0,0, .5), 0px 1px 0px rgba(255,255,255, .8);
    color: #f0f0f0;
    text-shadow: 0px 0px 3px rgba(0,0,0, .5);
  }

  .page.gradient {
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#f8f8f8), to(#e9e9e9));
    background: -moz-linear-gradient(0% 0% 270deg,#f8f8f8, #e9e9e9);
  }

  .benar{
    padding: 15px;
    background: #045ff2;
    color: #fff;
  }
  input[type=radio]{
    margin-top: 5px;
  }

  .essay-wrap { margin-top:14px; padding:16px; background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:10px; }
  .essay-label { font-size:12px; font-weight:600; color:#475569; margin-bottom:8px; display:block; }
  .essay-textarea { width:100%; min-height:140px; padding:10px 13px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:13px; color:#1e293b; font-family:inherit; resize:vertical; }
  .essay-saved { font-size:11.5px; color:#059669; margin-top:6px; display:none; }
  .essay-bobot { display:inline-block; background:#fef3c7; color:#d97706; border-radius:6px; padding:3px 10px; font-size:11px; font-weight:700; margin-top:10px; }
</style>
@extends('layouts/siswa_baru')
@section('title', 'Detail Soal')
@section('breadcrumb')
  <li><a href="{{ url('/siswa') }}">Home</a></li>
  <li><a href="{{ url('/soal-siswa') }}">Soal Ujian</a></li>
  <li class="active">Detail Soal</li>
@endsection
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header bg-white">
      <div class="media">
        <div class="media-body">
          <h4 class="card-title">Detail Soal</h4>
          <p class="card-subtitle"></p>
        </div>
      </div>
    </div>
    <div style="padding: 15px">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td style="width: 110px">Paket Soal</td>
            <td style="width: 15px">:</td>
            <td>{{ $soal->paket }}</td>
          </tr>
          <tr>
            <td>Deskripsi</td>
            <td>:</td>
            <td>{{ $soal->deskripsi }}</td>
          </tr>
          <tr>
            <td>Jumlah</td>
            <td>:</td>
            <td>{{ $jumlah_soal->count() }} soal</td>
          </tr>
          <tr>
            <td>KKM</td>
            <td>:</td>
            <td>{{ $soal->kkm }}</td>
          </tr>
          <tr>
            <td>Waktu</td>
            <td>:</td>
            <td>
	     <?php
                echo $jumlah_menis = $soal->waktu/60;
                echo " menit";
                if($countexamtime == "" || $countexamtime->waktu_selesai == null){
                  $sisa_detik_awal = $soal->waktu;
                  $jam = floor($sisa_detik_awal/3600);
                  $menit = floor(($sisa_detik_awal % 3600) / 60);
                  $detik = $sisa_detik_awal % 60;
                }else{
                  $sisa_detik_awal = max(0, \Carbon\Carbon::now()->diffInSeconds(\Carbon\Carbon::parse($countexamtime->waktu_selesai), false));
                  echo ', sisa waktu Anda : '.floor($sisa_detik_awal/60);
                  echo " menit";
                  $jam = floor($sisa_detik_awal/3600);
                  $menit = floor(($sisa_detik_awal % 3600) / 60);
                  $detik = $sisa_detik_awal % 60;
                }
              ?>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="alert alert-info">
        <p style="font-size:18px; margin-bottom:10px;">Sebelum mulai mengerjakan, baca dan ikuti instruksi dibawah ini:</p>
        <ul>
          <li><b style="color: #F00;">Jangan</b> <i>refresh</i> halaman Anda.</li>
          <li>Selalu perhatikan waktu ujian, karena sistem akan mengirimkan jawaban secara otomatis saat waktu ujian telah habis.</li>
          <li>Pastikan Anda siap melakukan ujian, karena saat klik tombol <b>"Mulai Ujian"</b> waktu akan berjalan dan tidak bisa dihentikan walaupun server mengalami gangguan.</li>
          <li>Ikutilah petunjuk dari Bpk/Ibu Guru.</li>
        </ul>
        <hr>
        <p class="center"><b>GOOD LUCK</b></p>
      </div>
      <input type="button" value="Mulai Ujian" id="trigger_soal" class="btn btn-primary btn-lg">
    </div>
  </div>
</div>

@endsection

<script src="{{ url('/assets/assets/vendor/jquery.min.js') }}"></script>
<script src="{{ url('/assets/assets/libs/countdown/js/jquery.plugin.min.js') }}"></script>
<script src="{{ url('/assets/assets/libs/countdown/js/jquery.countdown.js') }}"></script>
<script src="{{ url('/assets/assets/vendor/sweetalert.min.js') }}"></script>


<div id="wrap_soal" style="display: none; background: #f2f7ff; height: 100%; width: 100%; padding: 0; margin: 0; overflow-y: scroll;">
  <div class="container" style="margin: 50px auto 0 auto; padding: 15px; background: #fff; text-align: center" id="wrap-siap-ujian">
    <p>Dengan mengklik tombol "Siap Ujian", waktu ujian akan mulai berjalan. Sistem akan mengirim jawaban Anda saat waktu telah selesai walaupun Anda tidak mengklik Kirim Jawaban.</p>
    <input type="button" id="siap-ujian" value="Siap Ujian" class="btn btn-success">
    <a type="button" href="{{ url('/soal-siswa/'.$soal->id) }}" class="btn btn-danger">Batal</a>
  </div>
  <div class="container-fluid hidden-sm hidden-xs wrap_ujian" style="display: none;">
    <div class="row">
      <div class="col-md-12" style="background: #003284; padding:10px;">
        <div class="row">
          <div class="col-md-6" style="color: #fff;">
            Hai {{ $user->nama }}, Selamat mengerjakan Soal {{ $soal->paket }}
          </div>
          <div class="col-md-6">
            
          </div>
        </div>
      </div>
    </div>
  </div>
  <input type="hidden" name="id_soal{{ $detailsoal->id }}" id="id_soal{{ $detailsoal->id }}" value="{{ $detailsoal->id_soal }}">
  <div class="container wrap_ujian" style="display: none;">
    <div style="height: 15px"></div>
    <div class="row">
      <div class="col-md-8 col-sm-12" style="border:solid thin #e3e9f2; background: #fff; padding:10px" id="wrap-soal">
        <table class="table table-condensed" style="padding:0; margin: 0">
          <tbody>
            <tr>
              <input type="hidden" name="id_soaljawab" id="id_soaljawab" value="{{ $detailsoal->id_soal }}">
              <input type="hidden" name="no_soal_id{{ $detailsoal->id }}" id="no_soal_id{{ $detailsoal->id }}" value="{{ $detailsoal->id }}">

              <!-- <td style="width: 15px">1</td> -->
              <td colspan="2">
                <?php if($detailsoal->audio != ""){ $audio = $detailsoal->audio; ?>
                  <div style="margin: 0 0 20px 0; padding: 15px; border: solid thin #a8a8a8;">
                    <span style="color: #828282">Audio for Listening</span><hr style="margin: 8px 0 15px 0">
                    <div class="clearfix"></div>
                    <p>
                      <audio controls>
                      <source src="{{ url('/assets/audios/'.$audio) }}" type="audio/mpeg">
                      Your browser does not support the audio element.
                    </audio>
                    </p>
                  </div>
                <?php } ?>
                {!! $detailsoal->soal !!}
              </td>
            </tr>
@if($detailsoal->tipe == 'essay')
            <tr>
              <td colspan="2">
                <div class="essay-wrap">
                  <label class="essay-label">✏️ Tulis jawaban kamu di bawah ini:</label>
                  <textarea
                    class="essay-textarea"
                    id="essay_jawab{{ $detailsoal->id }}"
                    placeholder="Ketik jawaban kamu di sini..."
                  ></textarea>
                  <div class="essay-saved" id="essay_saved{{ $detailsoal->id }}">✅ Jawaban tersimpan otomatis</div>
                  <div class="essay-bobot">📊 Bobot: {{ $detailsoal->bobot }} poin</div>
                </div>
              </td>
            </tr>
            <script>
              $(document).ready(function(){
                var essayTimer{{ $detailsoal->id }};
                $("#essay_jawab{{ $detailsoal->id }}").on('input', function(){
                  clearTimeout(essayTimer{{ $detailsoal->id }});
                  var textarea = $(this);
                  essayTimer{{ $detailsoal->id }} = setTimeout(function(){
                    var jawaban    = textarea.val();
                    var id_soal    = "{{ $detailsoal->id_soal }}";
                    var no_soal_id = $("#no_soal_id{{ $detailsoal->id }}").val();
                    $.ajax({
                      type: "POST",
                      url: "{!! url('simpan-jawaban-essay') !!}",
                      data: { jawaban_essay: jawaban, id_soal: id_soal, no_soal_id: no_soal_id },
                      success: function(res){
                        if (res === 'ok') {
                          $("#essay_saved{{ $detailsoal->id }}").fadeIn(200).delay(2000).fadeOut(400);
                          $("#get-soal{{ $detailsoal->id }}").removeClass('page gradient').addClass('page active');
                        }
                      }
                    });
                  }, 1500);
                });
              });
            </script>
@else
            <tr id="wrap_pil_a">
              <td style="width: 10px"><input type="radio" name="pilih{{ $detailsoal->id }}" value="A" data-toggle='tooltip' title="Klik untuk menjawab."></td>
              <td>{!! $detailsoal->pila !!}</td>
            </tr>
            <tr id="wrap_pil_b">
              <td><input type="radio" name="pilih{{ $detailsoal->id }}" value="B" data-toggle='tooltip' title="Klik untuk menjawab."></td>
              <td>{!! $detailsoal->pilb !!} </td>
            </tr>
            <tr id="wrap_pil_c">
              <td><input type="radio" name="pilih{{ $detailsoal->id }}" value="C" data-toggle='tooltip' title="Klik untuk menjawab."></td>
              <td>{!! $detailsoal->pilc !!} </td>
            </tr>
            <tr id="wrap_pil_d">
              <td><input type="radio" name="pilih{{ $detailsoal->id }}" value="D" data-toggle='tooltip' title="Klik untuk menjawab."></td>
              <td>{!! $detailsoal->pild !!} </td>
            </tr>
            <tr id="wrap_pil_e">
              <td><input type="radio" name="pilih{{ $detailsoal->id }}" value="E" data-toggle='tooltip' title="Klik untuk menjawab."></td>
              <td>{!! $detailsoal->pile !!} </td>
            </tr>
            <script>
              $(document).ready(function(){
                $("input[name=pilih{{ $detailsoal->id }}]").click(function(){
                  var pilihan = $("input[name=pilih{{ $detailsoal->id }}]:checked").val();
                  var id_soal = $("#id_soal{{ $detailsoal->id }}").val();
                  var no_soal_id = $("#no_soal_id{{ $detailsoal->id }}").val();
                  var id_user = $("#id_user{{ $detailsoal->id }}").val();
                  var datastring = "pilihan="+pilihan+"&id_soal="+id_soal+"&no_soal_id="+no_soal_id+"&id_user="+id_user;
                  $.ajax({
                    type: "POST",
                    url: "{!! url('simpanjawabankliksiswa') !!}",
                    data: datastring,
                    success: function(data){
                      if (data == 'A') {
                        $("#wrap_pil_b,#wrap_pil_c,#wrap_pil_d,#wrap_pil_e").removeClass('benar');
                        $("#wrap_pil_a").addClass('benar');
                      }else if(data == 'B'){
                        $("#wrap_pil_a,#wrap_pil_c,#wrap_pil_d,#wrap_pil_e").removeClass('benar');
                        $("#wrap_pil_b").addClass('benar');
                      }else if(data == 'C'){
                        $("#wrap_pil_a,#wrap_pil_b,#wrap_pil_d,#wrap_pil_e").removeClass('benar');
                        $("#wrap_pil_c").addClass('benar');
                      }else if(data == 'D'){
                        $("#wrap_pil_a,#wrap_pil_b,#wrap_pil_c,#wrap_pil_e").removeClass('benar');
                        $("#wrap_pil_d").addClass('benar');
                      }else if(data == 'E'){
                        $("#wrap_pil_a,#wrap_pil_b,#wrap_pil_c,#wrap_pil_d").removeClass('benar');
                        $("#wrap_pil_e").addClass('benar');
                      }
                      $("#get-soal{{ $detailsoal->id }}").removeClass('page gradient').addClass('page active');
                    }
                  })
                });
              });
            </script>
@endif
          </tbody>
        </table>
      </div>
      <div class="row col-md-4 col-sm-12" style="padding: 0 10px">
        <div class="card">
          <div class="card-header bg-white">
            <div class="media">
              <div class="media-body">
                <h4 class="card-title">
                  <div style="margin: 0 auto;" id="defaultCountdown"></div>
                </h4>
              </div>
            </div>
          </div>

          <div class="card-header bg-white">
            <div class="media">
              <div class="media-body">
                <h4 class="card-title">
                  Nomor Soal
                </h4>
              </div>
            </div>
          </div>
          <div style="padding: 0 15px">
            <ul class="pagination">
              <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
              <?php $no = 1; ?>
              @if($soals->count())
              @foreach($soals as $data)
                <input type="hidden" id="id{{ $data->id }}" value="{{ $data->id }}">
                <a href="#" style="text-decoration: none;" class="page gradient" id="get-soal{{ $data->id }}">{{ $no++ }}</a>
                <script>
                  jQuery.noConflict()(function ($) {
                    $(document).ready(function(){
                      $("#get-soal{{ $data->id }}").click(function(){
                        var id = $("#id{{ $data->id }}").val();
                        $.ajax({
                          type: "POST",
                          url: "{{ url('/get-soal/'.$data->id) }}",
                          data: 'id='+id,
                          success: function(data){
                            $("#wrap-soal").hide().html(data).fadeIn(350);
                          }
                        })
                      });
                    });
                  });
                </script>
              @endforeach
              @endif
            </ul>
            <hr>
            <input type="button" id="kirim" value="Akhiri Ujian" class="btn btn-primary" style="float: right">
            <br style="clear: both;">
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
jQuery.noConflict()(function ($) {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  


  $(document).ready(function(){
    var sudahSubmit = false; // biar tidak double-submit

    $("#siap-ujian").click(function(){
      $("#wrap-siap-ujian").hide();
      $(".wrap_ujian").fadeIn(250);
      $('#defaultCountdown').countdown({until: '+{{ $jam }}h +{{ $menit }}m +{{ $detik }}s', format: 'HMS', onExpiry: liftOff});

      // cek sisa waktu ke server tiap 5 detik (berbasis timestamp, tetap akurat walau tab ditinggal)
      function cekWaktuServer(){
        if (sudahSubmit) return;
        var id_soal = $("#id_soal{{ $detailsoal->id }}").val();
        $.ajax({
          url: "{{ url('/countexamtime') }}",
          type: 'POST',
          data: 'id_soal='+id_soal,
          dataType: 'json',
          success: function(data){
            if (data.status === 'habis') {
              kirimJawaban(true); // waktu sudah habis di server -> paksa submit
            }
          }
        });
      }
      setInterval(cekWaktuServer, 5000);

      // begitu tab aktif lagi (misal siswa balik dari tab lain), langsung cek ulang
      function kirimLogPelanggaran(jenis){
        var id_soal = $("#id_soal{{ $detailsoal->id }}").val();
        $.ajax({
          url: "{{ url('/log-pelanggaran') }}",
          type: 'POST',
          data: 'id_soal='+id_soal+'&jenis='+jenis
        });
      }

      // begitu tab aktif lagi (misal siswa balik dari tab lain), langsung cek ulang
      document.addEventListener('visibilitychange', function(){
        if (document.hidden) {
          kirimLogPelanggaran('keluar_tab');
        } else {
          cekWaktuServer();
        }
      });
    });

    function liftOff() {
      kirimJawaban(true);
    }

    var elem = document.getElementById("wrap_soal");
    var btnelem = document.getElementById("trigger_soal");

    btnelem.onclick = function() {
    $("#wrap_soal").show();
      req = elem.requestFullScreen || elem.webkitRequestFullScreen || elem.mozRequestFullScreen;
      req.call(elem);
    }
   
    $(document).on('webkitfullscreenchange mozfullscreenchange fullscreenchange', function(e){
      $("#wrap_soal").show();
      var isFullscreen = document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement;
      if (!isFullscreen && $(".wrap_ujian").is(':visible')) {
        kirimLogPelanggaran('keluar_fullscreen');
      }
    });

    function kirimJawaban(otomatis){
      if (sudahSubmit) return;
      if (!otomatis) {
        if (!confirm('Yakin jawaban akan dikirim?')) return false;
      } else {
        alert('Waktu ujian telah selesai. Jawaban Anda akan dikirimkan secara otomatis.');
      }
      sudahSubmit = true;
      var id_soal = $("#id_soal{{ $detailsoal->id }}").val();
      $.ajax({
        url: "{{ url('/kirimjawaban') }}",
        type: 'POST',
        data: 'id_soal='+id_soal,
        success: function(data){
          window.location.href = "{{ url('/siswa') }}";
          // console.log(data);
        }
      })
    }

    $("#kirim").click(function(){
      kirimJawaban(false);
    });
  });
});
</script>
