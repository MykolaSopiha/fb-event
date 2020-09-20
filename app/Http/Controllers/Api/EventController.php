<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\Facebook\SendAppEvents;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function send(Request $request)
    {
        $request->validate([
            'app_key' => 'required|string',
            'advertiser_id' => 'required|string'
        ]);

        SendAppEvents::dispatch(
            $request->input('app_key'),
            $request->input('advertiser_id')
        );

        return response()->json(['success' => true ]);
    }
}
