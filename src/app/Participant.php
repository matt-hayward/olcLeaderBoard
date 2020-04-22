<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $guarded = ['id'];

    public function incrementVote()
    {
        $this->score++;
        $this->save();
    }

    public function decrementVote()
    {
        $this->score--;
        $this->save();
    }
}
