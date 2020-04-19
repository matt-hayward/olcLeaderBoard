@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="w-75 ml-auto mr-auto" id="leaderboard">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Points</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($participants as $participant)
                        <tr>
                            <td>{{$participant->name}}</td>
                            <td>{{$participant->score}}</td>
                            <td>
                                <form action="{{route('cast-vote', ['participant' => $participant])}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">+1</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
