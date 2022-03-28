<?php

namespace App\Console\Commands;

use App\Services\RaidBots;
use Illuminate\Console\Command;

class SyncInstances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:instances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get instances from raidbots';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(RaidBots $raidBots)
    {
        return $raidBots->syncInstances();
    }
}
