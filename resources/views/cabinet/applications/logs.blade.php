@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-12 text-right">
                <a class="btn btn-light" href="{{ route('fb-app-events.index') }}">Back</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if (count($logs))
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Desc</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">Response</th>
                                    <th scope="col">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($logs as $log)
                                    <tr>
                                        <th scope="row">{{ $log->desc }}</th>
                                        <td>{{ $log->status }}</td>
                                        <td>@json($log->json_content)</td>
                                        <td>@json($log->json_response)</td>
                                        <td>{{ $log->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            Log are empty...
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
