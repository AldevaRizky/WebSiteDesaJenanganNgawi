<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hero;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    public function index()
    {
        $heroes = Hero::paginate(10);
        return view('admin.heroes.index', compact('heroes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:102400',
        ]);

        $coverPath = $request->file('cover')->store('public/hero');

        Hero::create(['cover' => $coverPath]);

    return redirect()->route('admin.heroes.index')->with('success', 'Hero Cover berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cover' => 'image|mimes:jpeg,png,jpg,gif,svg|max:102400',
        ]);

        $hero = Hero::findOrFail($id);

        if ($request->hasFile('cover')) {
            Storage::delete($hero->cover);
            $hero->cover = $request->file('cover')->store('public/hero');
        }

        $hero->save();

    return redirect()->route('admin.heroes.index')->with('success', 'Hero cover berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $hero = Hero::findOrFail($id);
        Storage::delete($hero->cover);
        $hero->delete();

    return redirect()->route('admin.heroes.index')->with('success', 'Hero cover berhasil dihapus!');
    }
}
