<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateParticipantRequest;
use App\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index()
    {
        return view('add_yourself');
    }

    public function store(CreateParticipantRequest $request)
    {
        Participant::create([
            'name' => $request->name,
        ]);

        return redirect()->route('home');
    }
}
