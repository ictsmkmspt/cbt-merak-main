<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;
use Input;
use Session;
use Validator;
use File;
use DB;

use App\User;
use App\School;
use App\Soal;
use App\Jawab;
use App\Detailsoal;
use App\Distribusisoal;
use App\Countexamtime;
use App\Pelanggaran;

class SiswaController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('singlesession');
  }

  public function index()
  {
    if (Auth::user()->status == "S" or Auth::user()->status =="C") {
      $user = User::join('kelas', 'users.id_kelas', '=', 'kelas.id')
                      ->select('kelas.nama as nama_kelas', 'users.*')
                      ->where('users.id', Auth::user()->id)->first();
      $sekolah = School::where('id', 1)->first();

      // halt tidak bebasadmin sekolah
      if (!$this->bebasAdmin()) { return redirect('bebasadmin');}

      return view('siswa.index', compact('user', 'sekolah'));
    }else{
      return redirect('guru');
    }
  }

  public function profil()
  {
    if (Auth::user()->status == "S" or Auth::user()->status =="C") {
      $user = User::join('kelas', 'users.id_kelas', '=', 'kelas.id')
                  ->select('kelas.nama as nama_kelas', 'users.*')
                  ->where('users.id', Auth::user()->id)->first();
      $school = School::first();

      // halt tidak bebasadmin sekolah
      if (!$this->bebasAdmin()) { return redirect('bebasadmin');}

      return view('siswa.profil', compact('user', 'school'));
    }else{
      return redirect('guru');
    }
  }

  public function updateprofil()
  {
      if(Request::ajax()){
          $nama = Input::get('nama');
          $nis = Input::get('nis');
          $jk = Input::get('jk');
          $password = Input::get('password');
          $passwordsimpan = bcrypt(Input::get('password'));
          if($password != ""){
              $user = User::where('id', '=', Auth::user()->id)->first();
              $user->nama = Input::get('nama');
              $user->no_induk = Input::get('nis');
              $user->jk = Input::get('jk');
              $user->password = $passwordsimpan;
              $user->save();
              return ('berhasil');
          }else{
              $user = User::where('id', '=', Auth::user()->id)->first();
              $user->nama = Input::get('nama');
              $user->no_induk = Input::get('nis');
              $user->jk = Input::get('jk');
              $user->save();
              return ('berhasil');
          }
      }
  }

  public function updateprofilfoto()
  {
      if(Request::ajax()){
          if(isset($_FILES["file"]["type"])){
              $validextensions = array("jpeg", "jpg", "png");
              $temporary = explode(".", $_FILES["file"]["name"]);
              $file_extension = end($temporary);

              if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
              ) && ($_FILES["file"]["size"] < 1000000)//Approx. 1000kb files can be uploaded.
              && in_array($file_extension, $validextensions)) {
                  if ($_FILES["file"]["error"] > 0){
                      echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
                  }else{
                      if (file_exists(url('/img/') . $_FILES["file"]["name"])) {
                          echo $_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
                      }else{
                          $uniqname = date('ymdhis').rand(00000,99999);
                          $sourcePath = $_FILES['file']['tmp_name'];
                          $targetPath = "img/".$uniqname.$_FILES['file']['name'];
                          move_uploaded_file($sourcePath,$targetPath);

                          $user = User::where('id', '=', Auth::user()->id)->first();
                          File::delete('img/'.$user->gambar);
                          $user->gambar = $uniqname.$_FILES["file"]["name"];

                          $user->save();

                          echo "<span id='success'>Foto berhasil di upload...!! <i>Refresh</i> halaman untuk melihat hasilnya...</span><br/>";
                          echo "<br/><b>File Name:</b> " . $_FILES["file"]["name"] . "<br>";
                          echo "<b>Type:</b> " . $_FILES["file"]["type"] . "<br>";
                          echo "<b>Size:</b> " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
                      }
                  }
              }else{
                  echo "<span id='invalid'>***Terdapat kesalahan dalam hal jenis file maupun ukuran yang melebihi batas. Maksimal ukuran file yang diterima adalah 1Mb***<span>";
              }
          }
      }
  }

  public function soal()
  {
      if (Auth::user()->status == "S" or Auth::user()->status =="C") {
          $user = User::where('email', '=', Auth::user()->email)->first();
          $school = School::first();
        
          // halt tidak bebas admin sekolah
          if (!$this->bebasAdmin()) { return redirect('bebasadmin');}
	    $distribusisoal = Distribusisoal::join('soals', 'distribusisoals.id_soal', '=', 'soals.id')
                                        ->select('soals.paket', 'soals.deskripsi', 'soals.kkm', 'soals.waktu', 'soals.token_ujian', 'soals.id as id_soal', 'distribusisoals.*')
                                        ->where('distribusisoals.id_kelas', Auth::user()->id_kelas)->get();
          // meztr : warning unused variable $soals
          // $soals = Soal::all();
          // return view('siswa.soal', compact('user', 'school', 'soals', 'distribusisoal'));
          return view('siswa.soal', compact('user', 'school', 'distribusisoal'));
      }else{
          return redirect('guru');
      }
  }

  protected function bebasAdmin() {
    $sekolah = School::where('id', 1)->first();
    if (Auth::user()->sekolah_asal == "disabled" && $sekolah->bypass_ujian == 0) {
      return false;
    }
    return true;
  }

  // [FIXED] bug Rizky
  protected function validateDistribusiSoalByKelas($idsoal, $iduser, $kelas) {
    $queryDistributed = Distribusisoal::where('id_kelas', $kelas)->where('id_soal', $idsoal)->first();

    if ($queryDistributed) {
     $cekJawab = Jawab::where('id_soal', $idsoal)->where('id_user', $iduser)->first();
     if (!$cekJawab) {
       return true;
     } else {
       return false;
     }
    } else {
     return false;
    }
	// return $queryDistributed;
  }

  // BUG: Rizky -> soal yang dikunci karena sudah dikerjakan bisa terbuka lewat url ..1)
  //                dan bug : soal yang tidak terdistribusi kelas bisa terbuka ..2)
  public function detailsoal($id)
  {
  if (Auth::user()->status == "S" or Auth::user()->status == "C") {
      $idsoal = $id;
      $kelas = Auth::user()->id_kelas;
      $iduser = Auth::user()->id;
      
      // halt tidak bebas admin sekolah
      if (!$this->bebasAdmin()) { return redirect('bebasadmin');}


      //meztr: fixing bug url bypass 
      // if (!$this->validateDistribusiSoalByKelas($idsoal, $iduser, $kelas)) {
        // force to return to beranda
        // return redirect('soal-siswa/forbidden');
      // }

      $soal = Soal::where('id', $id)->first();

      // Latihan (jenis = 2) hanya boleh dikerjakan 1 kali.
      if ($soal && $soal->jenis == 2) {
        $sudahSelesai = Jawab::where('id_soal', $id)
                              ->where('id_user', $iduser)
                              ->where('status', 'Y')
                              ->exists();
        if ($sudahSelesai) {
          return redirect('/latihan')->with('info_latihan', 'Latihan "'.$soal->paket.'" sudah pernah Anda kerjakan. Latihan hanya dapat dikerjakan 1 kali.');
        }
      }

      // Ujian dengan token: siswa harus verifikasi token dulu sebelum masuk soal.
      if ($soal && $soal->token_ujian && Session::get('token_verified_'.$id) != 'Y') {
        return redirect('/verifikasi-token/'.$id);
      }

      $soals = Detailsoal::where('id_soal', $id)->orderBy(DB::raw('RAND()'))->get();
      $user = User::where('id', Auth::user()->id)->first();
      $school = School::first();

      $detailsoal = Detailsoal::join('soals', 'detailsoals.id_soal', '=', 'soals.id')
                      ->select('soals.paket', 'soals.waktu', 'detailsoals.*')
                      ->where('detailsoals.id_soal', $id)
                      ->orderBy(DB::raw('RAND()'))->first();

      // Soal belum punya butir pertanyaan sama sekali -> jangan tampilkan halaman ujian,
      // arahkan balik dengan pesan yang jelas.
      if (!$detailsoal || $soals->count() == 0) {
        $tujuan = ($soal && $soal->jenis == 2) ? '/latihan' : '/soal-siswa';
        return redirect($tujuan)->with('info_soal_kosong', 'Paket soal "'.($soal ? $soal->paket : '').'" belum memiliki butir pertanyaan. Hubungi guru untuk melengkapi soal ini.');
      }
      $jumlah_soal = Detailsoal::where('id_soal', $id)->get();
      // $soal = null;
      $countexamtime = Countexamtime::where('id_soal', $id)->where('id_user', Auth::user()->id)->first();
      return view('siswa.detail_soal', compact('idsoal', 'soals', 'user', 'school', 'soal', 'detailsoal', 'jumlah_soal', 'countexamtime'));
    }else{
        return redirect('guru');
    }
  }
  public function get_soal($id)
  {
    $detailsoal = Detailsoal::join('soals', 'detailsoals.id_soal', '=', 'soals.id')
                                      ->select('soals.paket', 'soals.deskripsi', 'soals.kkm', 'soals.id as id_soal', 'detailsoals.*')
                                      ->where('detailsoals.id', $id)->first();
    $cek_jawaban = Jawab::where('no_soal_id', $id)->where('id_user', Auth::user()->id)->first();
    return view('siswa.ajax.get_soal', compact('detailsoal', 'cek_jawaban'));
  }


  public function simpanjawabankliksiswa()
  {
    $pilihan = Input::get('pilihan');
    $id_soal = Input::get('id_soal');
    $no_soal_id = Input::get('no_soal_id');

    $q_user = User::where('id', Auth::user()->id)->first();
    $q_detail_soal = Detailsoal::where('id', $no_soal_id)->first();
    $q_cek_jawaban = Detailsoal::where('id', $no_soal_id)->where('kunci', $pilihan)->first();
    if ($q_cek_jawaban != "") {
      $score = $q_cek_jawaban->score;
    }else{
      $score = 0;
    }
    $q_jawab = Jawab::where('no_soal_id', $no_soal_id)
                      ->where('id_soal', $id_soal)
                      ->where('id_user', Auth::user()->id)->first();
    if ($q_jawab != '') {
      $q_jawab->no_soal_id = $no_soal_id;
      $q_jawab->id_soal = $id_soal;
      $q_jawab->id_user = Auth::user()->id;
      $q_jawab->id_kelas = $q_user->id_kelas;
      $q_jawab->nama = $q_user->nama;
      $q_jawab->pilihan = $pilihan;
      $q_jawab->score = $score;
      $q_jawab->status = 'N';
      $q_jawab->save();
      return $pilihan;
    }else{
      $query = new Jawab;
      $query->no_soal_id = $no_soal_id;
      $query->id_soal = $id_soal;
      $query->id_user = Auth::user()->id;
      $query->id_kelas = $q_user->id_kelas;
      $query->nama = $q_user->nama;
      $query->pilihan = $pilihan;
      $query->score = $score;
      $query->status = 'N';
      $query->save();
      return $pilihan;
    }
  }



  public function simpanjawabankliksiswas()
  {
    $no_soal_id = Input::get('no_soal_id');
    $id_soal = Input::get('id_soal');
    $id_user = Input::get('id_user');
    $pilihan = Input::get('pilihan');

    $users = User::where('id', '=', Input::get('id_user'))->first();
    //cek kebenaran jawaban
    $soals = Detailsoal::where('id', '=', $no_soal_id)->where('kunci', '=', $pilihan)->get();
    $hasil = count($soals);

    //cek pernah jawab
    $cekjawabs = Jawab::where('no_soal_id', '=', $no_soal_id)->where('id_user', '=', $id_user)->get();
    $hasilcekjawab = count($cekjawabs);

    if ($hasilcekjawab == 1) {
      $ceksoals = Detailsoal::where('id', '=', $no_soal_id)->get();
      foreach ($ceksoals as $soal) {
        $score = $soal->score;
        if($hasil==1){
          $simpanjawab = Jawab::where('no_soal_id', '=', $no_soal_id)->where('id_user', '=', $id_user)->first();
          $simpanjawab->no_soal_id = Input::get('no_soal_id');
          $simpanjawab->id_soal = Input::get('id_soal');
          $simpanjawab->id_user = Input::get('id_user');
          
          $simpanjawab->id_kelas = $users->id_kelas;
          $simpanjawab->nama = $users->nama;

          $simpanjawab->pilihan = Input::get('pilihan');
          $simpanjawab->score = $score;
          $simpanjawab->status = 'N';
          $simpanjawab->save();
        }else{
          $simpanjawab = Jawab::where('no_soal_id', '=', $no_soal_id)->where('id_user', '=', $id_user)->first();
          $simpanjawab->no_soal_id = Input::get('no_soal_id');
          $simpanjawab->id_soal = Input::get('id_soal');
          $simpanjawab->id_user = Input::get('id_user');

          $simpanjawab->id_kelas = $users->id_kelas;
          $simpanjawab->nama = $users->nama;
          
          $simpanjawab->pilihan = Input::get('pilihan');
          $simpanjawab->score = 0;
          $simpanjawab->status = 'N';
          $simpanjawab->save();
        }
      }
    }else{
      $ceksoals = Detailsoal::where('id', '=', $no_soal_id)->get();
      foreach ($ceksoals as $soal) {
        $score = $soal->score;
        if($hasil==1){
          $simpanjawab = new Jawab;
          $simpanjawab->no_soal_id = Input::get('no_soal_id');
          $simpanjawab->id_soal = Input::get('id_soal');
          $simpanjawab->id_user = Input::get('id_user');

          $simpanjawab->id_kelas = $users->id_kelas;
          $simpanjawab->nama = $users->nama;

          $simpanjawab->pilihan = Input::get('pilihan');
          $simpanjawab->score = $score;
          $simpanjawab->status = 'N';
          $simpanjawab->save();
        }else{
          $simpanjawab = new Jawab;
          $simpanjawab->no_soal_id = Input::get('no_soal_id');
          $simpanjawab->id_soal = Input::get('id_soal');
          $simpanjawab->id_user = Input::get('id_user');

          $simpanjawab->id_kelas = $users->id_kelas;
          $simpanjawab->nama = $users->nama;
          
          $simpanjawab->pilihan = Input::get('pilihan');
          $simpanjawab->score = 0;
          $simpanjawab->status = 'N';
          $simpanjawab->save();
        }
      }
    }
    return ($pilihan);
  }

  // ===== SIMPAN JAWABAN ESSAY (auto-save) =====
  public function simpan_jawaban_essay()
  {
    $jawaban_essay = Input::get('jawaban_essay');
    $id_soal       = Input::get('id_soal');
    $no_soal_id    = Input::get('no_soal_id');
    $q_user        = User::where('id', Auth::user()->id)->first();

    $q_jawab = Jawab::where('no_soal_id', $no_soal_id)
                    ->where('id_soal', $id_soal)
                    ->where('id_user', Auth::user()->id)->first();

    if ($q_jawab != '') {
      $q_jawab->jawaban_essay  = $jawaban_essay;
      $q_jawab->nilai_essay    = null;
      $q_jawab->status_koreksi = 'belum';
      $q_jawab->pilihan        = '-';
      $q_jawab->status         = 'N';
      $q_jawab->save();
    } else {
      $query = new Jawab;
      $query->no_soal_id    = $no_soal_id;
      $query->id_soal       = $id_soal;
      $query->id_user       = Auth::user()->id;
      $query->id_kelas      = $q_user->id_kelas;
      $query->nama          = $q_user->nama;
      $query->pilihan       = '-';
      $query->score         = 0;
      $query->jawaban_essay = $jawaban_essay;
      $query->status_koreksi= 'belum';
      $query->status        = 'N';
      $query->save();
    }
    return 'ok';
  }

  public function kirimjawaban()
  {
    $id_soal = Input::get('id_soal');
    $this->finalisasiJawaban($id_soal, Auth::user()->id, false);
  }

  // dipanggil dari kirimjawaban() manual ATAU otomatis saat waktu habis
  private function finalisasiJawaban($id_soal, $id_user, $karena_waktu_habis = false)
  {
    $cek_jawaban = Jawab::where('id_soal', $id_soal)
                          ->where('id_user', $id_user)
                          ->get();

    if ($cek_jawaban->count() == 0) {
      // Siswa tidak menjawab satupun soal. Tetap buat baris jawaban kosong
      // untuk tiap butir soal, supaya ujian tercatat SELESAI dengan nilai 0,
      // bukan hilang tanpa jejak.
      $user_siswa  = User::where('id', $id_user)->first();
      $detailsoals = Detailsoal::where('id_soal', $id_soal)->get();

      foreach ($detailsoals as $ds) {
        $query = new Jawab;
        $query->no_soal_id = $ds->id;
        $query->id_soal    = $id_soal;
        $query->id_user    = $id_user;
        $query->id_kelas   = $user_siswa ? $user_siswa->id_kelas : null;
        $query->nama       = $user_siswa ? $user_siswa->nama : '';
        $query->pilihan    = '-';
        $query->score      = 0;
        $query->status     = 'Y';
        if ($karena_waktu_habis) {
          $query->status_habis_waktu = 'Y';
        }
        $query->save();
      }
      return;
    }

    foreach ($cek_jawaban as $value) {
      if ($value->status == 'Y') continue; // sudah pernah difinalisasi, jangan diulang
      $value->status = 'Y';
      if ($karena_waktu_habis) {
        $value->status_habis_waktu = 'Y';
      }
      $value->save();
    }
  }

  public function hasil_siswa()
  {
    $school = School::first();
    $user = User::where('id', '=', Auth::user()->id)->first();
    $jawabs = Jawab::join('soals', 'jawabs.id_soal', '=', 'soals.id')
            ->select(['jawabs.id', 'jawabs.id_user', 'soals.id as id_soal', 'soals.paket', 'soals.deskripsi', 'soals.kkm', 'soals.jenis as jenis_soal', 'jawabs.created_at', 'jawabs.updated_at',
              \DB::raw('sum(jawabs.score) as count')])
            ->where('jawabs.id_user', Auth::user()->id)
            ->where('status', 'Y')
            // Nilai UJIAN (jenis != 2) hanya tampil kalau sudah dipublikasikan guru.
            // Nilai LATIHAN (jenis = 2) selalu tampil langsung, tidak terpengaruh publikasi.
            ->where(function($q) {
                $q->where('soals.jenis', 2)
                  ->orWhere('soals.status_publikasi', 'Y');
            })
            ->orderby('jawabs.id', 'desc')
            ->groupby('id_soal')->paginate(10);
    return view('siswa.hasil', compact('user', 'school', 'jawabs'));
  }
  public function get_hasil()
  {
    $q = Input::get('q');
    $jawabs = Jawab::join('soals', 'jawabs.id_soal', '=', 'soals.id')
            ->select(['jawabs.id', 'jawabs.id_user', 'soals.id as id_soal', 'soals.paket', 'soals.deskripsi', 'soals.kkm', 'jawabs.created_at', 'jawabs.updated_at',
              \DB::raw('sum(jawabs.score) as count')])
            ->where('jawabs.id_user', Auth::user()->id)
            ->where('jawabs.status', 'Y')
            ->where('soals.paket', 'LIKE', '%'.$q.'%')
            ->where(function($qq) {
                $qq->where('soals.jenis', 2)
                   ->orWhere('soals.status_publikasi', 'Y');
            })
            ->orderby('jawabs.id', 'desc')
            ->groupby('jawabs.id_soal')->paginate(10);
    return view('siswa.ajax.get_hasil', compact('jawabs'));
  }

  public function detailujian($id)
  {
    if (Auth::user()->status == "S" or Auth::user()->status =="C") {
      $user = User::where('email', Auth::user()->email)->first();
      $soal = Soal::where('id', '$id')->first();
      $soals = Soal::where('id', '!=', '$id')->get();
      $idsoal = $id;
      /*$users = join('jawabs', 'users.id_user', '=', 'jawabs.id')
                ->select('ja')*/
      return view('siswa.detail', compact('user', 'idsoal', 'soal', 'soals'));
    }else{
        return redirect('guru');
    }
  }

  public function detail_hasil_siswa($id)
  {
    if (Auth::user()->status == "S" or Auth::user()->status =="C") {
      $user = User::where('email', Auth::user()->email)->first();
      $soal = Soal::where('id', $id)->first();
      $soals = Soal::where('id', '!=', $id)->get();
      $idsoal = $id;

      $jawabs = Jawab::join('detailsoals', 'jawabs.no_soal_id', '=', 'detailsoals.id')
                        ->select('detailsoals.soal', 'detailsoals.kunci', 'detailsoals.pila', 'detailsoals.pilb', 'detailsoals.pilc', 'detailsoals.pild', 'detailsoals.pile', 'jawabs.*')
                        ->where('jawabs.id_soal', $id)
                        ->where('jawabs.id_user', Auth::user()->id)
                        ->get();

      return view('siswa.detail', compact('user', 'idsoal', 'soal', 'soals', 'jawabs'));
    }else{
        return redirect('guru');
    }
  }
  

  public function test()
  {
    $user = User::first();
    $users = User::where('id', '!=', $user->id)->get();

    return view('siswa.test', compact('user', 'users'));
  }

  public function nilai()
  {
    $users = User::paginate(10);
    return view('siswa.nilai', compact('users'));
  }

  public function countexamtime()
  {
    $id_soal = Input::get('id_soal');
    $id_user = Auth::user()->id;
    $soal    = Soal::where('id', $id_soal)->first();
    $cek     = Countexamtime::where('id_soal', $id_soal)->where('id_user', $id_user)->first();

    if ($cek == '') {
      // ping pertama kali -> tetapkan jam berakhirnya ujian, SEKALI SAJA
      $query = new Countexamtime;
      $query->id_soal        = $id_soal;
      $query->id_user        = $id_user;
      $query->waktu          = $soal->waktu;
      $query->waktu_selesai  = Carbon::now()->addSeconds((int) $soal->waktu);
      $query->save();

      return response()->json(['status' => 'baru', 'sisa_detik' => (int) $soal->waktu]);
    }

    // hitung sisa waktu dari timestamp, BUKAN dari pengurangan manual
    $sisa_detik = Carbon::now()->diffInSeconds(Carbon::parse($cek->waktu_selesai), false);

    if ($sisa_detik <= 0) {
      // waktu sudah habis -> paksa finalisasi jawaban walau siswa tidak submit manual
      $this->finalisasiJawaban($id_soal, $id_user, true);
      return response()->json(['status' => 'habis', 'sisa_detik' => 0]);
    }

    return response()->json(['status' => 'jalan', 'sisa_detik' => $sisa_detik]);
  }
  
  public function logPelanggaran()
  {
    $id_soal = Input::get('id_soal');
    $jenis   = Input::get('jenis'); // 'keluar_tab' atau 'keluar_fullscreen'
    $id_user = Auth::user()->id;

    if (!in_array($jenis, ['keluar_tab', 'keluar_fullscreen'])) {
      return response()->json(['status' => 'invalid'], 400);
    }

    $log = new Pelanggaran;
    $log->id_soal = $id_soal;
    $log->id_user = $id_user;
    $log->jenis   = $jenis;
    $log->save();

    return response()->json(['status' => 'ok']);
  }

  public function formTokenUjian($id)
  {
    if (Auth::user()->status == "S" or Auth::user()->status =="C") {
      $soal = Soal::where('id', $id)->first();
      if (!$soal || !$soal->token_ujian) {
        return redirect('/soal-siswa/'.$id);
      }
      if (Session::get('token_verified_'.$id) == 'Y') {
        return redirect('/soal-siswa/'.$id);
      }
      $user = User::where('id', Auth::user()->id)->first();
      $school = School::first();
      return view('siswa.token_ujian', compact('soal', 'user', 'school'));
    }else{
      return redirect('guru');
    }
  }

  public function cekTokenUjian($id)
  {
    $soal = Soal::where('id', $id)->first();
    $input_token = trim(Input::get('token'));

    if ($soal && $soal->token_ujian && strcasecmp($soal->token_ujian, $input_token) == 0) {
      Session::put('token_verified_'.$id, 'Y');
      return redirect('/soal-siswa/'.$id);
    }

    return redirect('/verifikasi-token/'.$id)->with('error_token', 'Token yang Anda masukkan salah. Silakan tanyakan token ujian ke guru/pengawas.');
  }

}
