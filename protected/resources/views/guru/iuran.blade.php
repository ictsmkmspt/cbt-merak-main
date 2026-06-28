@extends('layouts/guru_baru')
@section('title', 'Iuran Siswa')
@section('content')
<link rel="stylesheet" href="{{ url('css/upload.css') }}">
<style>
  #modal-center{
    margin:15% 30% 30% 35%;
    width: 80px;	
    height: 80px;
    position: absolute;
    position:fixed;
    z-index:1002;
    display: none;
    background: none;	
  }
</style>
<script src="{{url('lib/jquery/jquery.js')}}"></script>
<?php
  include(app_path().'/functions/koneksi.php');
  $sapaan = Auth::user()->jk;
  if ($sapaan == "L") {
    $sapaan = "Pak";
  }else{
    $sapaan = "Ibu";
  }
  $byFilterKelas = "0";
  $byFilterStatus = "0";
?>
<div id="modal-center">
  <i class="fa fa-spinner fa-spin fa-5x" style="margin:auto;"></i>
  {{-- <i class="fa fa-spinner fa-pulse fa-5x" style="margin: auto;"></i> --}}
  <h3>Hadang..</h3>
</div>

<div class="col-md-12 dash-left">
  <ol class="breadcrumb">
    <li><a href="{{ url('/guru') }}">Home</a></li>
    <li class="active">Iuran Siswa</li>
  </ol>
  <div class="panel panel-default">
    <div class="panel-heading" style="background: #072047; color: #fff">Iuran Siswa</div>
    <div class="panel-body">
            
      <div class="form-horizontal" style="margin-bottom: 15px">
        <input type="text" class="form-control" id="q" placeholder="Cari berdasarkan Nama (Ketik lalu enter)">
      </div>

      <div class="row">
        <div class="col-sm-3">
          <label>Berdasarkan Kelas</label>
          <form method="GET" action="{{url('iuran-siswa')}}"">
            {{-- {{ csrf_field() }} --}}
            <select class="form-control m-bot15" name="id" id="byKelas" onchange='this.form.submit()'>
              @if($kelas->count() > 0)
                <option selected disabled value=0>Semua Kelas</option>
                @foreach ($kelas as $itemkelas)
                    <option value="{{$itemkelas->id}}">{{$itemkelas->nama}}</option>
                @endforeach                
              @else
                <option value=0>No record found</option>
              @endif
            </select>
          </form>
        </div>
        <div class="col-sm-3">
          <label>Berdasarkan Status Bebas Admin</label>
          <form method="GET" action="{{url('iuran-siswa')}}"">
            <select class="form-control m-bot15" name="status" onchange='this.form.submit()'>
              <option selected disabled value=0>Semua Status</option>
              <option value="1">Status Aktif</option>
              <option value="2">Status Non Aktif</option>
            </select>
          </form>
        </div>
        <div class="col-sm-1">
          <br>
          <button id="btnReset" type="button"
              class="btn btn-warning"
              data-toggle="collapse" data-placement="right" title="Reset Filter Pencarian"
              onclick="window.location='{{ url("iuran-siswa") }}'">
              <i class="fa fa-filter" aria-hidden="true"></i> Reset Filter
          </button>
        </div>
        <div class="col-sm-4" style="margin-left:80px; margin-right:0px;">
          <div class="col-sm-5">
            <br>
            <button disabled id="btnBukaSiswa" type="button"
              class="btn btn-success"
              data-toggle="collapse" data-placement="right" title="balum bafungsi! hadangi versi selanjutnya">
              <i class="fa fa-unlock" aria-hidden="true"></i> Buka Akun Siswa
            </button>
          </div>
          <div class="col-sm-5">
            <br>
            <button disabled id="btnKunciSiswa" type="button" 
              class="btn btn-danger" 
              data-toggle="collapse" data-placement="right" title="balum bafungsi! hadangi versi selanjutnya" href="#uploadexcel" aria-expanded="false">
              <i class="fa fa-lock" aria-hidden="true"></i> Kunci Akun Siswa
            </button>
          </div>
        </div>
      </div>
      <hr>
      
      <div id="wrap-user" class="table-responsive">
        <label id="jmlsiswa" class="lead">Jumlah: {{ $jumlah_siswa->count() }} siswa</label>
        
        <table class="table table-bordered table-default table-striped nomargin" id="users-table">
          <thead>
            <tr>
              <th><input type="checkbox" name="ckAll" id="ckAll"></th>
              <th>Status</th>
              <th>#</th>
              <th>Nama</th>
              <th>NIS</th>
              <th>Email</th>
              <th>J.K</th>
              <th>Kelas</th>
              <th width="50px">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = $users->firstItem(); ?>
            @if($users->count())
            @foreach($users as $data_user)
            <?php
              if ($data_user->jk == 'L') {
                $jk = 'L';
              }else{
                $jk = 'P';
              }
              if ($data_user->sekolah_asal == 'disabled') {
                $data_user_btn = 'btn-danger';
                $data_user_lock = 'fa-lock';
                $redtext = 'color:red';
                $infostatus = "Buka Akun Siswa";
              } else {
                $data_user_btn = 'btn-success';
                $data_user_lock = 'fa-unlock';
                $redtext = '';
                $infostatus = "Kunci Akun Siswa";
              }
            ?>
            <input type="hidden" name="id_user{{ $data_user->id }}" id="id_soal{{ $data_user->id }}" value="{{ $data_user->id }}">
            <tr>
              <td><input type="checkbox" class="sub_chk" name="ck[]" value="{{ $data_user->id }}" data-id="{{ $data_user->id }}" id="ck{{ $data_user->id }}"></td>
              <td align="center">
                  <button data-toggle="tooltip" data-placement="right" title="{{$infostatus}}" class="btn btn-xs {!! $data_user_btn !!} fa {!! $data_user_lock !!}" type="button" value="{{ $data_user->id }}" id="btnUbahStatus{{ $data_user->id }}">
              </td>
              <td style="{!! $redtext !!}">{{ $no++ }}</td>
              <td style="{!! $redtext !!}">{{ $data_user->nama }}</td>
              <td style="{!! $redtext !!}">{{ $data_user->no_induk }}</td>
              <td style="{!! $redtext !!}">{{ $data_user->email }}</td>
              <td style="{!! $redtext !!}">{{ $jk }}</td>
              <td style="{!! $redtext !!}">{{ $data_user->nama_kelas }}</td>
              <td align="center">
                <a href="{{ url('/detail-kelas-siswa/'.$data_user->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-cog"></i></a>
              </td>
            </tr>
            <script>
                $(document).ready(function(){                
                    $('#ck{{ $data_user->id }}').click(function () {
                        // console.log("centang {{ $data_user->id }}");
                    });

                    $('#btnUbahStatus{{ $data_user->id }}').click(function () {
                        var datastr = "data="+{{$data_user->id}};
                        $("#modal-center").modal();
                        
                        $.ajax({
                          type: "POST",
                          url: "{!! url('ubah-status-siswa') !!}",
                          data: datastr,
                          success: function(data){                            
                            // console.log("ubah dgn data: "+data);
                            location.reload();
                            $("#modal-center").modal('hide');
                          },
                          error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert("ubahstatus failed: "+data);
                            $("#modal-center").modal('hide');
                          }
                        })
                    });
                });
            </script> 
            @endforeach
            @else
            <tr><td colspan="7" class="alert alert-danger">Belum ada data untuk ditampilkan.</td></tr>
            @endif
          </tbody>
        </table>
        {!! $users->render() !!}
      </div>
    </div>
  </div>
</div>
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
  $(document).ready(function() {
    $('#ckAll').click(function () {
        console.log("centang All");
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $("#q").keyup(function(e){
      if(e.keyCode == 13)
      {
        //$("#loading_cari").show();
        $("#modal-center").fadeIn("slow");
        var q = encodeURIComponent($("#q").val());
        $.ajax({
          type: "POST",
          url: "{{ url('/get-siswa') }}",
          data: 'q='+q,
          success: function(data){
            // $("#loading_cari").hide();
            $("#modal-center").fadeOut("slow");
            $("#wrap-user").hide().html(data).fadeIn(350);
          }
        })
      }
    });

    $('.collapse').collapse();

    $('#btnUbahStatus').click(function() {
      console.log('qweqwe');
    });

    // $('#idKelas').on('change', function(e){
    //   console.log(e);
    //   var state_id = e.target.value;
    // });
  });
</script>
@endsection