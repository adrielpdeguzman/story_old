<?php

use Carbon\Carbon;

if (! function_exists('season')) {
    /**
     * Computes the current season of story based on given dates.
     *
     * @param   string  $publishDate
     * @param   string  $anniversaryDate
     * @return  integer
     */
    function season($publishDate, $anniversaryDate)
    {
        $carbonPublishDate = Carbon::parse($publishDate);
        $carbonAnniversaryDate = Carbon::parse($anniversaryDate);

        return $carbonPublishDate->diffInMonths($carbonAnniversaryDate) + 1;
    }
}

if (! function_exists('episode')) {
    /**
     * Computes the current episode of story based on given dates.
     *
     * @param   string  $publishDate
     * @param   string  $anniversaryDate
     * @return  integer
     */
    function episode($publishDate, $anniversaryDate)
    {
        $carbonPublishDate = Carbon::parse($publishDate);
        $carbonAnniversaryDate = Carbon::parse($anniversaryDate);

        return $carbonPublishDate->diffInDays($carbonAnniversaryDate) + 1;
    }
}

if (! function_exists('season_episode')) {
    /**
     * Computes the episode relative to current season based on given dates.
     *
     * @param   string  $publishDate
     * @param   string  $anniversaryDate
     * @return  integer
     */
    function season_episode($publishDate, $anniversaryDate)
    {
        $carbonPublishDate = Carbon::parse($publishDate);
        $carbonSeasonDate = Carbon::parse($anniversaryDate);
        $carbonSeasonDate->year = $carbonPublishDate->year;

        if ($carbonPublishDate->day < $carbonSeasonDate->day) {
            $carbonSeasonDate->month = $carbonPublishDate->copy()->subMonth()->month;
        } else {
            $carbonSeasonDate->month = $carbonPublishDate->month;
        }

        return $carbonPublishDate->diffInDays($carbonSeasonDate, true) + 1;
    }
}
