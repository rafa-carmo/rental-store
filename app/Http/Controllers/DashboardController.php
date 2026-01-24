<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Rental;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $period = $request->input('period', '1'); // Default: 1 month

        $startDate = match ($period) {
            '3' => now()->subMonths(3)->startOfDay(),
            '6' => now()->subMonths(6)->startOfDay(),
            '12' => now()->subMonths(12)->startOfDay(),
            default => now()->subMonth()->startOfDay(),
        };

        $endDate = now()->endOfDay();

        // Items cadastrados no período
        $itemsCount = Item::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Clientes cadastrados no período
        $customersCount = Customer::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Aluguéis no período (baseado na data de retirada)
        $rentalsCount = Rental::query()
            ->whereBetween('pickup_date', [$startDate, $endDate])
            ->count();

        // Devoluções no período (baseado em returned_at)
        $returnsCount = Rental::query()
            ->whereBetween('returned_at', [$startDate, $endDate])
            ->whereNotNull('returned_at')
            ->count();

        // Valor arrecadado no período (aluguéis iniciados no período)
        $totalRevenue = Rental::query()
            ->whereBetween('pickup_date', [$startDate, $endDate])
            ->sum('value');

        return Inertia::render('Dashboard/Index', [
            'stats' => [
                'itemsCount' => $itemsCount,
                'customersCount' => $customersCount,
                'rentalsCount' => $rentalsCount,
                'returnsCount' => $returnsCount,
                'totalRevenue' => $totalRevenue,
            ],
            'period' => $period,
        ]);
    }
}
