<?php

namespace App\Http\Controllers;

use App\FbApp;
use App\Http\Requests\FbApp\StoreFbApp;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
     * @param StoreFbApp $request
     * @return RedirectResponse
     */
    public function store(StoreFbApp $request)
    {
        $fbApp = new FbApp();
        $fbApp->fill($request->validated());
        Auth::user()->fbApps()->save($fbApp);

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
     * @param StoreFbApp $request
     * @param FbApp $fbApp
     * @return RedirectResponse
     */
    public function update(StoreFbApp $request, FbApp $fbApp)
    {
        Auth::user()->fbApps()->findOrFail($fbApp->id)->update($request->validated());

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
        $logs = $fbApp->fbAppEventLogs()->latest()->limit(100)->get();

        return response()->view('cabinet.applications.logs', compact('logs'));
    }
}
