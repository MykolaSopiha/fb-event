<?php

namespace App\Http\Controllers\Api;

use App\FbApp;
use App\Http\Controllers\Controller;
use App\Jobs\Facebook\SendAppEvents;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * @param Request $request
     */
    public function send(Request $request)
    {
        $request->validate(['app_key' => 'required|string']);

        SendAppEvents::dispatchNow($request->input('app_key'));
    }
}
