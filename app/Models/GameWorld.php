<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class GameWorld extends Model
{
    public const ACTIVITY = 'Leagues V'; // Constant for "Leagues V"
    protected $guarded = [];

    /**
     * Get the total player count for "Leagues" worlds on a specific day.
     *
     * @param int $daysAgo Number of days ago (0 for today, 1 for yesterday, etc.)
     * @return int
     */
    public static function getLeaguesPlayerCountByDay(int $daysAgo): int
    {
        $date = now()->subDays($daysAgo)->toDateString();

        // Log the query for debugging purposes
        $query = self::where('activity', self::ACTIVITY)
            ->whereDate('created_at', $date)
            ->toSql(); // Get the SQL query
        Log::debug('getLeaguesPlayerCountByDay query: ' . $query);

        return self::where('activity', self::ACTIVITY)
            ->whereDate('created_at', $date)
            ->sum('population');
    }

    /**
     * Get player count data for "Leagues" worlds for the past N days.
     *
     * @param int $days Number of days to fetch data for
     * @return array
     */
    public static function getLeaguesPlayerCountForPastDays(int $days): array
    {
        $startDate = now()->subDays($days - 1)->startOfDay();
        $endDate = now()->endOfDay();

        // Log the query for debugging purposes
        $query = self::where('activity', self::ACTIVITY)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(population) as player_count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->toSql(); // Get the SQL query
        Log::debug('getLeaguesPlayerCountForPastDays query: ' . $query);

        // Query data in one go, grouped by day
        $data = self::where('activity', self::ACTIVITY)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(population) as player_count')
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
                'player_count' => $matchingData ? $matchingData->player_count : 0,
            ];
        }

        return array_reverse($counts); // Return in chronological order
    }

    /**
     * Get average player count for "Leagues" worlds for the past N days.
     *
     * @param int $days Number of days to fetch data for
     * @return array
     */
    public static function getLeaguesAveragePlayerCountForPastDays(int $days): array
    {
        $startDate = now()->subDays($days - 1)->startOfDay();
        $endDate = now()->endOfDay();

        // Log the query for debugging purposes
        $query = self::where('activity', self::ACTIVITY)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, AVG(population) as avg_population')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->toSql(); // Get the SQL query
        Log::debug('getLeaguesAveragePlayerCountForPastDays query: ' . $query);

        // Query data for averages, grouped by day
        $data = self::where('activity', self::ACTIVITY)
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
                'avg_population' => $matchingData ? $matchingData->avg_population : 0,
            ];
        }

        return array_reverse($counts); // Return in chronological order
    }
}
