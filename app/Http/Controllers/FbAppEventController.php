<?php

namespace App\Http\Controllers;

use App\FbApp;
use App\FbAppEvent;
use App\FbEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class FbAppEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $fbAppEvents = FbAppEvent::orderBy('id')
            ->with(['fbApplication', 'fbEvent'])
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
        $fbAppEvent->fill($request->all());

        // TODO: json cast is not working
        $fbAppEvent->parameters = json_encode(
            $request->except([
                '_token',
                '_method',
                'fb_application_id',
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
     * @param int $id
     * @return void
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id)
    {
        $fbAppEvent = FbAppEvent::findOrFail($id);

        $fbApps = FbApp::orderBy('id')
            ->get();

        $fbEvents = FbEvent::with('parameters')
            ->orderBy('id')
            ->get();

        // TODO: json cast is not working
        $fbAppEvent->parameters = json_decode($fbAppEvent->parameters);

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

        $fbAppEvent->fill($request->all());
        $fbAppEvent->parameters = json_encode(
            $request->except([
                '_token',
                '_method',
                'fb_application_id',
                'fb_event_id',
                'value_to_sum'
            ])
        );
        $fbAppEvent->save();

        return redirect()->route('fb-app-events.index')->with(['success' => 'Fb application events was updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        FbAppEvent::destroy($id);

        return redirect()->route('fb-app-events.index')->with(['success' => 'Fb application events was deleted!']);
    }
}
