<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BeritaImage;
use Illuminate\Support\Facades\Storage;

class BeritaImageController extends Controller
{
    public function destroy($id)
    {
        $img = BeritaImage::findOrFail($id);
        Storage::delete($img->path);
        $img->delete();
        return back()->with('success','Gambar berhasil dihapus');
    }
}
