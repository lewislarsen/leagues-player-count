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
        // Define start and end dates for leagues
        $startDate = Carbon::parse('27 November 2024');
        $endDate = Carbon::parse('22 January 2025');

        // Check if today is within the leagues period
        $isWithinLeaguesPeriod = Carbon::now()->between($startDate, $endDate);

        // Fetch player count data for the last 8 days, including today
        $playerData = GameWorld::getLeaguesPlayerCountForPastDays(8);

        // Format the date for each entry
        $playerData = array_map(function ($dayData) {
            $dayData['day'] = Carbon::parse($dayData['day'])->format('l jS F Y');
            return $dayData;
        }, $playerData);

        // Pass data to the view
        return view('index', [
            'playerData' => $playerData,
            'isWithinLeaguesPeriod' => $isWithinLeaguesPeriod,
        ]);
    }
}