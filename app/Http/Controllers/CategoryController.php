<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create(Request $request) {
        // Check if they are admin
        if (!auth('sanctum')->user()->is_admin) {
            return response()->json(['error' => 'Unauthorized. Admin Only!'], 403);
        }

        $validateCategory = $request->validate([
            'name' => 'required|unique:categories',
            'description' => 'required'
        ]);

        $category = Category::create($validateCategory);

        return response()->json(['category' => $category], 201);
    }
}
