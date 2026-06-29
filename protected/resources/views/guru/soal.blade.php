@extends('layouts/guru_baru')
@section('title', 'Soal')
@section('content')
<style type="text/css" media="screen">
  h1{
    text-align: center;
    background-color: #FEFFED;
    height: 70px;
    color: rgb(95, 89, 89);
    margin: 0 0 -29px 0;
    padding-top: 14px;
    border-radius: 10px 10px 0 0;
    font-size: 35px;
  }
  #image_preview{
    font-size: 30px;
    width: 100%;
    text-align: center;
    font-weight: bold;
    color: #C0C0C0;
    background-color: #FFFFFF;
    overflow: auto;
    padding: 15px 0;
  }
  #selectImage{
    padding: 19px 21px 14px 15px;
    width: 100%;
    background-color: #FEFFED;
    border-radius: 10px;
  }
  #loading{
    display:none;
    font-size:25px;
    margin: 15px 0 0 0;
  }
  #message{
    margin: 15px 0 0 0;
  }
  .inputfile {
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
  }
  .inputfile + label {
      font-size: 1.25em;
      font-weight: 700;
      color: white;
      background-color: #444443;
      display: inline-block;
      cursor: pointer;
      padding: 10px;
  }
  .inputfile:focus + label,
  .inputfile + label:hover {
      background-color: red;
  }
  .inputfile:focus + label {
    outline: 1px dotted #000;
    outline: -webkit-focus-ring-color auto 5px;
  }
  #success {
    color:green;
  }
  #invalid {
    color:red;
  }
  /*#line {
    margin-top: 274px;
  }*/
  #error {
    color:red;
  }
  #error_message {
    color:blue;
  }
</style>

