<div wire:poll.3000ms>
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
            <tr id="participant-{{$participant->id}}">
                <td>{{$participant->name}}</td>
                <td>{{$participant->score}}</td>
                <td class="text-right">
                    <button wire:click="addVote({{$participant->id}})" type="button" class="btn btn-primary btn-sm inc-score">+1</button>
                    <button wire:click="removeVote({{$participant->id}})" type="button" class="btn btn-danger btn-sm dec-score">-1</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
