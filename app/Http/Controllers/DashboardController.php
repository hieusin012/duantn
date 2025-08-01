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
        // --- LƯU Ý QUAN TRỌNG ---
        // SẮP HẾT HÀNG: Model Product của bạn không có cột số lượng tồn kho (stock/quantity).
        // Code đang tạm giả định tên cột là 'stock'. Bạn cần thêm cột này vào table `products`
        // và thay đổi 'stock' nếu tên cột của bạn khác.
        $start = $request->input('start_date') ?? Carbon::now()->startOfMonth()->toDateString();
        $end = $request->input('end_date') ?? Carbon::now()->endOfMonth()->toDateString();

        // --- Lấy các chỉ số tổng quan ---
        $totalCustomers = User::where('role', 'member')->count(); // <-- ĐÃ SỬA
        $totalProducts = Product::count();
        $totalOrders = Order::whereMonth('created_at', now()->month)->count();
        $recentOrders = Order::with('user')->latest()->take(4)->get();
        $newCustomers = User::where('role', 'member')->latest()->take(4)->get(); // <-- ĐÃ SỬA

        // --- Dữ liệu cho BIỂU ĐỒ DOANH THU 6 THÁNG ('barChartDemo')---
        $revenueData = Order::select(
            DB::raw("DATE(created_at) as date"),
            DB::raw("SUM(total_price) as total")
        )
            ->where('status', 'Đã giao hàng')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy(DB::raw("DATE(created_at)"))
            ->orderBy('date')
            ->get();

        $dates = $revenueData->pluck('date');
        $totals = $revenueData->pluck('total');
        $totalRevenue = collect($revenueData)->sum('total');

        // --- Dữ liệu cho BIỂU ĐỒ KHÁCH HÀNG MỚI 6 THÁNG ('lineChartDemo') ---
        $newCustomerData = User::select(
            DB::raw('COUNT(id) as count'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
        )
            ->where('role', 'member') // <-- ĐÃ SỬA
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $customerLabels = $newCustomerData->pluck('month');
        $customerValues = $newCustomerData->pluck('count');

        // --- Gửi tất cả dữ liệu qua View ---
        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalProducts',
            'totalOrders',
            'recentOrders',
            'newCustomers',
            'customerLabels',
            'customerValues',
            'dates',
            'totals',
            'start',
            'end',
            'totalRevenue'
        ));
    }
}
