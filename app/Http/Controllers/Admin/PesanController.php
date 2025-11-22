<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesan;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function index()
    {
        $pesans = Pesan::paginate(10);
        return view('admin.pesans.index', compact('pesans'));
    }

    public function destroy($id)
    {
        $pesan = Pesan::findOrFail($id);
        $pesan->delete();

        return redirect()->route('admin.pesans.index')->with('success', 'Pesan berhasil dihapus!');
    }
}
