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

    public function showAll() {
        // Yes this is for checking if they are logged in or not.
        if (!auth('sanctum')->user()){
            return response()->json(['error' => 'Unauthorized. Please login!'], 401);
        }

        $category = Category::all();

        if ($category->isEmpty()){
            return response()->json(['error' => 'No categories found. Make one!'], 404);
        }

        return response()->json(['categories' => $category], 200);
    }

    public function showOne($id){

        if (!auth('sanctum')-> user()){
            return response()->json(['error' => 'Unauthorized. Please login!'], 401);
        }

        $category = Category::find($id);

        if (!$category){
            return response()->json(['error' => 'Category not found.'], 404);
        }

        return response()->json(['category' => $category], 200);
    }

    public function update(Request $request, $id){

        if(!auth('sanctum')->user()->is_admin){
            return response()->json(['error' => 'Unauthorized. Admin Only!'], 403);
        }

        $category = Category::find($id);

        if (!$category){
            return response()->json(['error' => 'Category not found.'], 404);
        }

        $validateCategory = $request->validate([
            'name' => 'sometimes|required|unique:categories,name,' . $category->id,
            'description' => 'sometimes|nullable'
        ]);

        $category->update($validateCategory);
        return response()->json(['category' => $category], 200);
    }

    public function delete($id){

        if(!auth('sanctum')->user()->is_admin){
            return response()->json(['error' => 'Unauthorized. Admin Only!'], 403);
        }

        $category = Category::find($id);

        if (!$category){
            return response()->json(['error' => 'Category not found.'], 404);
        }

        $category->delete();
        return response()->json(['message' => 'Category deleted successfully.'], 200);
    }

}
