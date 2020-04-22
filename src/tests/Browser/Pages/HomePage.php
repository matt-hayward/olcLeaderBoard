<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class HomePage extends Page
{
    public function url() : string
    {
        return route('home', [], false);
    }

    public function assert(Browser $browser) : void
    {
        $browser->waitForLocation($this->url());
    }

    public function elements() : array
    {
        return [
            '@leaderboard' => '#leaderboard',
            '@incScore' => '.inc-score',
            '@decScore' => '.dec-score',
        ];
    }
}
