<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participant extends Model
{
    protected $guarded = ['id'];

    public function votes() : HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function incrementVote()
    {
        $this->score++;
        $this->save();

        $this->addVote(Vote::FAIL);
    }

    public function decrementVote()
    {
        if ($this->score > 0) {
            $this->score--;
            $this->save();

            $this->addVote(Vote::WIN);
        }
    }

    protected function addVote(int $type) : void
    {
        $this->votes()->create([
            'type' => $type,
        ]);
    }
}
