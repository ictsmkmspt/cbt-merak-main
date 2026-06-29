@extends('layouts/guru_baru')
@section('title', 'Mata Pelajaran')
@section('content')
<script src="{{ url('/assets/assets/vendor/jquery.min.js') }}"></script>
<?php include(app_path().'/functions/koneksi.php'); ?>

{{-- KONTEN KIRI --}}
<div class="col-sm-12 col-md-8 col-lg-8 dash-left">
  <ol class="breadcrumb">
    <li><a href="{{ url('/guru') }}">Home</a></li>
    <li class="active">Mata Pelajaran</li>
  </ol>

  <div class="panel panel-default">
    <div class="panel-heading" style="background:#072047; color:#fff">Data Mata Pelajaran</div>
    <div class="panel-body">

      <div id="notif" style="display:none; margin-bottom:10px"></div>

      {{-- TOMBOL TAMBAH --}}
      <button class="btn btn-primary btn-sm" id="btn-tambah">
        <i class="fa fa-plus"></i> Tambah Mata Pelajaran
      </button>

      {{-- FORM TAMBAH --}}
      <div id="wrap-form" style="display:none; margin:15px 0; padding:15px; background:#f9f9f9; border:1px solid #ddd; border-radius:6px;">
        <div class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-3 control-label">Nama Mata Pelajaran</label>
            <div class="col-sm-7">
              <input type="text" class="form-control" id="nama" placeholder="Misal: Matematika, Teknik Jaringan">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
              <button class="btn btn-success btn-sm" id="btn-simpan">
                <i class="fa fa-save"></i> Simpan
              </button>
              <button class="btn btn-default btn-sm" id="btn-batal">Batal</button>
              <img src="{{ url('img/ajax-loader.gif') }}" id="loading-form" style="display:none">
            </div>
          </div>
        </div>
      </div>

      {{-- TABEL --}}
      <div class="table-responsive" style="margin-top:15px">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th style="width:40px">#</th>
              <th>Nama Mata Pelajaran</th>
              <th style="width:160px; text-align:center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = $mapels->firstItem(); ?>
            @if($mapels->count())
            @foreach($mapels as $m)
            <tr id="row-{{ $m->id }}">
              <td>{{ $no++ }}</td>
              <td id="nama-{{ $m->id }}">{{ $m->nama }}</td>
              <td style="text-align:center">
                <button class="btn btn-warning btn-xs btn-edit"
                  data-id="{{ $m->id }}"
                  data-nama="{{ $m->nama }}">
                  <i class="fa fa-pencil"></i> Edit
                </button>
                <button class="btn btn-danger btn-xs btn-hapus" data-id="{{ $m->id }}">
                  <i class="fa fa-trash"></i> Hapus
                </button>
              </td>
            </tr>
            @endforeach
            @else
            <tr><td colspan="3" class="alert alert-warning text-center">Belum ada data mata pelajaran.</td></tr>
            @endif
          </tbody>
        </table>
        {!! $mapels->render() !!}
      </div>

    </div>
  </div>
</div>

{{-- PANEL AKTIFITAS KANAN --}}
<div class="col-sm-12 col-md-4 col-lg-4 dash-right">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">Aktifitas Terkini</h4>
    </div>
    <div class="panel-body">
      <ul class="media-list user-list" id="panel-aktifitas">
        @if($aktifitas->count())
        @foreach($aktifitas as $data)
        <?php
          $tgl = explode(" ", $data->created_at);
          $tgl = explode("-", $tgl[0]);
          $tgl = $tgl[2].' '.$bulanpendek[$tgl[1]].' '.$tgl[0];
          $gbr = ($data->gambar != "") ? $data->gambar : 'noimage.jpg';
        ?>
        <li class="media">
          <div class="media-left">
            <a href="#"><img class="media-object img-thumbnail" src="{{ url('img/'.$gbr) }}" alt=""></a>
          </div>
          <div class="media-body">
            <h4 class="media-heading nomargin"><a href="#">{{ $data->nama_user }}</a></h4>
            {{ $data->nama }}
            <small class="date"><i class="fa fa-clock-o"></i> {{ $tgl }}</small>
          </div>
        </li>
        @endforeach
        @endif
      </ul>
      <a href="{{ url('/aktifitas') }}" class="btn btn-success" style="display:block; width:100%; margin:10px 0 0 0">Selengkapnya</a>
    </div>
  </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="modal-edit" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background:#072047; color:#fff">
        <h4 class="modal-title">Edit Mata Pelajaran</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="edit-id">
        <div class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-3 control-label">Nama</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="edit-nama">
            </div>
          </div>
          <div id="notif-edit" style="display:none; margin:10px 15px 0"></div>
        </div>
      </div>
      <div class="modal-footer">
        <img src="{{ url('img/ajax-loader.gif') }}" id="loading-edit" style="display:none">
        <button class="btn btn-success" id="btn-simpan-edit">
          <i class="fa fa-save"></i> Simpan
        </button>
        <button class="btn btn-default" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

