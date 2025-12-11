<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PlayerController extends Controller
{
    public function store(Request $request, Club $club)
    {
        if (Gate::denies('update-club', $club)) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'number' => 'nullable|integer',
            'nationality' => 'nullable|string|max:255',
            'age' => 'nullable|integer'
        ]);

        $data['club_id'] = $club->id;

        Player::create($data);

        return back()->with('success', 'Игрок добавлен');
    }

    public function destroy(Player $player)
    {
        if (Gate::denies('update-club', $player->club)) {
            abort(403);
        }

        $player->delete();

        return back()->with('success', 'Игрок удалён');
    }
}
