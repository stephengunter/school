<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\UnitsService;

class SyncUnits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:units';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Units';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UnitsService $unitsService)
    {
        parent::__construct();

        $this->unitsService = $unitsService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->unitsService->syncUnits();
        $this->info('Sync Units Has Done.');
    }
}
