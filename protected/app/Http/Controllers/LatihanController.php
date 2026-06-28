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
                            ->orWhere('materis.id_kelas', $id_kelas_siswa);
                      })
                      ->orderBy('materis.id', 'DESC')
                      ->paginate(4);

    return view('siswa.latihan.index', compact('materis', 'user', 'school'));
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
      $soals = Soal::where('jenis', 2)->where('materi', $materi->id)->get();
    }else{
      $soals = 'EM';
    }
    return view('siswa.latihan.detail', compact('user', 'school', 'materi', 'soals'));
  }
}
