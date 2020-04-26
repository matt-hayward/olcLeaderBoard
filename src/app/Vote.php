<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Vote extends Model
{
    const FAIL = 0;
    const WIN = 1;

    protected $guarded = ['id'];

    protected $dates = ['posted_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Vote $vote) {
            $vote->posted_at = Carbon::now();
        });
    }

    public function participant() : BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }
}
