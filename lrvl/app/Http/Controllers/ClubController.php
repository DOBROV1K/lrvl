<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

/**
 * @property string|null $image_path
 */
class ClubController extends Controller
{
    protected static function middleware(): array
    {
        return [
            'auth' => ['except' => ['index', 'show']]
        ];
    }
    // Корзина — только для админа
    public function trash()
    {
        abort_unless(auth()->check() && auth()->user()->isAdmin(), 403);

        $clubs = Club::onlyTrashed()
            ->with(['user'])
            ->orderBy('name')
            ->get();

        return view('clubs.trash', compact('clubs'));
    }


    public function index()
    {
        $query = Club::with([
            'user',
            'comments.user',
            'players'
        ])->orderBy('name');

        if (auth()->check() && auth()->user()->isAdmin()) {
            $clubs = $query->withTrashed()->get();
        } else {
            $clubs = $query->get();
        }

        return view('clubs.index', compact('clubs'));
    }

    public function show(Club $club)
    {
        if ($club->trashed() && (!auth()->check() || !auth()->user()->isAdmin())) {
            abort(404);
        }

        $club->load([
            'user',
            'comments.user',
            'players'
        ]);

        return view('clubs.show', compact('club'));
    }

    public function create()
    {
        return view('clubs.create');
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

        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $filename = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $path = storage_path('app/public/clubs/' . $filename);

            $manager = new ImageManager(new Driver());
            $manager->read($request->file('image'))->cover(600, 400)->save($path);

            $data['image_path'] = 'storage/clubs/' . $filename;
        }

        Club::create($data);

        return redirect()->route('clubs.index')->with('success', 'Клуб добавлен');
    }

    public function edit(Club $club)
    {
        abort_if(Gate::denies('update-club', $club), 403);

        return view('clubs.edit', compact('club'));
    }

    public function update(Request $request, Club $club)
    {
        abort_if(Gate::denies('update-club', $club), 403);

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

        return redirect()->route('clubs.index')->with('success', 'Клуб обновлён');
    }

    public function destroy(Club $club)
    {
        abort_if(Gate::denies('delete-club', $club), 403);

        $club->delete();
        return redirect()->route('clubs.index')->with('success', 'Клуб удалён');
    }

    public function restore($id)
    {
        abort_if(Gate::denies('restore-club'), 403);

        Club::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('clubs.trash')->with('success', 'Клуб восстановлен');
    }

    public function forceDestroy($id)
    {
        abort_if(Gate::denies('force-delete-club'), 403);

        $club = Club::withTrashed()->findOrFail($id);

        if ($club->image_path) {
            Storage::disk('public')->delete(str_replace('storage/', '', $club->image_path));
        }

        $club->forceDelete();

        return redirect()->route('clubs.trash')->with('success', 'Клуб удалён окончательно');
    }

    public function userClubs($username)
    {
        $user = \App\Models\User::where('name', $username)->firstOrFail();

        $query = $user->clubs()->with([
            'user',
            'players',
            'comments.user'
        ])->orderBy('name');

        $clubs = auth()->check() && auth()->user()->isAdmin()
            ? $query->withTrashed()->get()
            : $query->get();

        return view('clubs.user-clubs', compact('clubs', 'user'));
    }
}
