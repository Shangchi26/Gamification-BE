<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  $guards
     * @return string|null
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (Auth::check() && Auth::user()->is_admin) {
            // Nếu người dùng là admin, cho phép truy cập vào route
            return $next($request);
        }

        // Nếu không phải admin, chuyển hướng hoặc xử lý theo ý của bạn
        return redirect('/login'); // Chuyển hướng về trang chủ, bạn có thể thay đổi đường dẫn tùy ý.
    }
}
