<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DonateController extends Controller
{
    public function redirectToNode(Request $request)
    {
        $amount = $request->input('amount');
        $user = Auth::user();

        $payload = [
            'amount' => (int) $amount,
            'description' => 'Donate: ' . ($user->username ?? 'Khách'),
            'orderCode' => rand(100000, 999999),
            'items' => [],
        ];

        try {
            $response = Http::post('http://localhost:4000/payos/create', $payload);

            if ($response->successful() && isset($response['checkoutUrl'])) {
                return redirect()->away($response['checkoutUrl']);
            }

            return back()->with('error', 'Không thể tạo đơn thanh toán. Vui lòng thử lại.');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi kết nối tới máy chủ thanh toán.');
        }
    }

    public function handleReturn(Request $request)
    {
        return redirect()->route('home')->with('success', 'Cảm ơn bạn đã ủng hộ!');
    }
}
