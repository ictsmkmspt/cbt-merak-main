<?php
	$bulanpendek["01"] = "Jan";
	$bulanpendek["02"] = "Feb";
	$bulanpendek["03"] = "Mar";
	$bulanpendek["04"] = "Apr";
	$bulanpendek["05"] = "Mei";
	$bulanpendek["06"] = "Jun";
	$bulanpendek["07"] = "Jul";
	$bulanpendek["08"] = "Ags";
	$bulanpendek["09"] = "Sep";
	$bulanpendek["10"] = "Okt";
	$bulanpendek["11"] = "Nov";
	$bulanpendek["12"] = "Des";
?>
<table class="table table-bordered table-striped table-hover table-condensed" id="tabelsoal">
  <thead>
    <tr>
      <th style="text-align: center;">ID <small>Soal</small></th>
      <th style="width: 130px;">Materi</th>
      <th>Paket <small>Soal</small></th>
      <th>Deskripsi</th>
      <th>KKM</th>
      <th>Waktu</th>
      <th style="width: 90px; text-align: center;">Laporan</th>
      <th style="width: 160px; text-align: center;">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = $soals->firstItem(); ?>
    @if($soals->count())
    @foreach($soals as $soal)
    <?php
      if ($soal->jenis == 2 && $soal->nama_materi) {
        $materi_label = e($soal->nama_materi);
      } elseif ($soal->jenis == 2 && !$soal->nama_materi) {
        $materi_label = "<span class='text-muted'>Belum dipilih</span>";
      } else {
        $materi_label = "<span class='text-muted'>-</span>";
      }
    ?>
    <tr>
      <td style="text-align: center;">{{ $soal->id }}</td>
      <td style="font-size: 12px;">{!! $materi_label !!}</td>
      <td>{{ $soal->paket }}</td>
      <td>{{ $soal->deskripsi }}</td>
      <td>{{ $soal->kkm }}</td>
      <td>{{ $soal->waktu/60 }} menit</td>
      <td style="text-align: center;">
        <a href="{{ url('/detail-hasil/'.$soal->id) }}" class="btn btn-xs btn-info" data-toggle='tooltip' title="Lihat Laporan Paket Soal"><i class="fa fa-bar-chart"></i> Laporan</a>
        @if($soal->jenis == 2)
          <br>
          @if($soal->status_bagikan == 'Y')
            <a href="{{ url('/bagikan-latihan/'.$soal->id) }}" class="btn btn-xs btn-default" style="margin-top:4px;" onclick="return confirm('Tutup akses latihan ini? Siswa tidak akan bisa melihatnya lagi.');" data-toggle='tooltip' title="Klik untuk menutup akses siswa"><i class="fa fa-check-circle" style="color:#059669;"></i> Dibagikan</a>
          @else
            <a href="{{ url('/bagikan-latihan/'.$soal->id) }}" class="btn btn-xs btn-warning" style="margin-top:4px;" onclick="return confirm('Bagikan latihan ini ke siswa sekarang?');" data-toggle='tooltip' title="Latihan belum bisa dilihat siswa"><i class="fa fa-share-alt"></i> Bagikan Latihan</a>
          @endif
        @endif
      </td>
      <td style="text-align: center;">
        <a href="{{ url('/edit-soal/'.$soal->id) }}" class="btn btn-xs btn-success" data-toggle='tooltip' title="Ubah Soal"><i class="fa fa-pencil-square-o"></i></a>
        <a href="{{ url('/duplicate-soal/'.$soal->id) }}" class="btn btn-xs btn-success" data-toggle='tooltip' title="Duplikat Soal"><i class="fa fa fa-cubes"></i></a>
        <a href="{{ url('/detail-soal/'.$soal->id) }}" class="btn btn-xs btn-primary" data-toggle='tooltip' title="Detail Soal"><i class="fa fa-search"></i></a>
        <a href="{{ url('/hapus-soal/'.$soal->id) }}" class="btn btn-xs btn-danger" target="_blank" data-toggle='tooltip' title="Hapus Soal"><i class="fa fa-trash"></i></a>
      </td>
    </tr>
    @endforeach
    @else
    <tr><td colspan="8" class="alert alert-danger">Belum ada data untuk ditampilkan.</td></tr>
    @endif
  </tbody>
</table>
