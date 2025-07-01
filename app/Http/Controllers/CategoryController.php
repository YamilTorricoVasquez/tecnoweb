<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('category_access');

        $categoriesQuery = Category::query();

        $this->applySearch($categoriesQuery, $request->search);

        $categories = CategoryResource::collection($categoriesQuery->paginate(5));
        return inertia('Category/Index', [
            'categories' => $categories,
            'search' => $request->search ?? '',
        ]);
    }
    protected function applySearch($query, $search)
    {
        return $query->when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }
    public function create()
    {
        Gate::authorize('category_create');

        return inertia('Category/Create');
    }

    public function store(StoreCategoryRequest $request)
    {
        Gate::authorize('category_create');

        $validated = $request->validated();

        Category::create($validated);

        return redirect()->route('categories.index');
    }
    public function edit(Category $category)
    {
        Gate::authorize('category_edit');

        return inertia('Category/Edit', [
            'category' => CategoryResource::make($category),
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        Gate::authorize('category_edit');

        $validated = $request->validated();

        // Agregar esto para inspeccionar los datos
     //   dd($validated);

        $category->update($validated);

        return redirect()->route('categories.index');
    }


    public function destroy(Category $category)
    {
        Gate::authorize('category_delete');

        $category->delete();

        return redirect()->route('categories.index');
    }
}
