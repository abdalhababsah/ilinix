<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TouchLastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
// app/Http/Middleware/TouchLastSeen.php
public function handle($request, Closure $next)
{
    if ($user = $request->user()) {
        $user->onlineStatus()->updateOrCreate(
            [],
            ['status' => 'online', 'last_seen' => now()]
        );
    }
    return $next($request);
}
}
