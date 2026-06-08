<?php

namespace App\Services;

use App\Models\IncomingGoods;
use App\Models\Item;
use App\Models\OutgoingGoods;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ReportService
{
    /**
     * Get stock report data (current inventory status).
     */
    public function getStockReport(): Collection
    {
        return Item::with('category')
            ->orderBy('nama_barang')
            ->get();
    }

    /**
     * Get filtered incoming goods report data.
     */
    public function getIncomingReport(string $filterType, ?string $startDate = null, ?string $endDate = null): Collection
    {
        [$start, $end] = $this->parseDateRange($filterType, $startDate, $endDate);

        $query = IncomingGoods::with('item');

        if ($start && $end) {
            $query->whereBetween('tanggal_masuk', [$start->format('Y-m-d'), $end->format('Y-m-d')]);
        }

        return $query->orderBy('tanggal_masuk', 'desc')->get();
    }

    /**
     * Get filtered outgoing goods report data.
     */
    public function getOutgoingReport(string $filterType, ?string $startDate = null, ?string $endDate = null): Collection
    {
        [$start, $end] = $this->parseDateRange($filterType, $startDate, $endDate);

        $query = OutgoingGoods::with('item');

        if ($start && $end) {
            $query->whereBetween('tanggal_keluar', [$start->format('Y-m-d'), $end->format('Y-m-d')]);
        }

        return $query->orderBy('tanggal_keluar', 'desc')->get();
    }

    /**
     * Helper to parse filterType into Carbon date boundaries.
     */
    public function parseDateRange(string $filterType, ?string $startDate = null, ?string $endDate = null): array
    {
        $today = Carbon::today();
        $start = null;
        $end = Carbon::today()->endOfDay();

        switch ($filterType) {
            case 'today':
                $start = $today;
                break;
            case 'week':
                $start = Carbon::now()->startOfWeek();
                break;
            case 'month':
                $start = Carbon::now()->startOfMonth();
                break;
            case 'custom':
                if (!empty($startDate)) {
                    $start = Carbon::parse($startDate)->startOfDay();
                }
                if (!empty($endDate)) {
                    $end = Carbon::parse($endDate)->endOfDay();
                }
                break;
            default:
                // No date boundary applied
                return [null, null];
        }

        return [$start, $end];
    }
}
