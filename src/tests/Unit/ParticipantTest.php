<?php

namespace Tests\Unit;

use App\Participant;
use App\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ParticipantTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_retrieves_name_and_score()
    {
        $participant = factory(Participant::class)->create([
            'name' => 'Foo',
            'score' => 12,
        ]);

        $this->assertEquals('Foo', $participant->name);
        $this->assertEquals(12, $participant->score);
    }

    /** @test */
    public function it_increments_score()
    {
        /** @var Participant $participant */
        $participant = factory(Participant::class)->create([
            'score' => 10,
        ]);

        $participant->incrementVote();

        $this->assertEquals(11, $participant->score);
    }

    /** @test */
    public function it_decrements_score()
    {
        /** @var Participant $participant */
        $participant = factory(Participant::class)->create([
            'score' => 10,
        ]);

        $participant->decrementVote();

        $this->assertEquals(9, $participant->score);
    }

    /** @test */
    public function it_doesnt_decrement_when_score_is_already_zero()
    {
        /** @var Participant $participant */
        $participant = factory(Participant::class)->create([
            'score' => 0,
        ]);

        Carbon::setTestNow(Carbon::now());

        $participant->decrementVote();

        $this->assertEquals(0, $participant->fresh()->score);

        $this->assertDatabaseMissing('votes', [
            'participant_id' => $participant->id,
            'created_at' => Carbon::now()->startOfSecond(),
        ]);
    }

    /** @test */
    public function it_retrieves_related_votes()
    {
        $participant = factory(Participant::class)->create([
            'score' => 3,
        ]);
        $votes = factory(Vote::class, 3)->create([
            'participant_id' => $participant->id,
            'type' => Vote::WIN,
        ]);

        $this->assertEquals($votes->pluck('id'), $participant->votes->pluck('id'));
    }

    /** @test */
    public function it_only_retrieves_votes_for_the_participant()
    {
        $participant = factory(Participant::class)->create([
            'score' => 2,
        ]);
        $participant2 = factory(Participant::class)->create([
            'score' => 3,
        ]);
        $votes = factory(Vote::class, 2)->create([
            'participant_id' => $participant->id,
            'type' => Vote::FAIL,
        ]);
        $votes2 = factory(Vote::class, 3)->create([
            'participant_id' => $participant2->id,
            'type' => Vote::WIN,
        ]);

        $this->assertEquals($votes->pluck('id'), $participant->votes->pluck('id'));
        $this->assertEquals($votes2->pluck('id'), $participant2->votes->pluck('id'));
    }

    /** @test */
    public function it_creates_a_vote_record_when_incrementing_score()
    {
        /** @var Participant $participant */
        $participant = factory(Participant::class)->create([
            'score' => 0,
        ]);

        $participant->incrementVote();

        $this->assertDatabaseHas('votes', [
            'participant_id' => $participant->id,
            'type' => Vote::FAIL,
        ]);

        $this->assertEquals(1, $participant->fresh()->score);
    }

    /** @test */
    public function it_creates_a_vote_record_when_decrementing_score()
    {
        /** @var Participant $participant */
        $participant = factory(Participant::class)->create([
            'score' => 1,
        ]);

        $participant->decrementVote();

        $this->assertDatabaseHas('votes', [
            'participant_id' => $participant->id,
            'type' => Vote::WIN,
        ]);

        $this->assertEquals(0, $participant->fresh()->score);
    }
}
