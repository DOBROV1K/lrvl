<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlayerResource;
use App\Models\Player;
use App\Models\Club;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index(Request $request)
    {
        $query = Player::with(['club.user']);
        
        if ($request->has('club_id')) {
            $query->where('club_id', $request->club_id);
        }
        
        $players = $query->orderBy('name')->paginate(20);
        
        return PlayerResource::collection($players);
    }

    public function show($id)
    {
        $player = Player::with(['club.user'])->findOrFail($id);
        
        return new PlayerResource($player);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'club_id' => 'required|exists:clubs,id',
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'number' => 'nullable|integer',
            'nationality' => 'nullable|string|max:255',
            'age' => 'nullable|integer'
        ]);

        $club = Club::findOrFail($data['club_id']);
        if ($request->user()->id !== $club->user_id && !$request->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $player = Player::create($data);
        $player->load(['club.user']);

        return new PlayerResource($player);
    }

    public function update(Request $request, $id)
    {
        $player = Player::with(['club'])->findOrFail($id);
        
        if ($request->user()->id !== $player->club->user_id && !$request->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'number' => 'nullable|integer',
            'nationality' => 'nullable|string|max:255',
            'age' => 'nullable|integer'
        ]);

        $player->update($data);
        $player->load(['club.user']);

        return new PlayerResource($player);
    }

    public function destroy(Request $request, $id)
    {
        $player = Player::with(['club'])->findOrFail($id);
        
        if ($request->user()->id !== $player->club->user_id && !$request->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $player->delete();

        return response()->json(['message' => 'Player deleted successfully'], 200);
    }
}