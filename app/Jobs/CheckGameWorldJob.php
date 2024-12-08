<?php

namespace App\Jobs;

use App\Actions\CheckGameWorldAction;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CheckGameWorldJob implements ShouldQueue
{
    use Queueable;

    /**
     * The league start and end dates.
     */
    private Carbon $startDate;

    private Carbon $endDate;

    public function __construct()
    {
        // Parse the dates from the config and create Carbon instances
        $this->startDate = Carbon::parse(config('leagues.start_date'));
        $this->endDate = Carbon::parse(config('leagues.end_date'));
    }

    /**
     * Check if the current date is within the league period.
     */
    private function isWithinLeaguePeriod(): bool
    {
        return Carbon::now()->between($this->startDate, $this->endDate);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (! $this->isWithinLeaguePeriod()) {
            Log::info('Skipped the job as the OSRS Leagues event is not currently active.');

            return;
        }

        (new CheckGameWorldAction)->execute();
    }
}
