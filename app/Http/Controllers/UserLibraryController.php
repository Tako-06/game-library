<?php

namespace App\Http\Controllers;

use App\Models\UserLibrary;
use Illuminate\Http\Request;

class UserLibraryController extends Controller
{
    public function create(Request $request)
    {
        $validateCreateUserLibrary = $request->validate([
            'game_id' => 'required|exists:games,id'
        ]);

        $user = auth('sanctum')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $userId = $user->id;

        $alreadyExists = UserLibrary::where([
            'game_id' => $validateCreateUserLibrary['game_id'],
            'user_id' => $userId
        ])->exists();

        if ($alreadyExists) {
            return response()->json(['message' => 'Game already exists in your library!'], 409);
        }

        $validateCreateUserLibrary['user_id'] = $userId;

        $userLibrary = UserLibrary::create($validateCreateUserLibrary);
        return response()->json(['userLibrary' => $userLibrary], 201);
    }

    public function destroy(int $gameId)
    {
        $userId = auth('sanctum')->user()->id;

        $userLibrary = UserLibrary::where([
            'game_id' => $gameId,
            'user_id' => $userId
        ])->first();

        if (!$userLibrary) {
            return response()->json(['message' => 'Game not found in your library!'], 404);
        }

        $userLibrary->delete();
        return response()->json(['message' => 'Successfully delete a game from your library!'], 200);
    }

    public function showUserGames()
    {
        $user = auth('sanctum')->user();

        $games = $user->games;

        return response()->json([
            'games' => $games
        ]);
    }
}
