@extends('layouts/guru_baru')
@section('title', 'Arsip Kelas')
@section('content')
<script src="{{ url('/assets/assets/vendor/jquery.min.js') }}"></script>
<?php
  include(app_path().'/functions/koneksi.php');
  $bulanpendek = ['01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun','07'=>'Jul','08'=>'Agu','09'=>'Sep','10'=>'Okt','11'=>'Nov','12'=>'Des'];
?>

{{-- KONTEN KIRI --}}
<div class="col-sm-12 col-md-8 col-lg-8 dash-left">
  <ol class="breadcrumb">
    <li><a href="{{ url('/guru') }}">Home</a></li>
    <li><a href="{{ url('/kelas') }}">Kelas</a></li>
    <li class="active">Arsip Kelas</li>
  </ol>

  <div class="panel panel-default">
    <div class="panel-heading" style="background:#072047; color:#fff">Arsip Kelas</div>
    <div class="panel-body">

      <div class="alert alert-warning" style="margin-bottom:15px">
        <i class="fa fa-info-circle"></i> Kelas yang diarsipkan tidak akan tampil di menu Kelas utama.
        Klik <b>Aktifkan</b> untuk mengembalikan kelas beserta siswanya, atau <b>Hapus</b> untuk menghapus permanen.
      </div>

      <div id="notif" style="display:none; margin-bottom:10px"></div>

      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th style="width:40px">#</th>
              <th>Nama Kelas</th>
              <th style="width:120px">Jumlah Siswa</th>
              <th style="width:200px; text-align:center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = $kelas_arsip->firstItem(); ?>
            @if($kelas_arsip->count())
            @foreach($kelas_arsip as $k)
            <tr id="baris-{{ $k->id }}">
              <td>{{ $no++ }}</td>
              <td>{{ $k->nama }} <span class="label label-default">Diarsipkan</span></td>
              <td align="center">
                <?php
                  $conn2 = new mysqli($hostdb, $userdb, $passdb, $namedb);
                  $sql_s = $conn2->query("SELECT COUNT(*) AS total FROM users WHERE id_kelas='".$k->id."' AND status='S'");
                  while($rs = $sql_s->fetch_assoc()){ echo '<b>'.$rs['total'].'</b>'; }
                  $conn2->close();
                ?>
              </td>
              <td style="text-align:center">
                <button class="btn btn-success btn-xs btn-aktifkan" data-id="{{ $k->id }}" data-nama="{{ $k->nama }}">
                  <i class="fa fa-undo"></i> Aktifkan
                </button>
                <button class="btn btn-danger btn-xs btn-hapus-permanen" data-id="{{ $k->id }}" data-nama="{{ $k->nama }}">
                  <i class="fa fa-trash"></i> Hapus
                </button>
              </td>
            </tr>
            @endforeach
            @else
            <tr><td colspan="4" class="alert alert-info text-center">Belum ada kelas yang diarsipkan.</td></tr>
            @endif
          </tbody>
        </table>
        {!! $kelas_arsip->render() !!}
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

<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

function refreshAktifitas() {
  $.get('{{ url("/ajax/get-aktifitas") }}', function(html) {
    $('#panel-aktifitas').hide().html(html).fadeIn(400);
  });
}

// Aktifkan kembali
$(document).on('click', '.btn-aktifkan', function() {
  var id   = $(this).data('id');
  var nama = $(this).data('nama');
  if (!confirm('Aktifkan kembali kelas "' + nama + '"? Semua siswa di kelas ini juga akan ikut diaktifkan.')) return;
  $.post('{{ url("/aktifkankelas") }}', { id_kelas: id }, function(res) {
    if (res === 'berhasil') {
      $('#baris-' + id).fadeOut(400, function(){ $(this).remove(); });
      $('#notif').removeClass('alert-danger').addClass('alert alert-success')
        .html('<i class="fa fa-check"></i> Kelas "' + nama + '" berhasil diaktifkan kembali.').show();
      refreshAktifitas();
    } else {
      $('#notif').removeClass('alert-success').addClass('alert alert-danger')
        .html('Gagal mengaktifkan kelas.').show();
    }
  });
});

// Hapus permanen
$(document).on('click', '.btn-hapus-permanen', function() {
  var id   = $(this).data('id');
  var nama = $(this).data('nama');
  if (!confirm('HAPUS PERMANEN kelas "' + nama + '" beserta seluruh siswa di dalamnya?\\n\\nTindakan ini tidak bisa dibatalkan!')) return;
  $.post('{{ url("/hapusarsipkelas") }}', { id_kelas: id }, function(res) {
    if (res === 'berhasil') {
      $('#baris-' + id).fadeOut(400, function(){ $(this).remove(); });
      $('#notif').removeClass('alert-danger').addClass('alert alert-success')
        .html('<i class="fa fa-check"></i> Kelas "' + nama + '" beserta siswanya berhasil dihapus permanen.').show();
      refreshAktifitas();
    } else {
      $('#notif').removeClass('alert-success').addClass('alert alert-danger')
        .html('Gagal menghapus kelas.').show();
    }
  });
});
</script>
@endsection
