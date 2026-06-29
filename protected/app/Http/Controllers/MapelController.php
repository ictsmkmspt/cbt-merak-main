<?php
namespace App\Http\Controllers;

use Auth;
use Input;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mapel;
use App\User;
use App\School;
use App\Aktifitas;

class MapelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->status != "A") return redirect('guru');
        $school   = School::first();
        $user     = User::find(Auth::user()->id);
        $mapels   = Mapel::orderBy('nama')->paginate(15);
        $aktifitas = Aktifitas::join('users', 'aktifitas.id_user', '=', 'users.id')
                              ->select('users.nama as nama_user', 'users.gambar', 'aktifitas.*')
                              ->orderBy('aktifitas.id', 'desc')->limit(5)->get();
        return view('guru.mapel', compact('mapels', 'user', 'school', 'aktifitas'));
    }

    public function tambah()
    {
        if (Auth::user()->status != "A") return "forbidden";
        $nama = trim(Input::get('nama'));
        if ($nama == "") return "<b>Error:</b> Nama tidak boleh kosong.";
        $cek = Mapel::where('nama', $nama)->first();
        if ($cek) return "<b>Error:</b> Mata pelajaran sudah ada.";
        Mapel::create(['nama' => $nama]);
        // Catat aktifitas
        $aktifitas = new Aktifitas;
        $aktifitas->id_user = Auth::user()->id;
        $aktifitas->nama = "Menambahkan mata pelajaran '".$nama."'.";
        $aktifitas->save();
        return 'ok';
    }

    public function ubah()
    {
        if (Auth::user()->status != "A") return "forbidden";
        $id   = Input::get('id');
        $nama = trim(Input::get('nama'));
        if ($nama == "") return "<b>Error:</b> Nama tidak boleh kosong.";
        $mapel = Mapel::find($id);
        if (!$mapel) return "<b>Error:</b> Data tidak ditemukan.";
        $nama_lama = $mapel->nama;
        $mapel->nama = $nama;
        $mapel->save();
        // Catat aktifitas
        $aktifitas = new Aktifitas;
        $aktifitas->id_user = Auth::user()->id;
        $aktifitas->nama = "Mengubah mata pelajaran '".$nama_lama."' menjadi '".$nama."'.";
        $aktifitas->save();
        return 'ok';
    }

    public function hapus()
    {
        if (Auth::user()->status != "A") return "forbidden";
        $id    = Input::get('id');
        $mapel = Mapel::find($id);
        if (!$mapel) return "tidak ditemukan";
        $nama  = $mapel->nama;
        $mapel->delete();
        // Catat aktifitas
        $aktifitas = new Aktifitas;
        $aktifitas->id_user = Auth::user()->id;
        $aktifitas->nama = "Menghapus mata pelajaran '".$nama."'.";
        $aktifitas->save();
        return 'berhasil';
    }
}
