<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use App\Services\CategoryService;
use App\Services\ItemService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ItemController extends Controller
{
    protected ItemService $itemService;
    protected CategoryService $categoryService;

    /**
     * Create controller instance.
     */
    public function __construct(ItemService $itemService, CategoryService $categoryService)
    {
        $this->itemService = $itemService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of items.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search', '');
        $categoryId = $request->filled('category_id') ? (int) $request->input('category_id') : null;

        $items = $this->itemService->getPaginated($search, $categoryId);
        $categories = $this->categoryService->getPaginated('', 100); // Get all categories for filter
        
        $allLowStockItems = $this->itemService->getLowStockItems();

        return view('items.index', compact('items', 'categories', 'search', 'categoryId', 'allLowStockItems'));
    }

    /**
     * Show the form for creating a new item.
     */
    public function create(): View
    {
        $categories = $this->categoryService->getPaginated('', 100);
        $allLowStockItems = $this->itemService->getLowStockItems();
        return view('items.create', compact('categories', 'allLowStockItems'));
    }

    /**
     * Store a newly created item in storage.
     */
    public function store(StoreItemRequest $request): RedirectResponse
    {
        $this->itemService->create($request->validated());

        return redirect()->route('items.index')
            ->with('success', 'Barang baru berhasil ditambahkan.');
    }

    /**
     * Display the specified item detail.
     */
    public function show(Item $item): View
    {
        // Load relationships for transaction histories
        $item->load(['category', 'incomingGoods' => function($q) {
            $q->latest();
        }, 'outgoingGoods' => function($q) {
            $q->latest();
        }]);

        $allLowStockItems = $this->itemService->getLowStockItems();

        return view('items.show', compact('item', 'allLowStockItems'));
    }

    /**
     * Show the form for editing the specified item.
     */
    public function edit(Item $item): View
    {
        $categories = $this->categoryService->getPaginated('', 100);
        $allLowStockItems = $this->itemService->getLowStockItems();
        return view('items.edit', compact('item', 'categories', 'allLowStockItems'));
    }

    /**
     * Update the specified item in storage.
     */
    public function update(UpdateItemRequest $request, Item $item): RedirectResponse
    {
        $this->itemService->update($item, $request->validated());

        return redirect()->route('items.index')
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    /**
     * Remove the specified item from storage.
     */
    public function destroy(Item $item): RedirectResponse
    {
        // Prevent deletion if the item has associated transactions for integrity
        if ($item->incomingGoods()->exists() || $item->outgoingGoods()->exists()) {
            return redirect()->route('items.index')
                ->with('error', 'Barang tidak dapat dihapus karena memiliki riwayat transaksi masuk/keluar.');
        }

        $this->itemService->delete($item);

        return redirect()->route('items.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}
