<?php

namespace Tests\Feature;

use App\Participant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_the_list_of_participants()
    {
        $participants = factory(Participant::class, 5)->create();

        $response = $this->get(route('home'));

        $response->assertSessionDoesntHaveErrors();

        foreach ($participants as $participant) {
            $response->assertSee($participant->name);
        }
    }

    /** @test */
    public function it_displays_participants_in_order()
    {
        $participants = new Collection();

        $participants->push([
            factory(Participant::class)->create(['name' => 'Foo', 'score' => 12]),
            factory(Participant::class)->create(['name' => 'Bar', 'score' => 10]),
            factory(Participant::class)->create(['name' => 'Baz', 'score' => 8]),
        ]);

        $response = $this->get(route('home'));

        $response->assertSeeInOrder(['Foo', 'Bar', 'Baz']);
    }
}
