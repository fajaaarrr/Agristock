<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOutgoingGoodsRequest;
use App\Models\OutgoingGoods;
use App\Services\OutgoingGoodsService;
use App\Services\ItemService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OutgoingGoodsController extends Controller
{
    protected OutgoingGoodsService $outgoingService;
    protected ItemService $itemService;

    /**
     * Create controller instance.
     */
    public function __construct(OutgoingGoodsService $outgoingService, ItemService $itemService)
    {
        $this->outgoingService = $outgoingService;
        $this->itemService = $itemService;
    }

    /**
     * Display a listing of outgoing transactions.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search', '');
        $outgoingGoods = $this->outgoingService->getPaginated($search);
        
        $allLowStockItems = $this->itemService->getLowStockItems();

        return view('outgoing.index', compact('outgoingGoods', 'search', 'allLowStockItems'));
    }

    /**
     * Show the form for creating a new outgoing transaction.
     */
    public function create(): View
    {
        $items = $this->itemService->getAll();
        
        // Generate a recommended transaction number: OUT-YYYYMMDD-XXXX
        $recommendedNo = 'OUT-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        
        $allLowStockItems = $this->itemService->getLowStockItems();

        return view('outgoing.create', compact('items', 'recommendedNo', 'allLowStockItems'));
    }

    /**
     * Store a newly created outgoing transaction in storage.
     */
    public function store(StoreOutgoingGoodsRequest $request): RedirectResponse
    {
        try {
            $this->outgoingService->create($request->validated());
            
            return redirect()->route('outgoing-goods.index')
                ->with('success', 'Transaksi barang keluar berhasil dicatat. Stok barang telah disesuaikan.');
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified outgoing transaction from storage.
     */
    public function destroy(OutgoingGoods $outgoingGood): RedirectResponse
    {
        $this->outgoingService->delete($outgoingGood);

        return redirect()->route('outgoing-goods.index')
            ->with('success', 'Transaksi barang keluar dibatalkan. Stok barang telah dikembalikan.');
    }
}
