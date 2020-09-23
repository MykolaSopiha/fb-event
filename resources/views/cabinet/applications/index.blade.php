@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="alert alert-info" role="alert">
            <b>Send app events to Facebook:</b> {{ rawurldecode(route('api.apps.sendEvents', ['app_key' => '{app_key}', 'advertiser_id' => '{advertiser_id}'])) }}
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-md-12 text-right">
                <a class="btn btn-outline-primary" href="{{ route('fb-apps.create') }}">+ App</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if (count($fbApps))
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">App Id</th>
                                        <th scope="col">Key</th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($fbApps as $fbApp)
                                        <tr>
                                            <th scope="row">{{ $fbApp->name }}</th>
                                            <td>{{ $fbApp->fb_id }}</td>
                                            <td>{{ $fbApp->key }}</td>
                                            <td class="text-right" nowrap>
                                                <a href="{{ route('fb-apps.logs', $fbApp->id) }}"
                                                   class="btn btn-sm btn-outline-info">
                                                    logs
                                                </a>
                                                <a href="{{ route('fb-apps.edit', $fbApp->id) }}" class="btn btn-sm btn-outline-primary">
                                                    edit
                                                </a>
                                                <form class="d-inline" action="{{ route('fb-apps.destroy', $fbApp->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger">delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            Facebook applications are missing...
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
