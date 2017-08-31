<?php

namespace App\Repositories;

use App\EventCalendar;
use App\EventCalendarMember;
use App\Repositories\Teamplus\Events;
use DB;
use Carbon\Carbon;

class EventCalendars 
{
    public function __construct(Events $events)        
    {
        $this->events=$events;
    }

    private function findByCode($code)
    {
       return EventCalendar::where('code',$code)
        ->orderBy('start_time','desc')->first();
    }

    public function createOrUpdate($code,$name,$description,$start_time,$end_time,$members)
    {
        
        $this->delete($code); 

        $member_accounts = explode(',', $members);
        $values=[
            'code' => $code,
            'name'=> $name,
            'description' =>  $description,
            'start_time' => $start_time,
            'end_time' => $end_time
        ];

        $eventCalendar= DB::transaction(function() 
        use($values,$member_accounts){
              $eventCalendar=EventCalendar::create($values);
              for($i = 0; $i < count($member_accounts); ++$i) {
                  $member=new EventCalendarMember([
                        'member'=> $member_accounts[$i]
                  ]);
                  $eventCalendar->members()->save($member);
              }

              return $eventCalendar;
        });

        foreach($eventCalendar->members as $member){
            $account=$member->member;
            $name=$eventCalendar->name;
            $description=$eventCalendar->description;
            $start_time=new Carbon($eventCalendar->start_time);
            $end_time=new Carbon($eventCalendar->end_time);

            $member->tp_id=$this->events->create($account, $name, $description, $start_time, $end_time);
            $member->save();
        }

        return $eventCalendar;
         
    }

    public function delete($code)
    {
         $eventCalendar=$this->findByCode($code);

         if($eventCalendar){
            foreach($eventCalendar->members as $member){
                $this->events->delete($member->tp_id);
            }
            $eventCalendar->delete();
         }  

    }

   
    
    
     

   
   
   

  
  
   
   
    
}