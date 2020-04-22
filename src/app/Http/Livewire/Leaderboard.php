<?php

namespace App\Http\Livewire;

use App\Participant;
use Livewire\Component;

class Leaderboard extends Component
{
    public $participants;

    public function render()
    {
        $this->getParticipants();

        return view('livewire.leaderboard');
    }

    public function addVote(int $id)
    {
        Participant::find($id)->incrementVote();

        $this->render();
    }

    public function removeVote(int $id)
    {
        Participant::find($id)->decrementVote();

        $this->render();
    }

    protected function getParticipants()
    {
        $this->participants = Participant::orderBy('score', 'desc')
            ->orderBy('name', 'asc')
            ->get();
    }

}
