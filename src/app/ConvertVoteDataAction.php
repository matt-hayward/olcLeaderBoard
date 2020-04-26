<?php

namespace App;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ConvertVoteDataAction
{
    public function execute(array $dates, ?Participant $participant = null) : array
    {
        $winQuery = $this->query(Vote::WIN);
        $failQuery = $this->query(Vote::FAIL);

        if ($participant) {
            $winQuery->whereParticipantId($participant->id);
            $failQuery->whereParticipantId($participant->id);
        }

        $winData = $winQuery->get()->pluck('vote_count', 'posted_at')->toArray();
        $failData = $failQuery->get()->pluck('vote_count', 'posted_at')->toArray();

        return [
            json_encode($this->getDataArray($dates, $winData)),
            json_encode($this->getDataArray($dates, $failData)),
        ];
    }

    protected function query(int $type)
    {
        return Vote::whereType($type)
            ->where('posted_at', '>=', Carbon::now()->subDays(29))
            ->select(DB::raw('count(*) as `vote_count`, `posted_at`'))
            ->groupBy('posted_at')
            ->orderBy('posted_at');
    }

    protected function getDataArray(array $dates, array $data) : array
    {
        $formattedData = [];
        $index = 0;
        foreach ($dates as $key => $date) {
            $set = false;

            foreach ($data as $postedAt => $count) {
                $format = Carbon::parse($postedAt)->format('d-m');

                if ($format == $date) {
                    $formattedData[$index] = $count;
                    $set = true;
                }

                if ($set) {
                    continue;
                }
            }

            if (!$set) {
                $formattedData[$index] = 0;
            }

            $index++;
        }

        return $formattedData;
    }
}
