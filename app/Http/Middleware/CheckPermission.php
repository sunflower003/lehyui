<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // Nếu là admin (dựa trên cột 'role' dạng chuỗi)
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Nếu muốn có logic phân quyền phức tạp hơn thì cần thêm bảng permissions
        // Còn nếu không có, thì chặn lại luôn
        abort(403, 'Bạn không có quyền truy cập.');
    }
}
