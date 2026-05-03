<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public function showAll()
    {
        $games = Game::all(['id', 'name', 'image_path', 'category_id']);

        return response()->json(['games' => $games], 200);
    }

    public function showOne(Game $game)
    {
        return response()->json(['game' => $game]);
    }

    public function update(Request $request, Game $game)
    {

        if (!auth('sanctum')->user()->is_admin) {
            return response()->json(['error' => 'Unauthorized. Admin Only!'], 403);
        }

        $validateGame = $request->validate([
            'name' => 'sometimes|unique:games,name,' . $game->id,
            'description' => 'sometimes',
            'category_id' => 'sometimes|exists:categories,id',
            'image' => 'sometimes|file|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($game->image_path);
            $validateGame['image_path'] = $request->file('image')->store('games', 'public');
        }

        unset($validateGame['image']);
        $game->update($validateGame);

        return response()->json(['game' => $game], 201);
    }

    public function destroy(Game $game)
    {
        // Check if they are admin
        if (!auth('sanctum')->user()->is_admin) {
            return response()->json(['error' => 'Unauthorized. Admin Only!'], 403);
        }

        Storage::disk('public')->delete($game->image_path);
        $game->delete();

        return response()->json(['message' => 'Game deleted successfully.']);
    }
}
