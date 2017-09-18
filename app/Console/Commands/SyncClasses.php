<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ClassesService;

class SyncClasses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:classes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Classes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ClassesService $classesService)
    {
        parent::__construct();

        $this->classesService = $classesService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->classesService->syncClasses();
        $this->info('Sync Classes Has Done.');
    }
}
