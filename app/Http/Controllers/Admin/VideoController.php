<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'link_youtube' => 'required|url',
        ]);

        Video::create($request->all());

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'link_youtube' => 'required|url',
        ]);

        $video->update($request->all());

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        $video->delete();

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil dihapus');
    }
}
