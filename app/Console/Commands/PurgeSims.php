<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PurgeSims extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purge:sims';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all sims';

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
    public function handle()
    {
        DB::table('sim_results')->delete();
        DB::table('members')->update([
            'sim_link' => null,
            'last_sim_update' => null,
            'note' => null
        ]);
    }
}
