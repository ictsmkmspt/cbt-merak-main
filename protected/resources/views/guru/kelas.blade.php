@extends('layouts/guru_baru')
@section('title', 'Kelas')
@section('content')
<script src="{{ url('/assets/assets/vendor/jquery.min.js') }}"></script>
<?php
  include(app_path().'/functions/koneksi.php');
  $sapaan = Auth::user()->jk;
  if ($sapaan == "L") { $sapaan = "Pak"; } else { $sapaan = "Ibu"; }
?>
<div class="col-sm-12 col-md-8 col-lg-8 dash-left">
  <ol class="breadcrumb">
    <li><a href="{{ url('/guru') }}">Home</a></li>
    <li class="active">Kelas</li>
  </ol>

  <!-- NOTIFIKASI -->
  <div id="notif-global" style="display:none; margin-bottom:10px;"></div>

  <div class="panel panel-default">
    <div class="panel-heading" style="background: #072047; color: #fff">Data Kelas</div>
    <div class="panel-body">

      <div class="alert alert-warning">
        <span class="fa fa-exclamation-circle"></span>
        <b>PERHATIAN: </b>Merubah atau menghapus data kelas bisa berdampak buruk terhadap siswa yang terdapat didalamnya.
      </div>

      <!-- TOMBOL TAMBAH -->
      <a href="#" class="btn btn-primary" data-toggle="collapse" data-target="#wrapubah">
        <i class="fa fa-plus"></i> Tambah Kelas
      </a>

      <!-- FORM TAMBAH KELAS -->
      <div class="collapse" id="wrapubah" style="margin:15px 0 0 0;">
        <div class="well">
          <form method="POST" id="formtambah" class="form-horizontal">
            {!! csrf_field() !!}
            <div class="form-group">
              <label class="col-sm-2 control-label">Nama Kelas</label>
              <div class="col-sm-10">
                <input type="hidden" name="id_user" id="id_user" value="{{ Auth::user()->id }}">
                <input type="text" name="nama" id="nama" class="form-control" placeholder="Contoh: X TKJ 1">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="button" id="btntbhkelas" class="btn btn-success">
                  <i class="fa fa-save"></i> Simpan
                </button>
              </div>
            </div>
            <img src="{{ url('/img/ajax-loader.gif') }}" alt="" id="loading" style="display:none;">
            <div id="notif" style="display:none;"></div>
          </form>
        </div>
      </div>

      <!-- TABEL KELAS -->
      <div class="table-responsive" style="margin-top:15px;">
        <table class="table table-bordered table-default table-striped nomargin">
          <thead>
            <tr>
              <th style="text-align:center; width:45px;">No</th>
              <th style="text-align:center; width:80px;">ID Kelas</th>
              <th>Nama Kelas</th>
              <th style="text-align:center; width:120px;">Jumlah Siswa</th>
              <th style="text-align:center; width:150px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; ?>
            @if($kelas->count())
            @foreach($kelas as $dk)
            <tr id="baris{{ $dk->id }}">
              <td align="center">{{ $no++ }}</td>
              <td align="center">{{ $dk->id }}</td>
              <td>
                {{-- MODE TAMPIL --}}
                <span id="label-nama{{ $dk->id }}">{{ $dk->nama }}</span>

                {{-- MODE EDIT (tersembunyi) --}}
                <div id="form-edit{{ $dk->id }}" style="display:none;">
                  <div class="input-group input-group-sm">
                    <input type="text"
                           id="input-nama{{ $dk->id }}"
                           class="form-control"
                           value="{{ $dk->nama }}">
                    <span class="input-group-btn">
                      <button class="btn btn-success btn-simpan"
                              data-id="{{ $dk->id }}"
                              title="Simpan">
                        <i class="fa fa-check"></i> Simpan
                      </button>
                      <button class="btn btn-default btn-batal"
                              data-id="{{ $dk->id }}"
                              data-nama="{{ $dk->nama }}"
                              title="Batal">
                        <i class="fa fa-times"></i>
                      </button>
                    </span>
                  </div>
                  <img src="{{ url('/assets/assets/images/facebook.gif') }}"
                       id="loading{{ $dk->id }}" style="display:none; margin-top:4px;">
                </div>
              </td>
              <td align="center">
                <?php
                  $conn2 = new mysqli($hostdb, $userdb, $passdb, $namedb);
                  $sql_s = $conn2->query("SELECT COUNT(*) AS total FROM users WHERE id_kelas='$dk->id' AND status='S'");
                  while($rs = $sql_s->fetch_assoc()){ echo '<b>'.$rs['total'].'</b>'; }
                  $conn2->close();
                ?>
              </td>
              <td align="center">
                {{-- EDIT --}}
                <button class="btn btn-warning btn-xs btn-edit"
                        data-id="{{ $dk->id }}"
                        id="btn-edit{{ $dk->id }}"
                        title="Edit nama kelas">
                  <i class="fa fa-pencil"></i> Edit
                </button>
                {{-- HAPUS --}}
                <button class="btn btn-danger btn-xs btn-hapus"
                        data-id="{{ $dk->id }}"
                        title="Hapus kelas">
                  <i class="fa fa-trash"></i>
                </button>
                {{-- DETAIL --}}
                <a href="{{ url('/detail-kelas', $dk->id) }}"
                   class="btn btn-primary btn-xs"
                   title="Lihat siswa di kelas ini">
                  <i class="fa fa-search"></i>
                </a>
              </td>
            </tr>
            @endforeach
            @else
            <tr><td colspan="5" class="text-center text-muted">Belum ada data kelas.</td></tr>
            @endif
          </tbody>
        </table>
        {!! $kelas->render() !!}
      </div>

    </div>
  </div>
