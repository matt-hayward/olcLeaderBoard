<?php

namespace Tests\Feature;

use App\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VotesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_loads_the_correct_view()
    {
        $response = $this->get(route('votes'));

        $response->assertSessionDoesntHaveErrors();
        $response->assertViewIs('votes');
    }

    /** @test */
    public function it_sends_correct_data_to_view_when_viewing_global_votes()
    {
        $response = $this->get(route('votes'));

        $response->assertSessionDoesntHaveErrors();
        $response->assertViewHas([
            'participant' => null,
            'votes',
            'dates'
        ]);
    }

    /** @test */
    public function it_sends_participant_to_view_when_viewing_votes_for_participant()
    {
        $participant = factory(Participant::class)->create();

        $response = $this->get(route('votes', ['participant' => $participant]));

        $response->assertSessionDoesntHaveErrors();
        $response->assertViewHas([
            'participant' => $participant,
        ]);
    }
}
