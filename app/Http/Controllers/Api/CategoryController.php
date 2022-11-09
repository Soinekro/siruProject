<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $categories = Category::included()
            ->filter()
            ->sort()
            ->getOrpaginate();
        return response()->json([
            'categories' => $categories,
        ], 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:category',
        ]);
        $request->merge([
            'slug' => Str::slug($request->name),
        ]);
        DB::select('call spInsertCategory(?,?)', [
            strtoupper($request->name),
            $request->slug,
        ]);

        return response()->json([
            'message' => 'Categoria creada correctamente',
        ], 201);
    }
    public function show($category)
    {
        $category = Category::findOrFail($category);
        return response()->json([
            'category' => $category,
        ]);
    }
    public function update(Request $request,$category)
    {
        $category = Category::findOrFail($category);
        $request->validate([
            'name' => 'required|string|unique:category,name,'.$category->id,
        ]);
        $request->merge([
            'slug' => Str::slug($request->name),
        ]);
        DB::select('call spUpdateCategory(?,?,?)', [
            $category->id,
            strtoupper($request->name),
            $request->slug,
        ]);
        $category = Category::findOrFail($category->id);
        return response()->json([
            'message' => 'Categoria actualizada correctamente',
            'category' => $category,
        ], 200);
    }
    public function destroy($category)
    {
        $category = Category::findOrFail($category);
        $category->delete();
        return response()->json([
            'message' => 'Categoria eliminada correctamente',
            'category' => $category,
        ], 200);
    }

}
