<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Club;

class FeedController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $friendIds = $user->friends()->pluck('users.id')->toArray();

        $clubs = Club::whereIn('user_id', $friendIds)
                     ->orderByDesc('created_at')
                     ->with('user')
                     ->paginate(20);

        return view('feed.index', compact('clubs'));
    }
}
