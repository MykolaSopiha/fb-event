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
                        <form method="POST" action="{{ route('fb-app-events.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="selectApplication">Application:</label>
                                <select class="form-control @error('fb_app_id') is-invalid @enderror"
                                        id="selectApplication" name="fb_app_id">
                                    @foreach($fbApps as $fbApp)
                                        <option value="{{ $fbApp->id }}">
                                            {{ $fbApp->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fb_app_id')
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
                                               aria-describedby="{{$parameter->name}}_help">
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
                                       id="valueToSumInput" name="value_to_sum" value="{{ old('value_to_sum') }}"
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
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
