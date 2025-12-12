<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'news_id' => 'required|exists:news,id',
            'body' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'news_id' => $request->news_id,
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return response()->json($comment->load('user'), 201);
    }
}