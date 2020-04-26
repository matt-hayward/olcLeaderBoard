<?php

namespace App\Http\Controllers;

use App\ConvertVoteDataAction;
use App\Helpers\Date;
use App\Participant;

class VotesController extends Controller
{
    public function __invoke(?Participant $participant = null)
    {
        $dates = Date::getLast30Days();

        return view('votes')->with([
            'participant' => $participant,
            'votes' => (new ConvertVoteDataAction())->execute($dates, $participant),
            'dates' => json_encode(Date::getLast30Days()),
        ]);
    }
}
