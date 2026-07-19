<?php
namespace App\Http\Controllers;

use Auth;
use Input;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Soal;
use App\Detailsoal;
use App\Jawab;
use App\User;
use App\School;
use App\Aktifitas;

class EssayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Daftar paket soal yang punya butir essay
    public function index()
    {
        if (Auth::user()->status == 'S') return redirect('siswa');
        $school = School::first();
        $user   = User::find(Auth::user()->id);

        $id_user = Auth::user()->id;
        $query   = Soal::where('id_user', $id_user)->orderBy('id', 'desc');
        if (Auth::user()->status == 'A') {
            $query = Soal::orderBy('id', 'desc');
        }
        // Filter hanya soal yang punya butir essay
        $id_soals_essay = Detailsoal::where('tipe', 'essay')
                            ->lists('id_soal')->unique()->toArray();

        $soals = $query->whereIn('id', $id_soals_essay)->paginate(15);

        return view('guru.essay_index', compact('soals', 'user', 'school'));
    }

    // Daftar siswa yang sudah submit untuk 1 paket soal
    public function koreksi($id_soal)
    {
        if (Auth::user()->status == 'S' or Auth::user()->status == 'P') return redirect('hasil-guru');
        $school = School::first();
        $user   = User::find(Auth::user()->id);
        $soal   = Soal::find($id_soal);

        $id_kelas_filter = Input::get('kelas');

        $query = Jawab::join('kelas', 'jawabs.id_kelas', '=', 'kelas.id')
                       ->where('jawabs.id_soal', $id_soal)
                       ->where('jawabs.status', 'Y')
                       ->select('jawabs.id_user', 'jawabs.nama', 'jawabs.id_kelas', 'kelas.nama as nama_kelas')
                       ->groupBy('jawabs.id_user', 'jawabs.nama', 'jawabs.id_kelas', 'kelas.nama');

        if ($id_kelas_filter) {
            $query->where('jawabs.id_kelas', $id_kelas_filter);
        }

        $siswa_list = $query->orderBy('kelas.nama', 'asc')->orderBy('jawabs.nama', 'asc')
                             ->get()
                             ->map(function($s) use ($id_soal) {
                                 $total_essay   = Jawab::where('id_soal', $id_soal)
                                                       ->where('id_user', $s->id_user)
                                                       ->where('pilihan', '-')->count();
                                 $sudah_koreksi = Jawab::where('id_soal', $id_soal)
                                                       ->where('id_user', $s->id_user)
                                                       ->where('status_koreksi', 'sudah')->count();
                                 $s->total_essay   = $total_essay;
                                 $s->sudah_koreksi = $sudah_koreksi;
                                 return $s;
                             });

        // Daftar kelas untuk dropdown filter (hanya kelas yang punya siswa di paket soal ini)
        $daftar_kelas = Jawab::join('kelas', 'jawabs.id_kelas', '=', 'kelas.id')
                              ->where('jawabs.id_soal', $id_soal)
                              ->where('jawabs.status', 'Y')
                              ->select('kelas.id', 'kelas.nama')
                              ->distinct()
                              ->orderBy('kelas.nama', 'asc')
                              ->get();

        return view('guru.essay_koreksi', compact('soal', 'siswa_list', 'user', 'school', 'daftar_kelas', 'id_kelas_filter'));
    }

    // Form koreksi per siswa
    public function koreksi_siswa($id_soal, $id_user)
    {
        if (Auth::user()->status == 'S') return redirect('siswa');
        $school = School::first();
        $user   = User::find(Auth::user()->id);
        $soal   = Soal::find($id_soal);
        $siswa  = User::find($id_user);

        $jawabans = Jawab::join('detailsoals', 'jawabs.no_soal_id', '=', 'detailsoals.id')
                         ->select(
                             'detailsoals.soal',
                             'detailsoals.bobot',
                             'jawabs.id as jawab_id',
                             'jawabs.jawaban_essay',
                             'jawabs.nilai_essay',
                             'jawabs.status_koreksi'
                         )
                         ->where('jawabs.id_soal', $id_soal)
                         ->where('jawabs.id_user', $id_user)
                         ->where('detailsoals.tipe', 'essay')
                         ->get();

        return view('guru.essay_koreksi_siswa',
            compact('soal', 'siswa', 'jawabans', 'user', 'school'));
    }

    // Simpan nilai essay dari guru (AJAX)
    public function simpan_nilai()
    {
        if (Auth::user()->status == 'S') return 'forbidden';
        $id_jawab = Input::get('id_jawab');
        $nilai    = (int) Input::get('nilai');
        $bobot    = (int) Input::get('bobot');

        if ($nilai > $bobot) return 'error:melebihi bobot ('.$bobot.')';
        if ($nilai < 0)      return 'error:nilai tidak boleh negatif';

        $jawab = Jawab::find($id_jawab);
        if (!$jawab) return 'error:data tidak ditemukan';

        $jawab->nilai_essay    = $nilai;
        $jawab->score          = $nilai;
        $jawab->status_koreksi = 'sudah';
        $jawab->save();

        return 'ok:'.$nilai;
    }

    // Tandai koreksi 1 siswa selesai
    public function selesai_koreksi()
    {
        if (Auth::user()->status == 'S') return 'forbidden';
        $id_soal = Input::get('id_soal');
        $id_user = Input::get('id_user');

        $siswa = User::find($id_user);
        $soal  = Soal::find($id_soal);

        $aktifitas = new Aktifitas;
        $aktifitas->id_user = Auth::user()->id;
        $aktifitas->nama = "Selesai mengoreksi essay '"
            .$soal->paket."' milik ".$siswa->nama.".";
        $aktifitas->save();

        return 'ok';
    }
}
