<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Club $club)
    {
        $request->validate(['body' => 'required|string|max:2000']);

        $comment = Comment::create([
            'club_id' => $club->id,
            'user_id' => Auth::id(),
            'body' => $request->input('body'),
        ]);

        return back()->with('success', 'Комментарий добавлен');
    }

    public function destroy(Comment $comment)
    {
        $user = Auth::user();
        if ($user->id !== $comment->user_id && !$user->isAdmin()) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Комментарий удалён');
    }
}