{{-- @mezt --}}
{{-- <script>
  jQuery(function($){
    $('.table').footable();
  });
</script> --}}
{{-- eofmezt --}}

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
    <li class="active">Soal</li>
  </ol>
  <div class="panel panel-default">
    <div class="panel-heading" style="background: #072047; color: #fff">Data Soal</div>
    <div class="panel-body"> 
      <a href="#" id="btnsoal" style="text-decoration: none;">
        <button type="button" class="btn btn-primary" data-toggle="tooltip" title="Buat soal"><i class="fa fa-pencil-square-o"></i> Buat Paket Soal</button>
      </a> 
      <a href="{{ URL::to( '/readfile/soal.xls')  }}" target="_blank" style="text-decoration: none;">
        <button type="button" class="btn btn-success" data-toggle="tooltip" title="Download format excel untuk mengupload data siswa."><i class="fa fa-cloud-download"></i> Download Format Excel</button>
      </a>
      <button type="button" class="btn btn-success" href="#" id="btnupload" aria-expanded="false"><i class="fa fa-cloud-upload"></i> Upload Excel</button>
      <div id="wrapsoal" style="margin:15px 0 0 0; display: none;">
        <div class="well">
          {!! Form::open(['url' => 'simpansiswa', 'class' => 'form-horizontal']) !!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Jenis</label>
              <div class="col-sm-10">
                <select id="jenis" class="form-control">
                  <option value="">-- Pilih jenis soal --</option>
                  <option value="1">Ujian</option>
                  <option value="2">Latihan</option>
                </select>
              </div>
            </div>
            <div class="form-group" style="display: none;" id="wrap-materi">
              <label for="inputEmail3" class="col-sm-2 control-label">Materi</label>
              <div class="col-sm-10">
                <select id="materi" class="form-control">
                  <option value="">-- Pilih materi --</option>
                  @if($materis->count())
                  @foreach($materis as $data_materi)
                    <option value="{{ $data_materi->id }}">{{ $data_materi->judul }}</option>
                  @endforeach
                  @else
                    <option value="">Belum ada materi. Silakan buat materi dulu di menu Materi.</option>
                  @endif
                </select>
                <small class="text-muted"><i class="fa fa-info-circle"></i>
                  Pilih materi yang akan dilampirkan soal latihan ini.
                  Soal latihan hanya tampil di halaman detail materi yang dipilih.
                </small>
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Paket</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="paket" id="paket" placeholder="Paket soal, misal: UTS KKPI Kelas XI">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Deskripsi</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="deskripsi" id="deskripsi" placeholder="Deskripsi"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">KKM</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="kkm" id="kkm" placeholder="KKM, tuliskan dengan bilangan bulat">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Waktu</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="waktu" id="waktu" placeholder="Waktu, tuliskan waktu dalam bentuk detik. Misal 60 menit, tuliskan 3600">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btnsimpansiswa">Simpan</button>
                <img src="img/ajax-loader.gif" alt="Loading" id="loading"> </div>
            </div>
            <div class="alert alert-danger" id="salah"></div>
            <div class="alert alert-info" id="benar"><b>Sukses </b>Soal berhasil di buat. <i>Refresh</i> halaman untuk melihat data. Klik detail dan tambahkan item soal untuk paket soal yang Anda buat.</div>
          </form>
        </div>
      </div>
      <div class="clearfix"></div>
      <div id="uploadexcel" style="margin:15px 0 0 0; display: none;">
        <div class="well"> {!! Form::open(['url' => 'uploadsoal', 'class' => 'form-horizontal', 'files' => true]) !!}
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Pilih Paket Soal</label>
            <div class="col-sm-10" style="margin-bottom:10px">
              <select id="paket_soal_id" name="paket_soal_id" class="form-control">
                  <option value="">-- Pilih Paket Soal --</option>
                  @if($soals->count())
                  @foreach($soals as $soal)
                    <option value="{{ $soal->id }}">{{ $soal->paket }}</option>
                  @endforeach
                  @else
                    <option value="">Anda belum memiliki paket soal.</option>
                  @endif
                </select>
            </div>

            <label for="inputEmail3" class="col-sm-2 control-label">File (Excel)</label>
            <div class="col-sm-10">
              <input type="file" name="fileg" id="file" class="inputfile" required />
              <label for="file"><strong><span class="fa fa-cloud-upload"></span> Choose a file</strong></label>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-primary">Upload</button>
            </div>
          </div>
          <div class="alert alert-danger"><b>PERHATIAN:</b> Isikan dengan benar data soal kedalam format excel yang disediakan. Jangan menambah atau menghapus column yang ada di format excel. Ikuti instruksi pada <i>comments</i> di bagian header tabel excel. Sistem akan menolak apabila format yang disediakan tidak di isi dengan benar.</div>
          </form>
        </div>
      </div>
      <hr class="clearfix">
      <div class="form-horizontal" style="margin-bottom: 15px">
        <input type="text" class="form-control" id="q" placeholder="Cari berdasarkan Paket soal (Ketik lalu enter)">
      </div>
      <img src="{{ url('/assets/assets/images/facebook.gif') }}" alt="loading" id="loading_cari" style="display: none;">
      {{-- mezt --}}
      {{-- <div class="panel-group">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" href="#collapse1">Advanced Control</a>
            </h4>
          </div>
          <div id="collapse1" class="panel-collapse collapse">
            <div class="panel-body">Panel Body</div>
            <div class="panel-footer">Panel Footer</div>
          </div>
        </div>
      </div> --}}

      {{-- <table class="table table-bordered table-striped table-hover table-condensed" data-sorting="true">
        <thead>
          <tr>
            <th data-breakpoints="xs" data-type="number">ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th data-breakpoints="xs">Job Title</th>
            <th data-breakpoints="xs sm" data-type="date" data-format-string="MMMM Do YYYY">Started On</th>
            <th data-breakpoints="xs sm md" data-type="date" data-format-string="MMMM Do YYYY">Date of Birth</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Dennise</td>
            <td>Fuhrman</td>
            <td>High School History Teacher</td>
            <td>November 8th 2011</td>
            <td>July 25th 1960</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Elodia</td>
            <td>Weisz</td>
            <td>Wallpaperer Helper</td>
            <td>October 15th 2010</td>
            <td>March 30th 1982</td>
          </tr>
          <tr>
            <td>3</td>
            <td>Raeann</td>
            <td>Haner</td>
            <td>Internal Medicine Nurse Practitioner</td>
            <td>November 28th 2013</td>
            <td>February 26th 1966</td>
          </tr>
          <tr>
            <td>4</td>
            <td>Junie</td>
            <td>Landa</td>
            <td>Offbearer</td>
            <td>October 31st 2010</td>
            <td>March 29th 1966</td>
          </tr>
          <tr>
            <td>5</td>
            <td>Solomon</td>
            <td>Bittinger</td>
            <td>Roller Skater</td>
            <td>December 29th 2011</td>
            <td>September 22nd 1964</td>
          </tr>
          <tr>
            <td>6</td>
            <td>Bar</td>
            <td>Lewis</td>
            <td>Clown</td>
            <td>November 12th 2012</td>
            <td>August 4th 1991</td>
          </tr>
          <tr>
            <td>7</td>
            <td>Usha</td>
            <td>Leak</td>
            <td>Ships Electronic Warfare Officer</td>
            <td>August 14th 2012</td>
            <td>November 20th 1979</td>
          </tr>
          <tr>
            <td>8</td>
            <td>Lorriane</td>
            <td>Cooke</td>
            <td>Technical Services Librarian</td>
            <td>September 21st 2010</td>
            <td>April 7th 1969</td>
          </tr>
        </tbody>
      </table> --}}
      {{-- end of mezt --}}

      <div id="wrap-user" class="table-responsive">
        <table class="table table-bordered table-striped table-hover table-condensed" id="tabelsoal">
          <thead>
            <tr>
              <th style="width: 50px">#</th>
              <th style="text-align: center;">ID <small>Soal</small></th>
              <th>Materi</th>
              <th>Paket <small>Soal</small></th>
              <th>Deskripsi</th>
              <th>KKM</th>
              <th>Waktu</th>
              <th>Tgl Dibuat</th>
              <th style="width: 160px; text-align: center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = $soals->firstItem(); ?>
            @if($soals->count())
            @foreach($soals as $soal)
            <?php
              // Kolom materi: tampil nama materi jika jenis latihan, kosong jika ujian
              if ($soal->jenis == 2 && $soal->nama_materi) {
                $materi_label = "<span class='label label-info'>" . e($soal->nama_materi) . "</span>";
              } elseif ($soal->jenis == 2 && !$soal->nama_materi) {
                $materi_label = "<span class='label label-warning'>Belum dipilih</span>";
              } else {
                $materi_label = "<span class='text-muted'>-</span>";
              }
            ?>
            <?php
              $tanggal = explode(" ", $soal->created_at);
              $tanggal = explode("-", $tanggal[0]);
              $tanggal = $tanggal[2].' '.$bulanpendek[$tanggal[1]].' '.$tanggal[0];
            ?>
            <tr>
              <td>{{ $no++ }}</td>
              <td style="text-align: center;">{{ $soal->id }}</td>
              <td>{!! $materi_label !!}</td>
              <td>{{ $soal->paket }}</td>
              <td>{{ $soal->deskripsi }}</td>
              <td>{{ $soal->kkm }}</td>
              <td>{{ $soal->waktu/60 }} menit</td>
              <td>{{ $tanggal }}</td>
              <td style="text-align: center;">
                <a href="{{ url('/edit-soal/'.$soal->id) }}" class="btn btn-xs btn-success" data-toggle='tooltip' title="Ubah Soal"><i class="fa fa-pencil-square-o"></i></a>
                <a href="{{ url('/duplicate-soal/'.$soal->id) }}" class="btn btn-xs btn-success" data-toggle='tooltip' title="Duplikat Soal"><i class="fa fa fa-cubes"></i></a>
                <a href="{{ url('/detail-soal/'.$soal->id) }}" class="btn btn-xs btn-primary" data-toggle='tooltip' title="Detail Soal"><i class="fa fa-search"></i></a>
                <a href="{{ url('/hapus-soal/'.$soal->id) }}" class="btn btn-xs btn-danger" target="_blank" data-toggle='tooltip' title="Hapus Soal"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
            @endforeach
            @else
            <tr><td colspan="9" class="alert alert-danger">Belum ada data untuk ditampilkan.</td></tr>
            @endif
          </tbody>
        </table>
        {!! $soals->render() !!}
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
    $("#q").keyup(function(e){
      if(e.keyCode == 13)
      {
        $("#loading_cari").show();
        var q = $("#q").val();
        $.ajax({
          type: "POST",
          url: "{{ url('/get-soal-guru') }}",
          data: 'q='+q,
          success: function(data){
            $("#loading_cari").hide();
            $("#wrap-user").hide().html(data).fadeIn(350);
          }
        });
      }
    });

    $("#loading").hide();
    $("#salah").hide();
    $("#benar").hide();
    $('.collapse').collapse();

    $("#btnsoal").click(function() {
      $("#wrapsoal").toggle(function() {});
      return false;
    });

    $("#btnupload").click(function() {
      $("#uploadexcel").toggle(function() {});
      return false;
    });

    $("#jenis").change(function(){
      var jenis = $("#jenis").val();
      if (jenis == 1) {
        $("#wrap-materi").hide();
      }else{
        $("#wrap-materi").show().focus();
      }
    });

    $("#btnsimpansiswa").click(function() {
      $(this).hide();
      $("#loading").show();
      var jenis = $("#jenis").val();
      var materi = $("#materi").val();
      var paket = $("#paket").val();
      var deskripsi = $("#deskripsi").val();
      var kkm = $("#kkm").val();
      var waktu = $("#waktu").val();
      var datastring = "paket="+paket+"&deskripsi="+deskripsi+"&kkm="+kkm+"&waktu="+waktu+"&jenis="+jenis+"&materi="+materi;
      $.ajax({
        type: "POST",
        url: "{{ url('/simpanformsoal') }}",
        data: datastring,
        success: function(data){
          if(data == "berhasil"){
            $("#loading").hide();
            $("#salah").hide();
            $("#benar").show();
            $("#btnsimpansiswa").show();
            window.location.href = "{{ url('/soal-guru') }}";
          }else{
            $("#loading").hide();
            $("#benar").hide();
            $("#salah").html(data).show();
            $("#btnsimpansiswa").show();
          }
        }
      });
      return false;
    });
  });
</script>
@endsection
