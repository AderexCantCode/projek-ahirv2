<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GamesPackage;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function show($id)
    {
        $game = Game::findOrFail($id);
        $packages = $game->packages()->where('is_active', true)->get();
        
        return response()->json([
            'game' => $game,
            'packages' => $packages
        ]);
    }
}
