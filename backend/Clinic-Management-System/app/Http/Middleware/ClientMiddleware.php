<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return response()->json([
                'status' => 'error',
                'message' => 'احراز هویت انجام نشده است.',
            ], 401);
        }

        if ($request->user()->role !== UserRole::Client) {
            return response()->json([
                'status' => 'error',
                'message' => 'این بخش فقط برای بیماران قابل دسترسی است.',
            ], 403);
        }

        return $next($request);
    }
}
