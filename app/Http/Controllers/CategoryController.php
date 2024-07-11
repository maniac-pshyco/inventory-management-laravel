<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;

class CategoryController extends Controller
{
    
    public function index()
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per_page parameter must be an integer between 1 and 100.');
        }

        $categories = Category::filter(request(['search']))
          ->sortable()
          ->paginate($row)
          ->appends(request()->query());

        return view('categories.index', [
            'categories' => $categories,
        ]);
    }

    
    public function create()
    {
        return view('categories.create');
    }

    
    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category has been created!');
    }

    
    public function show(Category $category)
    {
        abort(404);
    }

    
    public function edit(Category $category)
    {
        return view('categories.edit', [
            'category' => $category
        ]);
    }

    
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->all());

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category has been updated!');
    }

    
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->back()
            ->with('success', 'Category has been deleted!');
    }
}
