<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News; // ✅ Tambahkan import model
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua berita dengan penulis & komentar
        return News::with('user', 'comments.user')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $news = News::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(), // ✅ aman & eksplisit
        ]);

        // Load relasi saat return
        return response()->json($news->load('user'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $news = News::with('user', 'comments.user')->findOrFail($id);
        return response()->json($news);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Opsional: tambahkan jika butuh edit berita
        return response()->json(['message' => 'Not implemented'], 405);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Opsional: tambahkan jika butuh hapus berita
        return response()->json(['message' => 'Not implemented'], 405);
    }
}