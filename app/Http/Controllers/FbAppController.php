<?php

namespace App\Http\Controllers;

use App\FbApp;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FbAppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $fbApps = FbApp::with('fbEvents')->orderBy('id')->get();
        return response()->view('cabinet.applications.index', compact('fbApps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return response()->view('cabinet.applications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate(FbApp::getRules());
        FbApp::create($request->validated());

        return redirect()->route('fb-apps.index')->with(['success' => 'Application was created!']);
    }

    /**
     * Display the specified resource.
     *
     * @param FbApp $fbApp
     * @return Response
     */
    public function show(FbApp $fbApp)
    {
        return response()->view('cabinet.applications.show', compact('fbApp'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FbApp $fbApp
     * @return Response
     */
    public function edit(FbApp $fbApp)
    {
        return response()->view('cabinet.applications.edit', compact('fbApp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param FbApp $fbApp
     * @return RedirectResponse
     */
    public function update(Request $request, FbApp $fbApp)
    {
        $request->validate(FbApp::getRules());
        $fbApp->update($request->validated());

        return redirect()->route('fb-apps.index')->with(['success' => "Application was updated!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FbApp $fbApp
     * @return RedirectResponse
     */
    public function destroy(FbApp $fbApp)
    {
        try {
            $fbApp->delete();
        } catch (Exception $e) {
            return redirect()->route('fb-apps.index')->with(['error' => "Application was not deleted!"]);
        }

        return redirect()->route('fb-apps.index')->with(['success' => "Application was deleted!"]);
    }

    /**
     * @param FbApp $fbApp
     * @return Response
     */
    public function logs(FbApp $fbApp)
    {
        $logs = $fbApp->fbAppEventLogs()->latest(100);

        return response()->view('cabinet.applications.logs', compact('logs'));
    }
}
