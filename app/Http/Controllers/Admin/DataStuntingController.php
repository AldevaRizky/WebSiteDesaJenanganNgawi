<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataStunting;
use Illuminate\Http\Request;

class DataStuntingController extends Controller
{
    public function index()
    {
        $dataStunting = DataStunting::orderBy('tanggal_pengukuran', 'desc')
            ->paginate(15);

        return view('admin.data_stunting.index', compact('dataStunting'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_anak' => 'required|string|max:255',
            'tanggal_pengukuran' => 'required|date',
            'umur_bulan' => 'required|integer|min:0|max:60',
            'tinggi_badan_cm' => 'required|numeric|min:0|max:200',
            'berat_badan' => 'required|numeric|min:0|max:100',
            'lingkar_kepala' => 'nullable|numeric|min:0|max:100',
            'lingkar_lengan' => 'nullable|numeric|min:0|max:100',
            'status_stunting' => 'required|in:normal,stunting,severely_stunting,tinggi',
        ]);

        DataStunting::create($request->all());

        return redirect()->route('admin.data_stunting.index')
            ->with('success', 'Data stunting berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_anak' => 'required|string|max:255',
            'tanggal_pengukuran' => 'required|date',
            'umur_bulan' => 'required|integer|min:0|max:60',
            'tinggi_badan_cm' => 'required|numeric|min:0|max:200',
            'berat_badan' => 'required|numeric|min:0|max:100',
            'lingkar_kepala' => 'nullable|numeric|min:0|max:100',
            'lingkar_lengan' => 'nullable|numeric|min:0|max:100',
            'status_stunting' => 'required|in:normal,stunting,severely_stunting,tinggi',
        ]);

        $data = DataStunting::findOrFail($id);
        $data->update($request->all());

        return redirect()->route('admin.data_stunting.index')
            ->with('success', 'Data stunting berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $data = DataStunting::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.data_stunting.index')
            ->with('success', 'Data stunting berhasil dihapus!');
    }
}
