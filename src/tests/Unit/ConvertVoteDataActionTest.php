<?php

namespace Tests\Unit;

use App\ConvertVoteDataAction;
use App\Helpers\Date;
use App\Participant;
use App\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ConvertVoteDataActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_global_vote_data()
    {
        $participants = factory(Participant::class, 3)->create();

        foreach ($participants as $participant) {
            Carbon::setTestNow(Carbon::now()->subDays(3));
            $participant->votes()->create([
                'type' => Vote::FAIL,
            ]);
            Carbon::setTestNow();

            Carbon::setTestNow(Carbon::now()->subDays(10));
            $participant->votes()->create([
                'type' => Vote::WIN,
            ]);
            Carbon::setTestNow();

            Carbon::setTestNow(Carbon::now()->subDays(12));
            $participant->votes()->create([
                'type' => Vote::FAIL,
            ]);
            Carbon::setTestNow();
        }

        $expectedWins = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'3',0,0,0,0,0,0,0,0,0,0];
        $expectedFails = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'3',0,0,0,0,0,0,0,0,'3',0,0,0];

        $expectedResult = [
            json_encode($expectedWins),
            json_encode($expectedFails),
        ];

        $actualResult = (new ConvertVoteDataAction())->execute(Date::getLast30Days());

        $this->assertEquals($expectedResult, $actualResult);
    }

    /** @test */
    public function it_returns_vote_data_for_specified_participant()
    {
        $participant1 = factory(Participant::class)->create();
        $participant2 = factory(Participant::class)->create();

        Carbon::setTestNow(Carbon::now()->subDays(3));
        $participant1->votes()->create([
            'type' => Vote::FAIL,
        ]);
        $participant2->votes()->create([
            'type' => Vote::FAIL,
        ]);
        Carbon::setTestNow();

        Carbon::SetTestNow(Carbon::now()->subDays(6));
        $participant1->votes()->create([
            'type' => Vote::WIN,
        ]);
        $participant2->votes()->create([
            'type' => Vote::WIN,
        ]);
        Carbon::SetTestNow();

        $expectedWins = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'1',0,0,0,0,0,0];
        $expectedFails = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'1',0,0,0];

        $expectedResult = [
            json_encode($expectedWins),
            json_encode($expectedFails),
        ];

        $actualResult = (new ConvertVoteDataAction())->execute(Date::getLast30Days(), $participant1);

        $this->assertEquals($expectedResult, $actualResult);
    }
}
