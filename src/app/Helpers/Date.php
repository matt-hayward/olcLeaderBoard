<?php

namespace App\Helpers;

use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;

class Date
{
    public static function getLast30Days() : array
    {
        $startDate = Carbon::now()->subDays(29);

        $range = CarbonPeriod::create($startDate, '1 day', Carbon::now())->toArray();

        $formattedRange = [];

        foreach ($range as $key => $date) {
            $formattedRange[] = $date->format('d-m');
        }

        return $formattedRange;
    }
}
