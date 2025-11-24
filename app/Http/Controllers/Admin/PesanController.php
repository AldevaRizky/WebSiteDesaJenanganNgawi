<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesan;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function index()
    {
        $q = request()->get('q');

        $query = Pesan::orderBy('created_at', 'desc');
        if ($q) {
            $query->where(function($qr) use ($q) {
                $qr->where('nama', 'like', "%{$q}%")
                   ->orWhere('email', 'like', "%{$q}%")
                   ->orWhere('message', 'like', "%{$q}%");
            });
        }

        $pesans = $query->paginate(10)->appends(['q' => $q]);
        return view('admin.pesans.index', compact('pesans'));
    }

    public function destroy($id)
    {
        $pesan = Pesan::findOrFail($id);
        $pesan->delete();

        return redirect()->route('admin.pesans.index')->with('success', 'Pesan berhasil dihapus!');
    }
}
