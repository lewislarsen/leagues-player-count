<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class GameWorld extends Model
{
    public const ACTIVITY = 'Leagues'; // Constant for "Leagues"

    protected $guarded = [];

    /**
     * Get the total player count for "Leagues" worlds on a specific day.
     *
     * @param  int  $daysAgo  Number of days ago (0 for today, 1 for yesterday, etc.)
     */
    public static function getLeaguesPlayerCountByDay(int $daysAgo): int
    {
        $date = now()->subDays($daysAgo)->toDateString();

        // Log the query for debugging purposes
        $query = self::where('activity', 'like', '%'.self::ACTIVITY.'%') // Use LIKE to match "Leagues"
            ->whereDate('created_at', $date)
            ->toSql(); // Get the SQL query
        Log::debug('getLeaguesPlayerCountByDay query: '.$query);

        // Return the sum of the population for the specific day
        return self::where('activity', 'like', '%'.self::ACTIVITY.'%') // Use LIKE to match "Leagues"
            ->whereDate('created_at', $date)
            ->sum('population');
    }

    /**
     * Get average player count for "Leagues" worlds for the past N days.
     *
     * @param  int  $days  Number of days to fetch data for
     */
    public static function getLeaguesAveragePlayerCountForPastDays(int $days): array
    {
        $startDate = now()->subDays($days - 1)->startOfDay();
        $endDate = now()->endOfDay();

        // Log the query for debugging purposes
        $query = self::where('activity', 'like', '%'.self::ACTIVITY.'%') // Use LIKE to match "Leagues"
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, AVG(population) as avg_population')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->toSql(); // Get the SQL query
        Log::debug('getLeaguesAveragePlayerCountForPastDays query: '.$query);

        // Query data for averages, grouped by day
        $data = self::where('activity', 'like', '%'.self::ACTIVITY.'%') // Use LIKE to match "Leagues"
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, AVG(population) as avg_population')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Ensure data for all requested days, even if no players are recorded
        $counts = [];
        for ($i = 0; $i < $days; $i++) {
            $date = now()->subDays($i)->toDateString();
            // Look for data matching the date
            $matchingData = $data->firstWhere('date', $date);
            $counts[$i] = [
                'day' => $date,
                'avg_population' => $matchingData ? round($matchingData->avg_population) : 0, // Round to nearest integer for cleaner display
            ];
        }

        return array_reverse($counts); // Return in chronological order
    }
}
