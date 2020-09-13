@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-12 text-right">
                <a class="btn btn-outline-primary" href="{{ route('fb-app-events.create') }}">+ Event</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if (count($fbAppEvents))
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Type</th>
                                    <th scope="col">Application</th>
                                    <th scope="col">valueToSum</th>
                                    <th scope="col">Parameters</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($fbAppEvents as $fbAppEvent)
                                    <tr>
                                        <th scope="row">{{ $fbAppEvent->fbEvent->name }}</th>
                                        <td>{{ $fbAppEvent->fbApp->name }}</td>
                                        <td class="text-center">{{ $fbAppEvent->value_to_sum ?? '-/-' }}</td>
                                        <td><code>{{ json_encode($fbAppEvent->parameters) }}</code></td>
                                        <td class="text-right" nowrap>
                                            <a href="{{ route('fb-app-events.edit', $fbAppEvent->id) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                edit
                                            </a>
                                            <form class="d-inline" action="{{ route('fb-app-events.destroy', $fbAppEvent->id) }}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger">delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            Facebook applications are missing...
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
