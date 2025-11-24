<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PerangkatDesa;
use App\Models\BaganImage;

class PerangkatDesaController extends Controller
{
	public function index(Request $request)
	{
		$q = $request->get('q');

		$query = PerangkatDesa::query();
		if ($q) {
			$query->where(function($qr) use ($q) {
				$qr->where('nama', 'like', "%{$q}%")
				   ->orWhere('jabatan', 'like', "%{$q}%")
				   ->orWhere('deskripsi', 'like', "%{$q}%");
			});
		}

		$perangkats = $query->paginate(10)->appends(['q' => $q]);
		$all = PerangkatDesa::all();
		return view('admin.perangkat.index', compact('perangkats', 'all'));
	}

	public function store(Request $request)
	{
		$request->validate([
			'nama' => 'required|string|max:255',
			'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:102400',
			'email' => 'nullable|email',
		]);

		$data = $request->only(['nama', 'jabatan', 'deskripsi', 'phone', 'email']);

		if ($request->hasFile('gambar')) {
			// store on the public disk under 'perangkat' directory
			$data['gambar'] = $request->file('gambar')->store('perangkat', 'public');
		}

		$data['active'] = true;

		PerangkatDesa::create($data);

		return redirect()->route('admin.perangkat.index')->with('success', 'Perangkat berhasil ditambahkan!');
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'nama' => 'required|string|max:255',
			'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:102400',
			'email' => 'nullable|email',
		]);

		$p = PerangkatDesa::findOrFail($id);

		$p->nama = $request->nama;
		$p->jabatan = $request->jabatan;
		$p->deskripsi = $request->deskripsi;
		$p->phone = $request->phone;
		$p->email = $request->email;

		// handle delete of existing image (use public disk)
		if ($request->filled('delete_image') && $request->delete_image == 1) {
			if ($p->gambar) {
				Storage::disk('public')->delete($p->gambar);
			}
			$p->gambar = null;
		}

		if ($request->hasFile('gambar')) {
			if ($p->gambar) Storage::disk('public')->delete($p->gambar);
			$p->gambar = $request->file('gambar')->store('perangkat', 'public');
		}

		$p->save();

		return redirect()->route('admin.perangkat.index')->with('success', 'Perangkat berhasil diperbarui!');
	}

	public function destroy($id)
	{
	$p = PerangkatDesa::findOrFail($id);
	if ($p->gambar) Storage::disk('public')->delete($p->gambar);
		$p->delete();
		return redirect()->route('admin.perangkat.index')->with('success', 'Perangkat berhasil dihapus!');
	}

	// bagan handled by separate BaganController now
}
