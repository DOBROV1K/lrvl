<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function store(Request $request, $friendId)
    {
        $me = Auth::user();
        $friend = User::findOrFail($friendId);

        if ($me->id === $friend->id) {
            return back()->with('error', 'Нельзя добавить себя в друзья');
        }

        if (!$me->isFriendWith($friend)) {
            $me->friends()->attach($friend->id);
        }

        if (!$friend->isFriendWith($me)) {
            $friend->friends()->attach($me->id);
        }

        return back()->with('success', 'Пользователь добавлен в друзья (обоюдно)');
    }

    public function destroy(Request $request, $friendId)
    {
        $me = Auth::user();
        $friend = User::findOrFail($friendId);

        if ($me->isFriendWith($friend)) {
            $me->friends()->detach($friend->id);
        }

        if ($friend->isFriendWith($me)) {
            $friend->friends()->detach($me->id);
        }

        return back()->with('success', 'Пользователь удалён из друзей');
    }
}
