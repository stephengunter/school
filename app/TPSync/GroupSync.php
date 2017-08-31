<?php

namespace App\TPSync;

use App\TPSync\BaseTPSyncModel;

class GroupSync extends BaseTPSyncModel
{
    protected $table = 'group_sync';
    protected $fillable = [  
        'code', 'name' ,'members', 'admin', 
        'tp_id','is_delete', 'sync'
     
    ];

    
            
}
