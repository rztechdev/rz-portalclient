<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('ticket:check-sla')->everyFifteenMinutes();

// Database cleanup: auto-prune to prevent bloat on shared hosting
Schedule::command('notifications:prune --days=30')->daily();
Schedule::command('queue:prune-failed --hours=168')->daily();
Schedule::command('queue:prune-batches --hours=168 --cancelled=72 --unfinished=168')->daily();
