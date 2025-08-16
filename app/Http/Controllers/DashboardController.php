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
        $totalCustomers = User::where('role', 'member')->where('status', 'active')->count(); // <-- ĐÃ SỬA
        $totalProducts = Product::count();
        $totalOrders = Order::whereIn('status', [
            'Chờ xác nhận',
            'Đã xác nhận',
            'Đang chuẩn bị hàng',
            'Đang giao hàng'
        ])->count();
        $recentOrders = Order::with('user')->where('status', 'Chờ xác nhận')->latest()->take(4)->get();
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
    public function chartData(Request $request)
    {
        $start = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : now()->subDays(7)->startOfDay();

        $end = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : now()->endOfDay();

        // --- Biểu đồ doanh thu ---
        $orders = Order::whereBetween('created_at', [$start, $end])->get();
        $revenueGrouped = $orders->groupBy(fn($order) => $order->created_at->format('d/m'));

        $revenueLabels = [];
        $revenueData = [];
        foreach ($revenueGrouped as $date => $ordersOnDate) {
            $revenueLabels[] = $date;
            $revenueData[] = $ordersOnDate
                ->where('status', 'Đã giao hàng')
                ->where('payment_status', 'Đã thanh toán')
                ->sum('total_price');
        }
        // Thống kê số đơn hàng
        $orderLabels = [];
        $orderSuccess = [];
        $orderCanceled = [];
        $orderCompleted = [];
        $orderProcessing = [];
        foreach ($revenueGrouped as $date => $ordersOnDate) {
            $orderLabels[] = $date;
            $orderSuccess[] = $ordersOnDate->where('status', 'Đã giao hàng')->count();
            $orderCanceled[] = $ordersOnDate->where('status', 'Đơn hàng đã hủy')->count();
            $orderCompleted[] = $ordersOnDate->where('status', 'Đã hoàn hàng')->count();
            $orderProcessing[] = $ordersOnDate
                ->whereIn('status', [
                    'Chờ xác nhận',
                    'Đã xác nhận',
                    'Đang chuẩn bị hàng',
                    'Đang giao hàng'
                ])
                ->count();
        }

        // --- Biểu đồ tăng trưởng người dùng ---
        $users = User::whereBetween('created_at', [$start, $end])->get();
        $userGrouped = $users->groupBy(fn($user) => $user->created_at->format('d/m'));

        $userLabels = [];
        $activeUsers = [];
        $bannedUsers = [];
        foreach ($userGrouped as $date => $usersOnDate) {
            $userLabels[] = $date;
            $activeUsers[] = $usersOnDate->where('status', 'active')->where('role', 'member')->count();
            $bannedUsers[] = $usersOnDate->where('status', 'inactive')->where('role', 'member')->count();
        }

        // thống kê đơn hàng bán chạy
        $topProducts = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->select(
                'products.code',
                'products.name',
                'products.image',
                'products.price',
                DB::raw('SUM(order_details.quantity) as total_sold')
            )
            ->where('orders.status', 'Đã giao hàng')
            ->whereBetween('orders.created_at', [$start, $end])
            ->groupBy('products.id', 'products.name', 'products.image', 'products.price')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();


        return response()->json([
            'revenue' => [
                'labels' => $revenueLabels,
                'data' => $revenueData,
            ],
            'users' => [
                'labels' => $userLabels,
                'active' => $activeUsers,
                'banned' => $bannedUsers,
            ],
            'orders' => [
                'labels' => $orderLabels,
                'success' => $orderSuccess,
                'canceled' => $orderCanceled,
                'completed' => $orderCompleted,
                'processing' => $orderProcessing,
            ],
            'top_products' => $topProducts,
        ]);
    }
}
