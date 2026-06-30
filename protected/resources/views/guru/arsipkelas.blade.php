@extends('layouts/guru_baru')
@section('title', 'Arsip Kelas')
@section('content')
<script src="{{ url('/assets/assets/vendor/jquery.min.js') }}"></script>
<?php include(app_path().'/functions/koneksi.php'); ?>

<div class="col-sm-12 col-md-12 dash-left">
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
        Klik <b>Aktifkan</b> untuk mengembalikan kelas beserta siswanya.
      </div>

      <div id="notif" style="display:none; margin-bottom:10px"></div>

      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th style="width:40px">#</th>
              <th>Nama Kelas</th>
              <th style="width:130px">Jumlah Siswa</th>
              <th style="width:160px; text-align:center">Aksi</th>
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

<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(document).on('click', '.btn-aktifkan', function() {
  var id   = $(this).data('id');
  var nama = $(this).data('nama');
  if (!confirm('Aktifkan kembali kelas "' + nama + '"? Semua siswa di kelas ini juga akan ikut diaktifkan.')) return;
  $.post('{{ url("/aktifkankelas") }}', { id_kelas: id }, function(res) {
    if (res === 'berhasil') {
      $('#baris-' + id).fadeOut(400, function(){ $(this).remove(); });
      $('#notif').removeClass('alert-danger').addClass('alert alert-success')
        .html('<i class="fa fa-check"></i> Kelas "' + nama + '" berhasil diaktifkan kembali.').show();
    } else {
      $('#notif').removeClass('alert-success').addClass('alert alert-danger')
        .html('Gagal mengaktifkan kelas.').show();
    }
  });
});
</script>
@endsection
