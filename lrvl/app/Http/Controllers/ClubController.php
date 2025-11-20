<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ClubController extends Controller
{
    public function index()
    {
        $clubs = Club::orderBy('name')->get();
        return view('clubs.index', compact('clubs'));
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
            'capacity' => 'nullable|string|max:255',
            'trophies' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120'
        ]);

        // Обработка изображения (Intervention Image v3)
        if ($request->hasFile('image')) {

            $img = $request->file('image');
            $filename = uniqid() . '.' . $img->getClientOriginalExtension();

            $path = storage_path('app/public/clubs/' . $filename);

            // Создание менеджера через драйвер GD
            $manager = new ImageManager(new Driver());
            $image = $manager->read($img);

            // Аналог cover -> делает обрезку под нужный размер
            $image->cover(600, 400)->save($path);

            $data['image_path'] = 'storage/clubs/' . $filename;
        }

        Club::create($data);

        return redirect()->route('clubs.index')->with('success', 'Клуб добавлен');
    }

    public function show(Club $club)
    {
        return view('clubs.show', compact('club'));
    }

    public function edit(Club $club)
    {
        return view('clubs.edit', compact('club'));
    }

    public function update(Request $request, Club $club)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'founded' => 'nullable',
            'president' => 'nullable|string|max:255',
            'stadium' => 'nullable|string|max:255',
            'capacity' => 'nullable|string|max:255',
            'trophies' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120'
        ]);

        // Обработка изображения
        if ($request->hasFile('image')) {

            // Удаляем прошлый файл
            if ($club->image_path) {
                $old = str_replace('storage/', '', $club->image_path);
                Storage::disk('public')->delete($old);
            }

            $img = $request->file('image');
            $filename = uniqid() . '.' . $img->getClientOriginalExtension();

            $path = storage_path('app/public/clubs/' . $filename);

            $manager = new ImageManager(new Driver());
            $image = $manager->read($img);
            $image->cover(600, 400)->save($path);

            $data['image_path'] = 'storage/clubs/' . $filename;
        }

        $club->update($data);

        return redirect()->route('clubs.index')->with('success', 'Клуб обновлён');
    }

    public function destroy(Club $club)
    {
        $club->delete();
        return redirect()->route('clubs.index')->with('success', 'Клуб удалён');
    }
}
