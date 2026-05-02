<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function create(Request $request)
    {
        // Check if they are admin
        if (!auth('sanctum')->user()->is_admin) {
            return response()->json(['error' => 'Unauthorized. Admin Only!'], 403);
        }

        $validateGame = $request->validate([
            'name' => 'required|unique:games',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|file|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $imagePath = $request->file('image')->store('games', 'public');

        $game = new Game();
        $game->name = $validateGame['name'];
        $game->description = $validateGame['description'];
        $game->category_id = $validateGame['category_id'];
        $game->image_path = $imagePath;
        $game->save();

        return response()->json(['game' => $game], 201);
    }
}
