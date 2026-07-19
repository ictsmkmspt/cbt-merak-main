<?php

namespace App\Http\Controllers;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Input;
use Auth;
use File;
use Datatables;
use PhpExcelReader;
use Spreadsheet_Excel_Reader;
use mysqli;
use Excel;
use DB;
use Carbon\Carbon;

use App\User;
use App\School;
use App\Kelas;
use App\Jawab;
use App\Aktifitas;
use App\Soal;
use App\Detailsoal;
use App\Distribusisoal;
use App\Countexamtime;
use App\Pelanggaran;

class HasilController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function hasil_guru()
  {
    if (Auth::user()->status == "G" or Auth::user()->status == "A" or Auth::user()->status == "P") {
      $school = School::first();
      $user = User::where('email', '=', Auth::user()->email)->first();
      $kelas = Kelas::orderby('nama', 'asc')->get();
      $id_user = Auth::user()->id;

      // Tampilkan SEMUA paket soal (baik yang sudah ada aktivitas maupun belum),
      // diurutkan dari yang paling baru dibuat.
      $query = Soal::select('soals.*', DB::raw('soals.id as id_soal'))
                    ->orderBy('soals.created_at', 'desc');

      if (Auth::user()->status == "G") {
        $query->where('soals.id_user', Auth::user()->id);
      }

      $jawabs = $query->paginate(30);

      if (Auth::user()->status == "A" or Auth::user()->status == "P"){
        $soals = Soal::paginate(30);
      }elseif (Auth::user()->status == "G") {
        $soals = Soal::where('id_user', $id_user)->paginate(30);
      }else{
        $soals = collect();
      }
      return view('guru.hasil', compact('user', 'school', 'jawabs', 'kelas', 'soals'));
    }else{
      return redirect('siswa');
    }
  }

  public function get_hasil_guru()
  {
    if (Auth::user()->status == "G" or Auth::user()->status == "A" or Auth::user()->status == "P") {
      $user = User::where('id', '=', Auth::user()->id)->first();
      $q = Input::get('q');
      $id_user = Auth::user()->id;

      $query = Soal::select('soals.*', DB::raw('soals.id as id_soal'))
                    ->where('soals.paket', 'LIKE', '%'.$q.'%')
                    ->orderBy('soals.created_at', 'desc');

      if (Auth::user()->status == "G") {
        $query->where('soals.id_user', Auth::user()->id);
      }

      $jawabs = $query->paginate(15);

      return view('guru.ajax.get_hasil_guru', compact('jawabs', 'user'));
    }else{
      return redirect('siswa');
    }
  }

  public function anyData()
  {
    if (Auth::user()->status == "G" or Auth::user()->status == "A" or Auth::user()->status == "P") {
      $id_user = Auth::user()->id;
      if (Auth::user()->status == "A") {
          $jawab = Jawab::join('soals', 'jawabs.id_soal', '=', 'soals.id')->select(['jawabs.id', 'jawabs.id_soal', 'soals.paket', 'soals.deskripsi', 'soals.kkm', 'soals.waktu', 'jawabs.created_at', 'jawabs.updated_at'])->groupby('jawabs.id_soal');
      }else{
          $jawab = Jawab::join('soals', 'jawabs.id_soal', '=', 'soals.id')->select(['jawabs.id', 'jawabs.id_soal', 'soals.paket', 'soals.deskripsi', 'soals.kkm', 'soals.waktu', 'jawabs.created_at', 'jawabs.updated_at'])->where('soals.id_user', '=', Auth::user()->id)->groupby('jawabs.id_soal');
      }

      return Datatables::of($jawab)
          ->addColumn('action', function ($jawab) {
              return '<a href=detail-hasil/'.$jawab->id_soal.' class="btn btn-xs btn-primary"><i class="fa fa-search"></i> Detail</a>';
          })
          ->editColumn('waktu', '{{$waktu / 60}} menit')
          ->make(true);
    }else{
      return redirect('siswa');
    }
  }

  public function detailhasil($id)
  {
    if (Auth::user()->status == "G" or Auth::user()->status == "A" or Auth::user()->status == "P") {
      $school = School::first();
      $user = User::where('email', '=', Auth::user()->email)->first();
      $soal = Soal::where('id', '=', $id)->first();
      $jawab = Jawab::where('id_soal', '=', $id)->groupBy('id_kelas')->first();
      if($jawab != ""){
        $user_siswa = User::where('id', '=', $jawab->id_user)->first();
      }else{
        $user_siswa = 'N';
      }
      $aktifitas = Aktifitas::join('users', 'aktifitas.id_user', '=', 'users.id')
                              ->select('users.nama as nama_user', 'users.gambar', 'aktifitas.*')
                              ->orderby('aktifitas.id', 'desc')->limit(3)->get();

      // 1) Kelas yang siswanya sudah punya jawaban tersimpan
      $jawabs = Jawab::join('kelas', 'jawabs.id_kelas', '=', 'kelas.id')
                        ->select('kelas.nama as nama_kelas', 'kelas.id as id_kelas', 'jawabs.*')
                        ->where('jawabs.id_soal', $id)
                        ->orderBy('kelas.id')
                        ->groupBy('jawabs.id_kelas')->get();

      // 2) Kelas dari siswa yang SUDAH MEMBUKA soal (ada di countexamtimes)
      //    tapi belum menjawab satupun pertanyaan, supaya kelasnya tetap muncul.
      $idKelasSudahAda = $jawabs->pluck('id_kelas')->toArray();
      $idUserBukaSoal = DB::table('countexamtimes')->where('id_soal', $id)->distinct()->lists('id_user');

      if (count($idUserBukaSoal)) {
        $kelasBelumJawab = User::whereIn('id', $idUserBukaSoal)
                                ->whereNotNull('id_kelas')
                                ->whereNotIn('id_kelas', $idKelasSudahAda)
                                ->select('id_kelas')
                                ->distinct()
                                ->get();

        foreach ($kelasBelumJawab as $k) {
          $kelasInfo = Kelas::where('id', $k->id_kelas)->first();
          if ($kelasInfo) {
            $jawabs->push((object)[
              'id_kelas'   => $kelasInfo->id,
              'nama_kelas' => $kelasInfo->nama,
              'id_soal'    => $id,
            ]);
          }
        }
      }
      
      return view('guru.detailhasil', compact('user', 'school', 'soal', 'jawabs', 'user_siswa', 'aktifitas'));
    }else{
      return redirect('siswa');
    }
  }

  public function downloadlaporanperkelas($id, $id_soal)
  {
    $jawabs = Jawab::join('users', 'jawabs.id_user', '=', 'users.id')
                      ->select('users.no_induk as nis', 'users.nama as nama_siswa', 'jawabs.*')
                      ->where('jawabs.id_kelas', $id)->where('jawabs.id_soal', $id_soal)
                      ->groupBy('jawabs.id_user')->get();
    $jawab = Jawab::join('kelas', 'jawabs.id_kelas', '=', 'kelas.id')
                    ->select('kelas.nama as nama_kelas', 'jawabs.*')
                    ->where('jawabs.id_kelas', $id)->first();
    // return view('guru.download_laporan_per_kelas', compact('jawab', 'jawabs'));

    Excel::create($jawab->nama_kelas, function($excel){
      $excel->sheet('1', function($sheet){
        $sheet->loadView('guru.download_laporan_per_kelas');
     });
    })->export('xls');
  }

  public function detailhasilsoal($id, $id_soal)
  {
    if (Auth::user()->status == "G" or Auth::user()->status == "A" or Auth::user()->status == "P") {
      $school = School::first();
      $user = User::where('id', Auth::user()->id)->first();
      $soal = Soal::where('id', $id_soal)->first();
      $kelas = Kelas::where('id', $id)->first();

      $jawabs = Jawab::where('id_kelas', $id)->where('id_soal', $id_soal)->groupBy('id_user')->get();

      // Tambahkan siswa di kelas ini yang SUDAH MEMBUKA soal tapi belum
      // menjawab satupun pertanyaan (tidak ada baris di jawabs sama sekali).
      $idUserSudahAda = $jawabs->pluck('id_user')->toArray();
      $idUserBukaSoal = DB::table('countexamtimes')->where('id_soal', $id_soal)->distinct()->lists('id_user');

      if (count($idUserBukaSoal)) {
        $siswaBelumJawab = User::whereIn('id', $idUserBukaSoal)
                                ->where('id_kelas', $id)
                                ->whereNotIn('id', $idUserSudahAda)
                                ->get();
        foreach ($siswaBelumJawab as $s) {
          $jawabs->push((object)[
            'id_kelas' => $id,
            'id_soal'  => $id_soal,
            'id_user'  => $s->id,
            'belum_ada_jawaban' => true,
          ]);
        }
      }

      $prosentasejawabs = Jawab::where('id_kelas', $id)->where('id_soal', $id_soal)->groupBy('no_soal_id')->get();
      
      return view('guru.detailhasilsoal', compact('user', 'school', 'soal', 'kelas', 'jawabs', 'prosentasejawabs'));
    }else{
      return redirect('siswa');
    }
  }

  // Guru/Admin memaksa hentikan ujian siswa yang sedang berlangsung (status jawaban masih 'N')
  public function hentikanUjianSiswa()
  {
    if (Auth::user()->status == "G" or Auth::user()->status == "A" or Auth::user()->status == "P") {
      $id_soal = Input::get('id_soal');
      $id_user = Input::get('id_user');

      // finalisasi paksa semua jawaban siswa untuk soal ini (sama seperti saat waktu habis)
      $jawabs = Jawab::where('id_soal', $id_soal)->where('id_user', $id_user)->get();
      foreach ($jawabs as $j) {
        if ($j->status == 'Y') continue;
        $j->status = 'Y';
        $j->save();
      }

      // set waktu_selesai ke masa lalu, supaya kalau tab siswa masih terbuka,
      // polling timer (tiap 5 detik) langsung mendeteksi status 'habis' dan auto-submit
      $cek = Countexamtime::where('id_soal', $id_soal)->where('id_user', $id_user)->first();
      if ($cek) {
        $cek->waktu_selesai = Carbon::now()->subSecond();
        $cek->save();
      }

      return response()->json(['status' => 'ok']);
    }else{
      return redirect('siswa');
    }
  }

  // Admin menghentikan SEMUA siswa yang sedang mengerjakan soal apapun, sekaligus
  public function hentikanUjianMassal()
  {
    if (Auth::user()->status == "A") {
      // Ambil semua kombinasi id_soal + id_user yang statusnya masih 'N' (sedang mengerjakan)
      $sedangUjian = Jawab::where('status', 'N')
                           ->select('id_soal', 'id_user')
                           ->distinct()
                           ->get();

      foreach ($sedangUjian as $item) {
        // finalisasi paksa jawaban kombinasi ini
        Jawab::where('id_soal', $item->id_soal)
             ->where('id_user', $item->id_user)
             ->where('status', 'N')
             ->update(['status' => 'Y']);

        // expire-kan waktu di countexamtimes hanya untuk kombinasi yang memang sedang aktif
        Countexamtime::where('id_soal', $item->id_soal)
                      ->where('id_user', $item->id_user)
                      ->update(['waktu_selesai' => Carbon::now()->subSecond()]);
      }

      return response()->json(['status' => 'ok', 'jumlah' => $sedangUjian->count()]);
    }else{
      return redirect('siswa');
    }
  }

  // Guru/Admin mempublikasikan nilai ujian supaya bisa dilihat siswa di menu hasil-siswa.
  // Hanya berlaku untuk soal jenis Ujian (jenis != 2). Latihan selalu tampil otomatis.
  public function publikasiNilai($id)
  {
    if (Auth::user()->status == "G" or Auth::user()->status == "A") {
      $soal = Soal::where('id', $id)->first();
      if ($soal && $soal->jenis != 2) {
        $soal->status_publikasi = 'Y';
        $soal->save();
      }
      return redirect()->back()->with('info_publikasi', 'Nilai paket soal "'.($soal ? $soal->paket : '').'" berhasil dipublikasikan dan sekarang bisa dilihat siswa.');
    }else{
      return redirect('siswa');
    }
  }

}
