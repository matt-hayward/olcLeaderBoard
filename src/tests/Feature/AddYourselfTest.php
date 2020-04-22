<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddYourselfTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_all_fields()
    {
        $request = $this->post(route('create-participant'));

        $request->assertSessionHasErrors([
            'name' => 'The name field is required.',
            'verification_code' => 'The verification code field is required.',
        ]);
    }

    /** @test */
    public function it_enforces_maximum_name_length()
    {
        $response = $this->post(route('create-participant'), [
            'name' => str_pad('', 256, 'a'),
        ]);

        $response->assertSessionHasErrors([
            'name' => 'The name may not be greater than 255 characters.'
        ]);
    }

    /** @test */
    public function it_requires_the_correct_verification_code()
    {
        $response = $this->post(route('create-participant'), [
            'verification_code' => '67890',
        ]);

        $response->assertSessionHasErrors([
            'verification_code' => 'That verification code isn\'t right!'
        ]);
    }

    /** @test */
    public function it_creates_a_participant()
    {
        $response = $this->post(route('create-participant'), [
            'name' => 'Foo',
            'verification_code' => '12345',
        ]);

        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('participants', [
            'name' => 'Foo',
            'score' => 0,
        ]);
    }
}
