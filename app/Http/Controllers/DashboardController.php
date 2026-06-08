<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Services\ItemService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;
    protected ItemService $itemService;

    /**
     * Create controller instance.
     */
    public function __construct(DashboardService $dashboardService, ItemService $itemService)
    {
        $this->dashboardService = $dashboardService;
        $this->itemService = $itemService;
    }

    /**
     * Display the dashboard view.
     */
    public function index(): View
    {
        $stats = $this->dashboardService->getDashboardStats();
        
        // Also fetch the low stock items separately to share with navbar notifications
        $allLowStockItems = $this->itemService->getLowStockItems();

        return view('dashboard', array_merge($stats, [
            'all_low_stock_items' => $allLowStockItems
        ]));
    }
}