</div>

<!-- PANEL AKTIFITAS -->
<div class="col-sm-12 col-md-4 col-lg-4 dash-right">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">Aktifitas Terkini</h4>
    </div>
    <div class="panel-body">
      <ul class="media-list user-list">
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
      <a href="{{ url('/aktifitas') }}" class="btn btn-success" style="display:block; width:100%; margin:10px 0 0 0;">Selengkapnya</a>
    </div>
  </div>
</div>

<!-- MODAL KONFIRMASI HAPUS -->
<div class="modal fade" id="modal-hapus" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header" style="background:#c0392b; color:#fff;">
        <h4 class="modal-title"><i class="fa fa-trash"></i> Hapus Kelas</h4>
      </div>
      <div class="modal-body">
        Yakin ingin menghapus kelas ini? Siswa di dalamnya akan kehilangan kelasnya.
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal">Batal</button>
        <button class="btn btn-danger" id="btn-konfirm-hapus">
          <i class="fa fa-trash"></i> Ya, Hapus
        </button>
      </div>
    </div>
  </div>
</div>

<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

// Notifikasi atas halaman
function showNotif(type, msg) {
  var cls  = (type === 'success') ? 'alert-success' : 'alert-danger';
  var icon = (type === 'success') ? 'check' : 'times';
  $('#notif-global')
    .removeClass('alert-success alert-danger')
    .addClass('alert ' + cls)
    .html('<i class="fa fa-' + icon + '-circle"></i> ' + msg)
    .fadeIn();
  setTimeout(function(){ $('#notif-global').fadeOut(); }, 4000);
  $('html,body').animate({ scrollTop: 0 }, 300);
}

// ---- TOMBOL EDIT ----
$(document).on('click', '.btn-edit', function(){
  var id = $(this).data('id');
  // Tutup semua form edit lain yang sedang terbuka
  $('[id^="form-edit"]').hide();
  $('[id^="label-nama"]').show();
  $('[id^="btn-edit"]').show();
  // Buka form edit baris ini
  $('#label-nama' + id).hide();
  $('#btn-edit' + id).hide();
  $('#form-edit' + id).show();
  $('#input-nama' + id).focus().select();
});

