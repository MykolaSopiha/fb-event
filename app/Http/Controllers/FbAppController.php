<?php

namespace App\Http\Controllers;

use App\FbApp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

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

        do {
            $appKey = Str::random(16);
        } while (FbApp::where('key', $appKey)->first() instanceof FbApp);

        $fbApp = new FbApp();
        $fbApp->fill($request->all());
        $fbApp->key = $appKey;
        $fbApp->save();

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
     * @param int $fbAppId
     * @return Response
     */
    public function edit(int $fbAppId)
    {
        $fbApp = FbApp::findOrFail($fbAppId);
        return response()->view('cabinet.applications.edit', compact('fbApp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $fbAppId
     * @return RedirectResponse
     */
    public function update(Request $request, int $fbAppId)
    {
        $request->validate(FbApp::getRules());

        $fbApp = FbApp::findOrFail($fbAppId);
        $fbApp->update($request->all());

        return redirect()->route('fb-apps.index')->with(['success' => "Application was updated!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        FbApp::destroy($id);
        return redirect()->route('fb-apps.index')->with(['success' => "Application was deleted!"]);
    }

    /**
     * @param FbApp $fbApp
     * @return Response
     */
    public function logs(FbApp $fbApp)
    {
        $logs = $fbApp->fbAppEventLogs()
            ->orderBy('id')
            ->limit(100)
            ->get();

        return response()->view('cabinet.applications.logs', compact('logs'));
    }
}
