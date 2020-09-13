@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 text-right">
                <a class="btn btn-light" href="{{ route('fb-apps.index') }}">Back</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <form method="POST"
                              action="{{ route('fb-apps.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="applicationNameInput">Application name:</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="applicationNameInput" name="name" value="{{ old('name') }}">
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="applicationFacebookIdInput">ID:</label>
                                <input type="text" class="form-control @error('fb_id') is-invalid @enderror"
                                       id="applicationFacebookIdInput" name="fb_id"
                                       value="{{ old('fb_id') }}">
                                @error('fb_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
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
