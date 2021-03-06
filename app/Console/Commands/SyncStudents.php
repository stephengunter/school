<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Repositories\TPSync\Users;

class SyncStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:students';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Students';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Users $users)
    {
        parent::__construct();

        $this->users = $users;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->users->syncStudents();
        $this->info('Sync Students Has Done.');
    }
}
