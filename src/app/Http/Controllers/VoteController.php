<?php

namespace App\Http\Controllers;

use App\Participant;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function store(Participant $participant)
    {
        $participant->incrementVote();

        return redirect()->route('home');
    }
}
