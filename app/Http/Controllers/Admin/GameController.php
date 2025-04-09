<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::all();
        return view('admin.games.index', compact('games'));
    }

    public function create()
    {
        return view('admin.games.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->storeAs('games', $imageName, 'public');

        Game::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image' => $imageName,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.games.index')->with('success', 'Game berhasil dibuat');
    }

    public function edit(Game $game)
    {
        return view('admin.games.edit', compact('game'));
    }

    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string', 
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($game->image) {
                Storage::disk('public')->delete('games/' . $game->image);
            }

            // Upload gambar baru
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->storeAs('games', $imageName, 'public');
            $game->image = $imageName;
        }

        $game->name = $validated['name'];
        $game->description = $validated['description'];
        $game->is_active = $request->has('is_active');
        $game->save();

        return redirect()->route('admin.games.index')->with('success', 'Game berhasil diperbarui');
    }

    public function destroy(Game $game)
    {
        if ($game->image) {
            Storage::disk('public')->delete('games/' . $game->image);
        }

        $game->delete();

        return redirect()->route('admin.games.index')->with('success', 'Game berhasil dihapus');
    }
}
