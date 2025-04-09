<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GamesPackage;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index($gameId)
    {
        $game = Game::with('packages')->findOrFail($gameId);
        return view('admin.packages.index', compact('game'));
    }
    
    public function create($gameId)
    {
        $game = Game::findOrFail($gameId);
        return view('admin.packages.create', compact('game'));
    }
    
    public function store(Request $request, $gameId)
    {
        $game = Game::findOrFail($gameId);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string', 
            'price' => 'required|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);
        
        $package = new GamesPackage();
        $package->game_id = $game->id;
        $package->name = $validated['name'];
        $package->description = $validated['description'];
        $package->price = $validated['price'];
        $package->is_active = $request->has('is_active') ? true : false;
        $package->save();
        
        return redirect()->route('admin.games.packages.index', $game->id)
            ->with('success', 'Paket berhasil dibuat');
    }
    
    public function edit($gameId, GamesPackage $package)
    {
        $games = Game::all();
        return view('admin.packages.edit', compact('games', 'package'));
    }
    
    public function update(Request $request, $gameId, GamesPackage $package)
    {
        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);
        
        $package->game_id = $validated['game_id'];
        $package->name = $validated['name'];
        $package->description = $validated['description'];
        $package->price = $validated['price'];
        $package->is_active = $request->has('is_active') ? true : false;
        $package->save();
        
        return redirect()->route('admin.games.packages.index', $package->game_id)
            ->with('success', 'Paket berhasil diperbarui');
    }
    
    public function destroy($gameId, GamesPackage $package)
    {
        $package->delete();
        
        return redirect()->route('admin.games.packages.index', $gameId)
            ->with('success', 'Paket berhasil dihapus');
    }
}