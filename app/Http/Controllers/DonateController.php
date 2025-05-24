<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\DonateThankMail;
use Illuminate\Support\Facades\Log;

class DonateController extends Controller
{
    public function redirectToNode(Request $request)
    {
        $amount = $request->input('amount');
        $user = Auth::user();

        // Sinh orderCode nhỏ hơn 9007199254740991 (9 chữ số ngẫu nhiên)
        $orderCode = rand(100000000, 999999999);

        // 1. Lưu trước giao dịch vào DB
        $donation = \App\Models\Donation::create([
            'user_id'    => $user ? $user->id : null,
            'email'      => $user ? $user->email : $request->input('email'),
            'amount'     => (int)$amount,
            'currency'   => 'VND',
            'order_code' => $orderCode,
            'status'     => 'pending',
            'description'=> 'Donate: ' . ($user->username ?? 'Khách'),
            'pay_method' => 'PayOS',
        ]);

        $payload = [
            'amount' => (int) $amount,
            'description' => 'Donate: ' . ($user->username ?? 'Khách'),
            'orderCode' => $orderCode, // Đúng mã order_code đã lưu
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
        return redirect()->route('home')->with('success', 'Thanks for your donation!');
    }

    //admin
public function adminIndex(Request $request)
{
    // Chỉ lấy giao dịch thành công
    $query = \App\Models\Donation::with('user')->where('status', 'success');

    // Tìm kiếm theo email
    if ($request->filled('email')) {
        $query->where('email', 'like', '%' . $request->email . '%');
    }
    // Tìm kiếm theo username
    if ($request->filled('username')) {
        $query->whereHas('user', function($q) use ($request) {
            $q->where('username', 'like', '%' . $request->username . '%');
        });
    }
    // Lọc theo khoảng số tiền
    if ($request->filled('amount_min')) {
        $query->where('amount', '>=', (int)$request->amount_min);
    }
    if ($request->filled('amount_max')) {
        $query->where('amount', '<=', (int)$request->amount_max);
    }

    $donations = $query->orderByDesc('created_at')->paginate(10)->appends($request->query());

    return view('admin_dashboard.donations.index', compact('donations'));
}



public function webhookPayOS(Request $request)
{
    // Log đầy đủ request
    Log::info('PayOS Webhook RAW:', $request->all());

    $data = $request->input('data', []);

    // Fix: PayOS thực tế không gửi status, mà gửi code/desc → phải tự map
    $orderCode = $data['orderCode'] ?? null;

    // Ưu tiên đọc từ 'status', nếu không có thì lấy 'code' + 'desc'
    $statusRaw = $data['status']
        ?? ($data['code'] === '00' ? 'PAID' : 'CANCELLED');

    $mapStatus = [
        'PAID' => 'success',
        'SUCCESS' => 'success',
        'CANCELLED' => 'cancelled',
        'FAIL' => 'cancelled',
        'FAILED' => 'cancelled',
        'pending' => 'pending',
    ];

    $status = $mapStatus[$statusRaw] ?? 'pending';

    // Update vào DB
    $updated = \App\Models\Donation::where('order_code', $orderCode)->update(['status' => $status]);

    Log::info('Update donation status', [
        'order_code' => $orderCode,
        'raw_status_code' => $statusRaw,
        'final_status' => $status,
        'rows_updated' => $updated,
    ]);

    // Gửi mail cảm ơn nếu thanh toán thành công
// Gửi mail cảm ơn nếu thanh toán thành công
if ($status === 'success') {
    $donation = \App\Models\Donation::where('order_code', $orderCode)->first();
    if ($donation && $donation->email) {
        Mail::to($donation->email)->send(new DonateThankMail($donation));
    }

    // Thêm notification vào bảng email_notifications nếu có user_id (tức là user đã login donate)
    if ($donation && $donation->user_id) {
        \App\Models\EmailNotification::create([
            'user_id' => $donation->user_id,
            'type' => 'donate_thank',
            'title' => 'Cảm ơn bạn đã donate!',
            'body' => 'Chúng tôi đã nhận được khoản donate của bạn, cảm ơn bạn rất nhiều!',
            'is_read' => 0
        ]);
    }
}

    return response()->json(['message' => 'OK']);
}

}
