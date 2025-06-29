<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function getOrderChartData(Request $request)
    {
        // filter_by ইনপুট এখন আর ব্যবহার করা হবে না, সরাসরি 'month' ব্যবহার করা হবে
        // $filterBy = $request->input('filter_by', 'month');

        // Shop ID নেওয়া হচ্ছে
        $shopId = $request->input('shop_id');

        // shop_id যদি না থাকে, তাহলে একটি এরর রেসপন্স পাঠানো উচিত
        if (empty($shopId)) {
            return response()->json(['error' => 'Shop ID is required.'], 400);
        }

        $query = Order::query();
        // সকল কোয়েরিতে shop_id ফিল্টার যোগ করা হচ্ছে
        $query->where('shop_id', $shopId);

        $data = []; // চার্টের ডেটা সংরক্ষণ করার জন্য অ্যারে
        $labels = []; // চার্টের লেবেল সংরক্ষণ করার জন্য অ্যারে

        // --- শুধু বর্তমান মাসের ডেটা ফিল্টারিং লজিক ---
        $startDate = Carbon::now()->startOfMonth(); // মাসের শুরু
        $endDate = Carbon::now()->endOfMonth();     // মাসের শেষ

        $query->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total_orders, SUM(total_amount) as total_revenue')
            ->groupBy('date')
            ->orderBy('date');

        $results = $query->get()->keyBy('date'); // তারিখ অনুযায়ী ফলাফলকে ইনডেক্স করুন

        // মাসের সব দিনের জন্য ডেটা প্রিপেয়ার করা
        // বর্তমান মাসের মোট দিনের সংখ্যা
        $daysInMonth = $endDate->day;

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = Carbon::create($startDate->year, $startDate->month, $i)->format('Y-m-d');
            $data[$date] = [
                'total_orders' => $results[$date]->total_orders ?? 0,
                'total_revenue' => $results[$date]->total_revenue ?? 0,
            ];
            $labels[] = Carbon::parse($date)->format('M d'); // লেবেল: Jan 01, Jan 02
        }

        // ডেটাসেট তৈরি করুন
        $orderCounts = array_column($data, 'total_orders');
        $revenues = array_column($data, 'total_revenue');

        return response()->json([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Total Orders',
                    'data' => $orderCounts,
                    'borderColor' => '#4CAF50', // সবুজ
                    'tension' => 0.1,
                    'fill' => false,
                ],
                [
                    'label' => 'Total Revenue',
                    'data' => $revenues,
                    'borderColor' => '#2196F3', // নীল
                    'tension' => 0.1,
                    'fill' => false,
                ]
            ]
        ]);
    }
}
