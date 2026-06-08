<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\ItemService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;
    protected ItemService $itemService;

    /**
     * Create controller instance.
     */
    public function __construct(CategoryService $categoryService, ItemService $itemService)
    {
        $this->categoryService = $categoryService;
        $this->itemService = $itemService;
    }

    /**
     * Display a listing of the categories.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search', '');
        $categories = $this->categoryService->getPaginated($search);
        
        // Share low stock items for navbar notification
        $allLowStockItems = $this->itemService->getLowStockItems();

        return view('categories.index', compact('categories', 'search', 'allLowStockItems'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        $allLowStockItems = $this->itemService->getLowStockItems();
        return view('categories.create', compact('allLowStockItems'));
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $this->categoryService->create($request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category): View
    {
        $allLowStockItems = $this->itemService->getLowStockItems();
        return view('categories.edit', compact('category', 'allLowStockItems'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $this->categoryService->update($category, $request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Check if category is used by items
        if ($category->items()->exists()) {
            return redirect()->route('categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh barang.');
        }

        $this->categoryService->delete($category);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
