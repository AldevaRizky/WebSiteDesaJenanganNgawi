<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataPenduduk;

class DataPendudukController extends Controller
{
    public function index()
    {
        $dataPenduduk = DataPenduduk::first();

        return view('admin.data_penduduk.index', compact('dataPenduduk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'total_penduduk' => 'required|integer|min:0',
            'kepala_keluarga' => 'required|integer|min:0',
            'laki_laki' => 'required|integer|min:0',
            'perempuan' => 'required|integer|min:0',
        ]);

        if (DataPenduduk::count() > 0) {
            return redirect()->route('admin.data_penduduk.index')->withErrors('Data penduduk sudah ada. Silakan edit data yang ada.');
        }

        DataPenduduk::create($request->only([
            'total_penduduk',
            'kepala_keluarga',
            'laki_laki',
            'perempuan',
        ]));

        return redirect()->route('admin.data_penduduk.index')->with('success', 'Data penduduk berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'total_penduduk' => 'required|integer|min:0',
            'kepala_keluarga' => 'required|integer|min:0',
            'laki_laki' => 'required|integer|min:0',
            'perempuan' => 'required|integer|min:0',
        ]);

        $data = DataPenduduk::findOrFail($id);
        $data->update($request->only([
            'total_penduduk',
            'kepala_keluarga',
            'laki_laki',
            'perempuan',
        ]));

        return redirect()->route('admin.data_penduduk.index')->with('success', 'Data penduduk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $data = DataPenduduk::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.data_penduduk.index')->with('success', 'Data penduduk berhasil dihapus!');
    }
}
