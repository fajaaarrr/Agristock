<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncomingGoodsRequest;
use App\Models\IncomingGoods;
use App\Services\IncomingGoodsService;
use App\Services\ItemService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IncomingGoodsController extends Controller
{
    protected IncomingGoodsService $incomingService;
    protected ItemService $itemService;

    /**
     * Create controller instance.
     */
    public function __construct(IncomingGoodsService $incomingService, ItemService $itemService)
    {
        $this->incomingService = $incomingService;
        $this->itemService = $itemService;
    }

    /**
     * Display a listing of incoming transactions.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search', '');
        $incomingGoods = $this->incomingService->getPaginated($search);
        
        $allLowStockItems = $this->itemService->getLowStockItems();

        return view('incoming.index', compact('incomingGoods', 'search', 'allLowStockItems'));
    }

    /**
     * Show the form for creating a new incoming transaction.
     */
    public function create(): View
    {
        $items = $this->itemService->getAll();
        
        // Generate a recommended transaction number: IN-YYYYMMDD-XXXX
        $recommendedNo = 'IN-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        
        $allLowStockItems = $this->itemService->getLowStockItems();

        return view('incoming.create', compact('items', 'recommendedNo', 'allLowStockItems'));
    }

    /**
     * Store a newly created incoming transaction in storage.
     */
    public function store(StoreIncomingGoodsRequest $request): RedirectResponse
    {
        $this->incomingService->create($request->validated());

        return redirect()->route('incoming-goods.index')
            ->with('success', 'Transaksi barang masuk berhasil dicatat. Stok barang telah disesuaikan.');
    }

    /**
     * Remove the specified incoming transaction from storage.
     */
    public function destroy(IncomingGoods $incomingGood): RedirectResponse
    {
        // Check if removing this transaction would cause the stock to go negative
        $item = $incomingGood->item;
        if ($item->stok < $incomingGood->jumlah) {
            return redirect()->route('incoming-goods.index')
                ->with('error', "Transaksi tidak dapat dihapus. Stok barang {$item->nama_barang} saat ini ({$item->stok}) tidak mencukupi untuk dikurangi sebanyak {$incomingGood->jumlah} item.");
        }

        $this->incomingService->delete($incomingGood);

        return redirect()->route('incoming-goods.index')
            ->with('success', 'Transaksi barang masuk dibatalkan. Stok barang telah dikembalikan.');
    }
}
