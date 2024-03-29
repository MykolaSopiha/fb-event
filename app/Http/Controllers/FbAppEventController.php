<?php

namespace App\Http\Controllers;

use App\FbApp;
use App\FbAppEvent;
use App\FbEvent;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FbAppEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $fbAppEvents = FbAppEvent::with(['fbApp', 'fbEvent'])
            ->orderBy('id')
            ->get();

        return response()->view('cabinet.app-events.index', compact('fbAppEvents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $fbApps = FbApp::orderBy('id')
            ->get();

        $fbEvents = FbEvent::with('parameters')
            ->orderBy('id')
            ->get();

        return response()->view('cabinet.app-events.create', compact('fbApps', 'fbEvents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate(FbAppEvent::getRules());

        $fbAppEvent = new FbAppEvent();
        $fbAppEvent->fill($request->validated());

        // TODO: json cast is not working
        $fbAppEvent->parameters = json_encode(
            $request->except([
                '_token',
                '_method',
                'fb_app_id',
                'fb_event_id',
                'value_to_sum'
            ])
        );

        $fbAppEvent->save();

        return redirect()->route('fb-app-events.index')->with(['success' => 'Fb application events was created!']);
    }

    /**
     * Display the specified resource.
     *
     * @param FbAppEvent $fbAppEvent
     * @return void
     */
    public function show(FbAppEvent $fbAppEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FbAppEvent $fbAppEvent
     * @return Response
     */
    public function edit(FbAppEvent $fbAppEvent)
    {
        $fbApps = FbApp::orderBy('id')
            ->get();

        $fbEvents = FbEvent::with('parameters')
            ->orderBy('id')
            ->get();

        return response()->view('cabinet.app-events.edit', compact('fbApps', 'fbEvents', 'fbAppEvent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param FbAppEvent $fbAppEvent
     * @return RedirectResponse
     */
    public function update(Request $request, FbAppEvent $fbAppEvent)
    {
        $request->validate(FbAppEvent::getRules());

        $fbAppEvent->fill($request->validated());
        $fbAppEvent->parameters = $request->except([
            '_token',
            '_method',
            'fb_app_id',
            'fb_event_id',
            'value_to_sum'
        ]);
        $fbAppEvent->save();

        return redirect()->route('fb-app-events.index')->with(['success' => 'Fb application events was updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FbAppEvent $fbAppEvent
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(FbAppEvent $fbAppEvent)
    {
        try {
            $fbAppEvent->delete();
        } catch (Exception $e) {
            return redirect()->route('fb-app-events.index')
                ->with(['error' => 'Fb application events was not deleted!']);
        }

        return redirect()->route('fb-app-events.index')
            ->with(['success' => 'Fb application events was deleted!']);
    }

    /**
     * @param FbAppEvent $fbAppEvent
     * @return Response
     */
    public function logs(FbAppEvent $fbAppEvent)
    {
        $logs = $fbAppEvent->fbAppEventLogs()->latest(100);

        return response()->view('cabinet.app-events.logs', compact('logs'));
    }
}