<script src="{{ url('lib/bootstrap/js/bootstrap.js') }}"></script>
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

function refreshAktifitas() {
  $.get('{{ url("/ajax/get-aktifitas") }}', function(html) {
    $('#panel-aktifitas').hide().html(html).fadeIn(400);
  });
}

$(document).ready(function() {

  // Tampil/sembunyikan form tambah
  $('#btn-tambah').click(function() { $('#wrap-form').slideToggle(); });
  $('#btn-batal').click(function()  { $('#wrap-form').slideUp(); $('#nama').val(''); });

  // Simpan mapel baru
  $('#btn-simpan').click(function() {
    var nama = $('#nama').val().trim();
    if (!nama) { alert('Nama mata pelajaran wajib diisi.'); return; }
    $('#loading-form').show();
    $.post('{{ url("/mapel/tambah") }}', { nama: nama }, function(res) {
      $('#loading-form').hide();
      if (res == 'ok') {
        $('#notif').removeClass('alert-danger').addClass('alert alert-success')
          .html('<i class="fa fa-check"></i> Mata pelajaran berhasil ditambahkan.').show();
        refreshAktifitas();
        setTimeout(function(){ location.reload(); }, 1000);
      } else {
        $('#notif').removeClass('alert-success').addClass('alert alert-danger').html(res).show();
      }
    });
  });

  // Buka modal edit
  $(document).on('click', '.btn-edit', function() {
    $('#edit-id').val($(this).data('id'));
    $('#edit-nama').val($(this).data('nama'));
    $('#notif-edit').hide();
    $('#modal-edit').modal('show');
  });

  // Simpan edit
  $('#btn-simpan-edit').click(function() {
    var id   = $('#edit-id').val();
    var nama = $('#edit-nama').val().trim();
    if (!nama) { alert('Nama wajib diisi.'); return; }
    $('#loading-edit').show();
    $.post('{{ url("/mapel/ubah") }}', { id: id, nama: nama }, function(res) {
      $('#loading-edit').hide();
      if (res == 'ok') {
        $('#modal-edit').modal('hide');
        $('#nama-' + id).text(nama);
        $('.btn-edit[data-id="' + id + '"]').data('nama', nama);
        $('#notif').removeClass('alert-danger').addClass('alert alert-success')
          .html('<i class="fa fa-check"></i> Mata pelajaran berhasil diubah.').show();
        refreshAktifitas();
      } else {
        $('#notif-edit').removeClass('alert-success').addClass('alert alert-danger').html(res).show();
      }
    });
  });

  // Hapus mapel
  $(document).on('click', '.btn-hapus', function() {
    var id = $(this).data('id');
    if (!confirm('Yakin ingin menghapus mata pelajaran ini?')) return;
    $.post('{{ url("/mapel/hapus") }}', { id: id }, function(res) {
      if (res == 'berhasil') {
        $('#row-' + id).fadeOut(300, function(){ $(this).remove(); });
        $('#notif').removeClass('alert-danger').addClass('alert alert-success')
          .html('<i class="fa fa-check"></i> Mata pelajaran berhasil dihapus.').show();
        refreshAktifitas();
      }
    });
  });

});
</script>
@endsection
