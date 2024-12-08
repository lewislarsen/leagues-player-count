<?php

namespace App\Http\Controllers;

use App\Models\GameWorld;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        // Set a default value for the number of days to look back
        $defaultDays = 8;

        // Get the `days` parameter from the request, ensure it is a positive integer
        $days = $request->query('days', $defaultDays);
        $days = filter_var($days, FILTER_VALIDATE_INT, [
            'options' => ['default' => $defaultDays, 'min_range' => 1, 'max_range' => 30],
        ]);

        $startDate = Carbon::parse(config('leagues.start_date'));
        $endDate = Carbon::parse(config('leagues.end_date'));

        $isWithinLeaguesPeriod = Carbon::now()->between($startDate, $endDate);

        // Retrieve player data for the specified number of days
        $playerData = GameWorld::getLeaguesAveragePlayerCountForPastDays($days);

        // Format the date for each entry
        $playerData = array_map(function ($dayData) {
            $dayData['day'] = Carbon::parse($dayData['day'])->format('l jS F Y');

            return $dayData;
        }, $playerData);

        return view('index', [
            'playerData' => $playerData,
            'isWithinLeaguesPeriod' => $isWithinLeaguesPeriod,
            'days' => $days, // Pass the days parameter to the view for reference
        ]);
    }
}
