<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Laravelove Artisan komande koje su definisane za aplikaciju.
     *
     * @var array
     */
    protected $commands = [
        // Definišite prilagođene Artisan komande ovde.
    ];

    /**
     * Definišite raspored za Artisan komande.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Definišite zadatke koje treba izvršavati periodično.
    }

    /**
     * Registrujte događaje za pokretanje nakon izvršavanja naredbi.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}