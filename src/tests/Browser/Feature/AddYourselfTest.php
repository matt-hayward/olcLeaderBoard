<?php

namespace Tests\Browser\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\AddYourself;
use Tests\Browser\Pages\HomePage;
use Tests\DuskTestCase;

class AddYourselfTest extends DuskTestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_the_form()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new AddYourself)
                ->assertPresent('@form')
                ->with('@form', function (Browser $element) {
                    $element->assertPresent('@inputName')
                        ->assertPresent('@inputVerificationCode')
                        ->assertPresent('@submit')
                        ->assertSee('Name')
                        ->assertSee('Enter your name as you want it to be displayed on the leaderboard.')
                        ->assertSee('Verification Code')
                        ->assertSee('You can request the verification code from a moderator on the OLC Discord.');
                });
        });
    }

    /** @test */
    public function it_submits_to_the_correct_route()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new AddYourself)
                ->assertPresent('@form');

            $expectedLink = route('create-participant');
            $actualLink = $browser->attribute('@form', 'action');

            $this->assertEquals($expectedLink, $actualLink);
        });
    }

    /** @test */
    public function it_displays_error_messages()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new AddYourself)
                ->click('@submit')
                ->waitForText('The name field is required.')
                ->assertSee('The verification code field is required.');
        });
    }

    /** @test */
    public function it_creates_a_participant()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new AddYourself)
                ->type('@inputName', 'FooBar')
                ->type('@inputVerificationCode', '12345')
                ->click('@submit')
                ->on(new HomePage)
                ->assertSee('FooBar');

            $this->assertDatabaseHas('participants', [
                'name' => 'FooBar',
                'score' => 0,
            ]);
        });
    }
}
