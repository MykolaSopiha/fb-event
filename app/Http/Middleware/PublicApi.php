<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicApi
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $validator = Validator::make($request->all(), [
            'api_key' => 'required|exists:users,api_key',
        ]);

        if ($validator->fails()) {
            return response()->json(['api_key is not valid'], 401);
        }

        $user = User::where('api_key', $request->input('api_key'))->firstOrFail();
        Auth::onceUsingId($user->id);

        return $next($request);
    }
}
