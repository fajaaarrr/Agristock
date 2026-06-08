<?php

namespace App\Services;

use App\Models\Category;
use App\Models\IncomingGoods;
use App\Models\Item;
use App\Models\OutgoingGoods;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * Get compiled dashboard statistics and widget data.
     */
    public function getDashboardStats(): array
    {
        $now = Carbon::now();

        // 1. Core counters
        $totalItems = Item::count();
        $totalCategories = Category::count();

        // 2. Monthly transaction totals
        $totalIncomingThisMonth = IncomingGoods::whereMonth('tanggal_masuk', $now->month)
            ->whereYear('tanggal_masuk', $now->year)
            ->sum('jumlah');

        $totalOutgoingThisMonth = OutgoingGoods::whereMonth('tanggal_keluar', $now->month)
            ->whereYear('tanggal_keluar', $now->year)
            ->sum('jumlah');

        // 3. Widget: Low stock items
        $lowStockItems = Item::with('category')->lowStock()->limit(5)->get();

        // 4. Widget: Recently added items
        $recentItems = Item::with('category')->latest()->limit(5)->get();

        // 5. Widget: Recent Activity (combine latest incoming and outgoing goods)
        $latestIncoming = IncomingGoods::with('item')->latest()->limit(5)->get()->map(function($inc) {
            return [
                'type' => 'incoming',
                'nomor_transaksi' => $inc->nomor_transaksi,
                'nama_barang' => $inc->item->nama_barang,
                'jumlah' => $inc->jumlah,
                'satuan' => $inc->item->satuan,
                'label' => $inc->supplier,
                'tanggal' => $inc->tanggal_masuk,
                'timestamp' => $inc->created_at,
                'keterangan' => $inc->keterangan
            ];
        });

        $latestOutgoing = OutgoingGoods::with('item')->latest()->limit(5)->get()->map(function($out) {
            return [
                'type' => 'outgoing',
                'nomor_transaksi' => $out->nomor_transaksi,
                'nama_barang' => $out->item->nama_barang,
                'jumlah' => $out->jumlah,
                'satuan' => $out->item->satuan,
                'label' => $out->tujuan_penggunaan,
                'tanggal' => $out->tanggal_keluar,
                'timestamp' => $out->created_at,
                'keterangan' => $out->keterangan
            ];
        });

        $recentActivities = $latestIncoming->concat($latestOutgoing)
            ->sortByDesc('timestamp')
            ->take(5)
            ->values()
            ->all();

        // 6. Chart: Monthly transaction data for the current year
        $chartData = $this->getChartData($now->year);

        return [
            'total_items' => $totalItems,
            'total_categories' => $totalCategories,
            'total_incoming_this_month' => $totalIncomingThisMonth,
            'total_outgoing_this_month' => $totalOutgoingThisMonth,
            'low_stock_items' => $lowStockItems,
            'recent_items' => $recentItems,
            'recent_activities' => $recentActivities,
            'chart_data' => $chartData
        ];
    }

    /**
     * Compile monthly totals for incoming and outgoing goods of the current year.
     */
    private function getChartData(int $year): array
    {
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'sqlite') {
            $incomingExpr = "cast(strftime('%m', tanggal_masuk) as integer) as month";
            $outgoingExpr = "cast(strftime('%m', tanggal_keluar) as integer) as month";
        } else {
            $incomingExpr = "MONTH(tanggal_masuk) as month";
            $outgoingExpr = "MONTH(tanggal_keluar) as month";
        }

        $incoming = IncomingGoods::select(
                DB::raw($incomingExpr),
                DB::raw('SUM(jumlah) as total')
            )
            ->whereYear('tanggal_masuk', $year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $outgoing = OutgoingGoods::select(
                DB::raw($outgoingExpr),
                DB::raw('SUM(jumlah) as total')
            )
            ->whereYear('tanggal_keluar', $year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agt', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        $incomingData = [];
        $outgoingData = [];
        $labels = [];

        foreach ($months as $num => $name) {
            $labels[] = $name;
            $incomingData[] = $incoming[$num] ?? 0;
            $outgoingData[] = $outgoing[$num] ?? 0;
        }

        return [
            'labels' => $labels,
            'incoming' => $incomingData,
            'outgoing' => $outgoingData
        ];
    }
}
