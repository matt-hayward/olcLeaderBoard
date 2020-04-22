<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class AddYourself extends Page
{
    public function url() : string
    {
        return route('add-yourself', [], false);
    }

    public function assert(Browser $browser) : void
    {
        $browser->waitForLocation($this->url());
    }

    public function elements() : array
    {
        return [
            '@form' => '#add_yourself',
            '@inputName' => '#name',
            '@inputVerificationCode' => '#verification_code',
            '@submit' => '#save'
        ];
    }
}
