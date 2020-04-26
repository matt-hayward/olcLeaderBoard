<?php

namespace Tests\Unit;

use App\Participant;
use App\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class VoteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_retrieves_the_related_participant()
    {
        $participant = factory(Participant::class)->create();

        $vote = factory(Vote::class)->create([
            'participant_id' => $participant->id,
        ]);

        $this->assertEquals($participant->id, $vote->participant->id);
    }

    /** @test */
    public function it_sets_posted_at_when_created()
    {
        Carbon::setTestNow(Carbon::parse('2020-01-01'));

        $participant = factory(Participant::class)->create();
        $vote = $participant->votes()->create([
            'type' => Vote::WIN,
        ]);

        $this->assertEquals(Carbon::now(), $vote->posted_at);
    }
}
