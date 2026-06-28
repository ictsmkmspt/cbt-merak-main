@extends('layouts/guru_baru')
@section('title', 'Duplicate soal')
@section('content')
<script src="{{ url('/assets/assets/vendor/jquery.min.js') }}"></script>
<?php
  include(app_path().'/functions/koneksi.php');
  $sapaan = Auth::user()->jk;
  if ($sapaan == "L") {
    $sapaan = "Pak";
  }else{
    $sapaan = "Ibu";
  }
?>
<div class="col-md-12 dash-left">
  <ol class="breadcrumb">
    <li><a href="{{ url('/guru') }}">Home</a></li>
    <li><a href="{{ url('/soal-guru') }}">Soal</a></li>
    <li class="active">Duplicate Soal</li>
  </ol>
  <div class="panel panel-default">
    <div class="panel-heading" style="background: #072047; color: #fff"> Selamat Datang di Aplikasi Ujian Berbasis Komputer <b>{{ $school->nama }}</b> </div>
    <div class="panel panel-default">
      <div class="panel-heading">Duplicate Paket Soal</div>
      <div class="panel-body">
        <div class="well" style="margin: 0; padding: 15px"> {!! Form::open(['url' => 'simpansiswa', 'class' => 'form-horizontal']) !!}
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id_soal" id="id_soal" value="{{ $soal->id }}">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Paket</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="paket" id="paket" placeholder="Paket soal, misal: UTS KKPI Kelas XI" value="Copy of {!! $soal->paket !!}">
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Deskripsi</label>
            <div class="col-sm-10">
              <textarea class="form-control" name="deskripsi" id="deskripsi" placeholder="Deskripsi">Copy of {!! $soal->deskripsi !!}</textarea>
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">KKM</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="kkm" id="kkm" placeholder="KKM, tuliskan dengan bilangan bulat" value="{!! $soal->kkm !!}">
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Waktu</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="waktu" id="waktu" placeholder="Waktu, tuliskan waktu dalam bentuk detik. Misal 60 menit, tuliskan 3600" value="{!! $soal->waktu !!}">
            </div>
          </div>  
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Skor soal</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="skor" id="skor" placeholder="Skor, tuliskan nilai skor tiap soal" value="5">
            </div>
          </div>        

          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                {{-- <a href="#" id="btnpicktable" style="text-decoration: none;">
                    <button type="button" class="btn btn-primary" data-toggle="tooltip" title="Buat soal"><i class="fa fa-pencil-square-o"></i> Pilih Butir Soal</button>
                </a> --}}
                <div id="wrapsoal" style="margin:15px 0 0 0;"> 
                    {{-- @meztr list each soal --}}
                    <hr class="clearfix">
                        <table class="table table-responsive table-condensed table-hover table-bordered">
                        <caption style="color: black">
                        Pilih butir soal untuk paket soal <b>{!! $soal->paket !!}</b> yang akan di duplikasi 
                        </caption>
                        <thead>
                            <tr>
                            <th><input type="checkbox" name="ckAll" id="ckAll"></th>
                            <th>NO</th>
                            <th>Soal</th>
                            <th>Kunci</th>
                            <th style="text-align:center;">Score</th>
                            <th style="text-align:center;">Status</th>
                            {{-- <th style="text-align:center;">Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; ?>
                        @if($detailsoals->count())
                        @foreach($detailsoals as $detailsoal)
                        <input type="hidden" name="id_soal{{ $detailsoal->id }}" id="id_soal{{ $detailsoal->id }}" value="{{ $detailsoal->id }}">
                        <tr>
                        <td><input type="checkbox" class="sub_chk" name="ck[]" value="{{ $detailsoal->id }}" data-id="{{ $detailsoal->id }}" id="ck{{ $detailsoal->id }}"></td>
                            <td>{{ $no++ }}</td>
                            <td id="formula">{!! $detailsoal->soal !!}</td>
                            <td align="center">{!! $detailsoal->kunci !!}</td>
                            <td align="center">{!! $detailsoal->score !!}</td>
                            <td align="center" valign="midle"><?php
                            if($detailsoal->status == "Y"){echo "<span style='background:#008000; color:#fff; padding:5px'>Tampil</span>";}else{echo "<span style='background:#cc0000; color:#fff; padding:5px'>Tidak</span>";}
                            ?></td>
                            {{-- <td width="120px" align="center"><a href="{{url('ubah-detail-soal', $detailsoal->id)}}" title="">Ubah</a> | <a href="#" id="hapussoal{{ $detailsoal->id }}" data-toggle="tooltip" title="Data soal yang dihapus tidak bisa dikembalikan.">Hapus</a></td> --}}
                        </tr>
                        <tr class="alert alert-danger" style="display: none;" id="wrapth{{ $detailsoal->id }}">
                            <td colspan="6" id="tampilhapus{{ $detailsoal->id }}"></td>
                        </tr>
                        <script>
                            $(document).ready(function() {                
                                $('#ck{{ $detailsoal->id }}').click(function () {
                                    console.log("centang {{ $detailsoal->id }}");
                                });
                            });
                        </script> 
                        @endforeach
                        @else
                        <tr><td colspan="6" class="alert alert-danger">Belum ada data untuk ditampilkan.</td></tr>
                        @endif
                        </tbody>
                    </table>
                    {{-- eof @meztr list each soal --}}
                </div>
            </div>
          </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btnduplicate">Duplicate</button>
                <img src="{{ url('img/ajax-loader.gif') }}" alt="Loading" id="loading" style="display: none;"> </div>
            </div>
          </div>

          <div class="alert alert-danger" id="salah" style="display: none;"></div>
          <div class="alert alert-info" id="benar" style="display: none;"><b>Sukses </b>Soal berhasil di duplikat. <i>Refresh</i> halaman untuk melihat data.</div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="{{ url('/assets/assets/vendor/jquery.min.js') }}"></script>
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(document).ready(function() {
        $("loading").hide();
        $('#ckAll').click(function () {
            console.log("centang All");
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        $("#btnduplicate").click(function() {
            var arraySoals = [];
            var minSelect = 5;
            $(".sub_chk:checked").each(function() {
                arraySoals.push($(this).attr('data-id'));
            });

            if (arraySoals.length < minSelect) {
                alert("Silakan pilih minimal 5 soal terlebih dahulu");
                return false;
            } else {
                var butirsoals = JSON.stringify(arraySoals);
                var check = confirm("Apakah anda yakin akan menduplikasi butir-butir soal ini?" + butirsoals);  
                if(check == true) { 
                    // arraySoals.sort(function(a, b){return a - b});
                    $("#loading").show();
                    var paket = $("#paket").val();
                    var deskripsi = $("#deskripsi").val();
                    var kkm = $("#kkm").val();
                    var waktu = $("#waktu").val();
                    var id_soal = $("#id_soal").val();
                    var skor = $("#skor").val();
                    var datastring = "paket="+paket+"&deskripsi="+deskripsi+"&kkm="+kkm+"&waktu="+waktu+"&id_soal="+id_soal+"&skor="+skor+"&butir_soals="+butirsoals;
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/duplicateformsoal') }}",
                        data: datastring,
                        success: function(data){
                            if(data == "berhasil"){
                                $("#loading").hide();
                                $("#salah").hide();
                                $("#benar").show();
                                $("#btnduplicate").show();
                                window.location.href = "{{ url('/soal-guru') }}"
                            }else{
                                $("#loading").hide();
                                $("#benar").hide();
                                $("#salah").html(data).show();
                                $("#btnduplicate").show();
                            }
                        }
                    });
                    return false;
                } else {
                    return false;
                }
            }
        });          
    });
    //   $("#salah").hide();
    //   $("#benar").hide();
    //   $('.collapse').collapse();

    //   $("#btnsimpansiswa").click(function() {
    //     $(this).hide();
    //     $("#loading").show();
    //     var paket = $("#paket").val();
    //     var deskripsi = $("#deskripsi").val();
    //     var kkm = $("#kkm").val();
    //     var waktu = $("#waktu").val();
    //     var id_soal = $("#id_soal").val();
    //     var datastring = "paket="+paket+"&deskripsi="+deskripsi+"&kkm="+kkm+"&waktu="+waktu+"&id_soal="+id_soal;
    //     $.ajax({
    //       type: "POST",
    //       url: "{{ url('/updateformsoal') }}",
    //       data: datastring,
    //       success: function(data){
    //         if(data == "berhasil"){
    //           $("#loading").hide();
    //           $("#salah").hide();
    //           $("#benar").show();
    //           $("#btnsimpansiswa").show();
    //           window.location.href = "{{ url('/soal-guru') }}"
    //         }else{
    //           $("#loading").hide();
    //           $("#benar").hide();
    //           $("#salah").html(data).show();
    //           $("#btnsimpansiswa").show();
    //         }
    //       }
    //     });
    //     return false;
    //   });
    
</script>
@endsection