<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\Teamplus\EventService;


class SyncEvents extends Command
{
    
    protected $signature = 'sync:events';

   
    protected $description = 'Sync Events';

    
    public function __construct(EventService  $eventService)
    {
        parent::__construct();

        $this->eventService = $eventService;
      
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       
        $text='Events Sync Done';
       
        $this->eventService->syncEvents();

        $this->info($text);
    }
}
