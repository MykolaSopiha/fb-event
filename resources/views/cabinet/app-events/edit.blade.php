@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 text-right">
                <a class="btn btn-light" href="{{ route('fb-app-events.index') }}">Back</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('fb-app-events.update', $fbAppEvent->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="selectApplication">Application:</label>
                                <select class="form-control @error('fb_application_id') is-invalid @enderror"
                                        id="selectApplication" name="fb_application_id">
                                    @foreach($fbApps as $fbApp)
                                        <option
                                            value="{{ $fbApp->id }}"
                                            @if ($fbAppEvent->fb_application_id === $fbApp->id) selected @endif
                                        >
                                            {{ $fbApp->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fb_application_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            @foreach($fbEvents as $index => $event)
                                <div class="form-group">
                                    <label for="selectEvent">Type:</label>
                                    <select class="form-control @error('fb_event_id') is-invalid @enderror"
                                            id="selectEvent" name="fb_event_id">
                                        <option value="{{ $event->id }}" {{ $index === 0 ? 'selected' : '' }}>
                                            {{ $event->name }}
                                        </option>
                                    </select>
                                    @error('fb_event_id')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                @foreach($event->parameters as $parameter)
                                    <div class="form-group">
                                        <label for="{{$parameter->name}}">
                                            {{ $parameter->name }} ({{ $parameter->type }})
                                        </label>
                                        <input type="text"
                                               class="form-control @error($parameter->name) is-invalid @enderror"
                                               id="{{ $parameter->name }}" name="{{ $parameter->name }}"
                                               aria-describedby="{{$parameter->name}}_help"
                                               value="{{ $fbAppEvent->parameters[$parameter->name] }}"
                                        >
                                        <small id="{{$parameter->name}}_help" class="form-text text-muted">
                                            {{ $parameter->description }}
                                        </small>

                                        @error($parameter->name)
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                @endforeach
                            @endforeach

                            <div class="form-group">
                                <label for="valueToSumInput">valueToSum:</label>
                                <input type="text" class="form-control @error('value_to_sum') is-invalid @enderror"
                                       id="valueToSumInput" name="value_to_sum" value="{{ $fbAppEvent->value_to_sum }}"
                                       aria-describedby="valueToSumInputHelp">
                                @error('value_to_sum')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror

                                <small id="valueToSumInputHelp" class="form-text text-muted">
                                    необязательное значение, которое Analytics добавляет к другим суммируемым значениям
                                    из одноименных событий в приложении.
                                </small>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
