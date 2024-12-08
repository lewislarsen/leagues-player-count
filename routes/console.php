<?php

use App\Jobs\CheckGameWorldJob;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new CheckGameWorldJob)
    ->everyThirtyMinutes();
