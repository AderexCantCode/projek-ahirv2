<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $games = Game::with(['packages' => function($query) {
            $query->where('is_active', true);
        }])->get();
        
        return view('home', compact('games'));
    }
}
