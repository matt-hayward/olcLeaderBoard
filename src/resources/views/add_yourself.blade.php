@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h2>Get added to the leaderboard</h2>
                <p>Submit your name and the verification code below.</p>
                <form action="{{url(route('create-participant'))}}" id="add_yourself" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
                        @if ($errors->has('name'))
                            <small class="text-danger">{{$errors->first('name')}}</small>
                        @endif
                        <small class="form-text text-muted">Enter your name as you want it to be displayed on the leaderboard.</small>
                    </div>
                    <div class="form-group">
                        <label for="verification_code">Verification Code</label>
                        <input type="text" class="form-control" id="verification_code" name="verification_code" value="{{{old('verification_code')}}}">
                        @if ($errors->has('verification_code'))
                            <small class="text-danger">{{$errors->first('verification_code')}}</small>
                        @endif
                        <small class="form-text text-muted">You can request the verification code from a moderator on the OLC Discord.</small>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Get Added</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
