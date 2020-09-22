<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Validator;

class AppKey
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $validator = Validator::make($request->all(), [
            'app_key' => 'required|exists:fb_apps,key',
        ]);

        if ($validator->fails()) {
            return response()->json(['app_key is not valid'], 401);
        }

        return $next($request);
    }
}