// ---- TOMBOL BATAL ----
$(document).on('click', '.btn-batal', function(){
  var id   = $(this).data('id');
  var nama = $(this).data('nama');
  $('#form-edit' + id).hide();
  $('#input-nama' + id).val(nama);
  $('#label-nama' + id).show();
  $('#btn-edit' + id).show();
});

// ---- SIMPAN (klik tombol Simpan) ----
$(document).on('click', '.btn-simpan', function(){
  simpanEdit($(this).data('id'));
});

// ---- SIMPAN (tekan Enter) ----
$(document).on('keyup', '[id^="input-nama"]', function(e){
  var id = $(this).attr('id').replace('input-nama', '');
  if (e.keyCode == 13) simpanEdit(id);           // Enter = simpan
  if (e.keyCode == 27) {                          // Escape = batal
    var nama = $('.btn-batal[data-id="' + id + '"]').data('nama');
    $('#input-nama' + id).val(nama);
    $('#form-edit' + id).hide();
    $('#label-nama' + id).show();
    $('#btn-edit' + id).show();
  }
});

function simpanEdit(id) {
  var nama = $('#input-nama' + id).val().trim();
  if (nama === '') {
    showNotif('error', 'Nama kelas tidak boleh kosong.');
    $('#input-nama' + id).focus();
    return;
  }
  $('#form-edit' + id).hide();
  $('#loading' + id).show();
  $.ajax({
    type: 'POST',
    url:  '{{ url("/ajax/ubah-kelas") }}',
    data: { nama: nama, id: id },
    success: function(res) {
      $('#loading' + id).hide();
      $('#label-nama' + id).html(res).show();
      // Update data-nama di tombol batal agar ESC/batal pakai nama terbaru
      $('.btn-batal[data-id="' + id + '"]').data('nama', res);
      $('#btn-edit' + id).show();
      showNotif('success', 'Nama kelas berhasil diubah menjadi <b>' + res + '</b>');
    },
    error: function() {
      $('#loading' + id).hide();
      $('#form-edit' + id).show();
      showNotif('error', 'Gagal menyimpan. Silakan coba lagi.');
    }
  });
}

// ---- HAPUS KELAS ----
var hapusId = null;
$(document).on('click', '.btn-hapus', function(){
  hapusId = $(this).data('id');
  $('#modal-hapus').modal('show');
});

$('#btn-konfirm-hapus').click(function(){
  $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
  $.ajax({
    type: 'POST',
    url:  '{{ url("/hapuskelas") }}',
    data: { id_kelas: hapusId },
    success: function(data) {
      $('#modal-hapus').modal('hide');
      $('#btn-konfirm-hapus').prop('disabled', false).html('<i class="fa fa-trash"></i> Ya, Hapus');
      if (data === 'berhasil') {
        $('#baris' + hapusId).fadeOut(400, function(){ $(this).remove(); });
        showNotif('success', 'Kelas berhasil dihapus.');
      } else {
        showNotif('error', 'Gagal menghapus kelas.');
      }
    }
  });
});

// ---- TAMBAH KELAS ----
$(document).ready(function() {
  $('#btntbhkelas').click(function() {
    var nama = $('#nama').val().trim();
    if (nama === '') {
      $('#notif').removeClass('alert-info').addClass('alert alert-danger').html('Nama kelas tidak boleh kosong.').show();
      return;
    }
    $('#loading').show();
    $.ajax({
      type: 'POST',
      url:  '{{ url("/tambahkelas") }}',
      data: 'nama=' + encodeURIComponent(nama) + '&id_user=' + $('#id_user').val(),
      success: function(data) {
        if (data === 'berhasil') {
          window.location.href = '{{ url("/kelas") }}';
        } else {
          $('#loading').hide();
          $('#notif').removeClass('alert-info').addClass('alert alert-danger').html(data).show();
        }
      }
    });
  });
});
</script>
@endsection
 
