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
        $startDate = Carbon::parse(config('leagues.start_date'));
        $endDate = Carbon::parse(config('leagues.end_date'));

        $isWithinLeaguesPeriod = Carbon::now()->between($startDate, $endDate);

        $playerData = GameWorld::getLeaguesAveragePlayerCountForPastDays(8);

        // Format the date for each entry
        $playerData = array_map(function ($dayData) {
            $dayData['day'] = Carbon::parse($dayData['day'])->format('l jS F Y');

            return $dayData;
        }, $playerData);

        return view('index', [
            'playerData' => $playerData,
            'isWithinLeaguesPeriod' => $isWithinLeaguesPeriod,
        ]);
    }
}
