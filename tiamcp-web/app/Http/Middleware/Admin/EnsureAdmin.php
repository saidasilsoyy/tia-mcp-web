<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        abort_if($user === null, 403);
        abort_unless((string) $user->getAttribute('role') === 'admin', 403);
        abort_unless((string) $user->getAttribute('status') === 'active', 403);

        return $next($request);
    }
}
