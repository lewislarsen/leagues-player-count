<?php

namespace App\Jobs;

use App\Actions\CheckGameWorldAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CheckGameWorldJob implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $action = new CheckGameWorldAction();
        $action->execute();
    }
}
