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
        // Fetch player count for the last 8 days including today
        $playerData = GameWorld::getLeaguesPlayerCountForPastDays(8);

        // Format the date for each entry
        foreach ($playerData as &$dayData) {
            $dayData['day'] = Carbon::parse($dayData['day'])->format('l jS F Y');
        }

        return view('index', ['playerData' => $playerData]);
    }
}
