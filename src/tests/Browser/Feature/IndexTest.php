<?php

namespace Tests\Browser\Feature;

use App\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Tests\DuskTestCase;

class IndexTest extends DuskTestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_the_leaderboard()
    {
        Participant::truncate();

        $this->browse(function (Browser $browser) {
            $participant = factory(Participant::class)->create([
                'name' => 'Foo',
                'score' => 12,
            ]);

            $this->assertDatabaseHas('participants', [
                'name' => 'Foo',
                'score' => 12,
            ]);

            $browser->visit(new HomePage)
                ->assertPresent('@leaderboard')
                ->with('@leaderboard', function (Browser $element) {
                    $element->assertSee('NAME')
                        ->assertSee('POINTS')
                        ->assertSee('Foo')
                        ->assertSee('12');
                });

            // cleanup
            $participant->delete();
        });
    }

    /** @test */
    public function it_increments_score()
    {
        Participant::truncate();

        $this->browse(function (Browser $browser) {
            $participant = factory(Participant::class)->create([
                'score' => 10
            ]);

            $browser->visit(new HomePage)
                ->assertPresent('@leaderboard')
                ->assertPresent('#participant-' . $participant->id)
                ->with('#participant-' . $participant->id, function (Browser $element) {
                    $element->assertPresent('@incScore')
                        ->click('@incScore')
                        ->waitForText('11');
                });

            $participant->refresh();

            $this->assertEquals(11, $participant->refresh()->score);
        });
    }

    /** @test */
    public function it_decrements_score()
    {
        Participant::truncate();

        $this->browse(function (Browser $browser) {
            $participant = factory(Participant::class)->create([
                'score' => 10
            ]);

            $browser->visit(new HomePage)
                ->assertPresent('@leaderboard')
                ->assertPresent('#participant-' . $participant->id)
                ->with('#participant-' . $participant->id, function (Browser $element) {
                    $element->assertPresent('@decScore')
                        ->click('@decScore')
                        ->waitForText('9');
                });

            $participant->refresh();

            $this->assertEquals(9, $participant->refresh()->score);
        });
    }
}
