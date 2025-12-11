<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClubResource;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ClubController extends Controller
{
    public function index(Request $request)
    {
        $query = Club::with(['user', 'players', 'comments']);

        if ($request->user() && $request->user()->isAdmin()) {
            $query->withTrashed();
        }
        
        $clubs = $query->orderBy('name')->paginate(15);
        
        return ClubResource::collection($clubs);
    }

    public function show(Request $request, $id)
    {
        $club = Club::with(['user', 'players', 'comments.user'])->withTrashed()->findOrFail($id);

        if ($club->trashed() && (!$request->user() || !$request->user()->isAdmin())) {
            return response()->json(['message' => 'Club not found'], 404);
        }
        
        return new ClubResource($club);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'founded' => 'nullable',
            'president' => 'nullable|string|max:255',
            'stadium' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer',
            'trophies' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120'
        ]);

        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('image')) {
            $filename = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $path = storage_path('app/public/clubs/' . $filename);

            $manager = new ImageManager(new Driver());
            $manager->read($request->file('image'))->cover(600, 400)->save($path);

            $data['image_path'] = 'storage/clubs/' . $filename;
        }

        $club = Club::create($data);
        $club->load(['user', 'players', 'comments']);

        return new ClubResource($club);
    }

    public function update(Request $request, $id)
    {
        $club = Club::findOrFail($id);
        
        if ($request->user()->id !== $club->user_id && !$request->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'founded' => 'nullable',
            'president' => 'nullable|string|max:255',
            'stadium' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer',
            'trophies' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120'
        ]);

        if ($request->hasFile('image')) {
            if ($club->image_path) {
                Storage::disk('public')->delete(str_replace('storage/', '', $club->image_path));
            }

            $filename = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $path = storage_path('app/public/clubs/' . $filename);

            $manager = new ImageManager(new Driver());
            $manager->read($request->file('image'))->cover(600, 400)->save($path);

            $data['image_path'] = 'storage/clubs/' . $filename;
        }

        $club->update($data);
        $club->load(['user', 'players', 'comments']);

        return new ClubResource($club);
    }

    public function destroy(Request $request, $id)
    {
        $club = Club::findOrFail($id);
        
        if ($request->user()->id !== $club->user_id && !$request->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $club->delete();

        return response()->json(['message' => 'Club deleted successfully'], 200);
    }
}