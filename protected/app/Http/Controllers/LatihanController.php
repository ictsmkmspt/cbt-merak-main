<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Materi;
use App\User;
use App\School;
use App\Soal;
use App\Jawab;

class LatihanController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    $user   = User::where('id', Auth::user()->id)->first();
    $school = School::first();

    // Materi yang tampil untuk siswa:
    // - status = Y
    // - id_kelas NULL (semua kelas) ATAU id_kelas = kelas siswa yang login
    $id_kelas_siswa = $user->id_kelas;

    $materis = Materi::join('users', 'materis.id_user', '=', 'users.id')
                      ->select('users.nama as nama_user', 'materis.*')
                      ->where('materis.status', 'Y')
                      ->where(function($q) use ($id_kelas_siswa) {
                          $q->whereNull('materis.id_kelas')
                            ->orWhere('materis.id_kelas', '')
                            ->orWhereRaw("FIND_IN_SET(?, materis.id_kelas)", [$id_kelas_siswa]);
                      })
                      ->orderBy('materis.judul', 'ASC')
                      ->paginate(100);

    // Kumpulkan id materi yang bisa dilihat siswa ini (tanpa batas paginate)
    $idMateriVisible = Materi::where('status', 'Y')
                      ->where(function($q) use ($id_kelas_siswa) {
                          $q->whereNull('id_kelas')
                            ->orWhere('id_kelas', '')
                            ->orWhereRaw("FIND_IN_SET(?, id_kelas)", [$id_kelas_siswa]);
                      })
                      ->lists('id');

    // Daftar latihan (sudah dibagikan guru) yang BELUM dikerjakan siswa ini
    $latihanBelumDikerjakan = collect();
    if (count($idMateriVisible)) {
      $latihanBelumDikerjakan = Soal::where('jenis', 2)
                        ->where('status_bagikan', 'Y')
                        ->whereIn('materi', $idMateriVisible)
                        ->orderBy('id', 'desc')
                        ->get()
                        ->filter(function($soal) use ($user) {
                          return !Jawab::where('id_soal', $soal->id)
                                       ->where('id_user', $user->id)
                                       ->where('status', 'Y')
                                       ->exists();
                        })
                        ->values();
    }

    return view('siswa.latihan.index', compact('materis', 'user', 'school', 'latihanBelumDikerjakan'));
  }

  public function detail($id, $judul)
  {
    $user   = User::where('id', Auth::user()->id)->first();
    $school = School::first();

    $id_kelas_siswa = $user->id_kelas;

    $materi = Materi::join('users', 'materis.id_user', '=', 'users.id')
              ->select('users.nama as nama_user', 'users.gambar as gambar_user', 'users.status as jenis_user', 'materis.*')
              ->where('materis.status', 'Y')
              ->where('materis.id', $id)
              ->where(function($q) use ($id_kelas_siswa) {
                  $q->whereNull('materis.id_kelas')
                    ->orWhere('materis.id_kelas', '')
                    ->orWhere('materis.id_kelas', $id_kelas_siswa);
              })
              ->first();

    if ($materi != "") {
      $soals = Soal::where('jenis', 2)->where('materi', $materi->id)->where('status_bagikan', 'Y')->get();

      // Tandai soal latihan mana saja yang sudah difinalisasi (dikerjakan) oleh siswa ini
      $idSoalSelesai = Jawab::where('id_user', $user->id)
                             ->where('status', 'Y')
                             ->whereIn('id_soal', $soals->pluck('id')->toArray())
                             ->lists('id_soal')
                             ->unique()
                             ->toArray();
    }else{
      $soals = 'EM';
      $idSoalSelesai = [];
    }
    return view('siswa.latihan.detail', compact('user', 'school', 'materi', 'soals', 'idSoalSelesai'));
  }
}
