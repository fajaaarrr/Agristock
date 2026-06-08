<?php

namespace App\Http\Controllers;

use App\Services\ItemService;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    protected ReportService $reportService;
    protected ItemService $itemService;

    /**
     * Create controller instance.
     */
    public function __construct(ReportService $reportService, ItemService $itemService)
    {
        $this->reportService = $reportService;
        $this->itemService = $itemService;
    }

    /**
     * Display reports page with filtered datasets.
     */
    public function index(Request $request): View
    {
        $filterType = $request->input('filter_type', 'all');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $activeTab = $request->input('tab', 'stock'); // 'stock', 'incoming', or 'outgoing'

        // 1. Stock report is current status, date filtering is not applied
        $stockReport = $this->reportService->getStockReport();

        // 2. Filtered incoming goods report
        $incomingReport = $this->reportService->getIncomingReport($filterType, $startDate, $endDate);

        // 3. Filtered outgoing goods report
        $outgoingReport = $this->reportService->getOutgoingReport($filterType, $startDate, $endDate);

        // Low stock items for navbar notifications
        $allLowStockItems = $this->itemService->getLowStockItems();

        return view('reports.index', compact(
            'stockReport',
            'incomingReport',
            'outgoingReport',
            'filterType',
            'startDate',
            'endDate',
            'activeTab',
            'allLowStockItems'
        ));
    }
}
