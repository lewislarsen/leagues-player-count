<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GameWorld extends Model
{
    protected $guarded = [];

    /**
     * Get the total player count for "Leagues" worlds for a specific day since today.
     *
     * @param int $daysAgo Number of days ago (0 for today, 1 for yesterday, etc.)
     * @return int
     */
    public static function getLeaguesPlayerCountByDay(int $daysAgo): int
    {
        $date = now()->subDays($daysAgo)->toDateString();

        return self::where('activity', 'LIKE', '%Leagues%')
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
        $counts = [];

        for ($i = 0; $i < $days; $i++) {
            $counts[$i] = [
                'day' => now()->subDays($i)->toDateString(),
                'player_count' => self::getLeaguesPlayerCountByDay($i),
            ];
        }

        return array_reverse($counts); // Reverse to make oldest day first
    }
}
