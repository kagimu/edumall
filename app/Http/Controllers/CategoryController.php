<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user->is_school_admin) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage categories.'], 403);
        }

        if (!$user->school_id) {
            return response()->json(['error' => 'User does not have an associated school'], 400);
        }

        $categories = Category::where('school_id', $user->school_id)->get();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if (!$user->is_school_admin) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage categories.'], 403);
        }

        if (!$user->school_id) {
            return response()->json(['error' => 'User does not have an associated school'], 400);
        }

        $request->validate([
            'name' => 'required|string|unique:categories,name,NULL,id,school_id,' . $user->school_id,
        ]);

        $category = Category::create([
            'school_id' => $user->school_id,
            'name' => $request->name,
        ]);

        return response()->json($category, 201);
    }

    public function show(Category $category)
    {
        $user = request()->user();
        if (!$user->is_school_admin || $category->school_id !== $user->school_id) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage categories.'], 403);
        }

        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {
        $user = $request->user();
        if (!$user->is_school_admin || $category->school_id !== $user->school_id) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage categories.'], 403);
        }

        $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id . ',id,school_id,' . $user->school_id,
        ]);

        $category->update($request->only(['name']));
        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $user = request()->user();
        if (!$user->is_school_admin || $category->school_id !== $user->school_id) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage categories.'], 403);
        }

        $category->delete();
        return response()->json(['message' => 'Category deleted']);
    }
}
