<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $username = $request->header('username');
        $password = $request->header('password');

        if (empty($username) || empty($password)) {
            return response()->json([
                'responsecode'        => '54',
                'responsedescription' => 'Unauthorized: Missing credentials',
            ], 401);
        }

        if (
            $username !== config('mto.auth.username') ||
            $password !== config('mto.auth.password')
        ) {
            return response()->json([
                'responsecode'        => '54',
                'responsedescription' => 'Unauthorized: Invalid credentials',
            ], 401);
        }

        return $next($request);
    }
}
