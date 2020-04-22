<?php

namespace Tests\Unit;

use App\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
