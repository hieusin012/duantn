<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // --- Lấy các chỉ số tổng quan ---
        $totalCustomers = User::where('role', 'member')->count(); // <-- ĐÃ SỬA
        $totalProducts = Product::count();
        $totalOrders = Order::whereMonth('created_at', now()->month)->count();
        $recentOrders = Order::with('user')->latest()->take(4)->get();
        $newCustomers = User::where('role', 'member')->latest()->take(4)->get(); // <-- ĐÃ SỬA



        // --- Gửi tất cả dữ liệu qua View ---
        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalProducts',
            'totalOrders',
            'recentOrders',
            'newCustomers',

        ));
    }
    public function getRevenueChartData(Request $request)
    {
        $start = Carbon::parse($request->start_date)->startOfDay();
        $end = Carbon::parse($request->end_date)->endOfDay();

        $orders = Order::whereBetween('created_at', [$start, $end])->get();

        $grouped = $orders->groupBy(function ($order) {
            return Carbon::parse($order->created_at)->format('d/m');
        });

        $labels = [];
        $data = [];

        foreach ($grouped as $date => $ordersOnDate) {
            $labels[] = $date;
            $data[] = $ordersOnDate->sum('total_price');
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }

    public function getUserChartData(Request $request)
    {
        $start = Carbon::parse($request->start_date)->startOfDay();
        $end = Carbon::parse($request->end_date)->endOfDay();

        $users = User::whereBetween('created_at', [$start, $end])->get();

        $grouped = $users->groupBy(function ($user) {
            return Carbon::parse($user->created_at)->format('d/m');
        });

        $labels = [];
        $active = [];
        $banned = [];

        foreach ($grouped as $date => $usersOnDate) {
            $labels[] = $date;
            $active[] = $usersOnDate->where('status', 'active')->count();
            $banned[] = $usersOnDate->where('status', 'inactive')->count();
        }

        return response()->json([
            'labels' => $labels,
            'active' => $active,
            'banned' => $banned
        ]);
    }
}
