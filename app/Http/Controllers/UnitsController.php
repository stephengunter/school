<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Repositories\Units;
use App\Unit;
use App\Http\Requests\UnitRequest;

class UnitsController extends BaseController
{
    protected $key='units';
    public function __construct(Units $units) 
    {
		 $this->units=$units;
	}

    public function index()
    {
        if(!request()->ajax()) return view('units.index');
        $request = request();
        $mode=$request->mode; 
       
        if($mode=='tree'){
           return $this->tree();
        }

        $removed=(int)$request->removed; 
        $units=[];
        if($removed){
            $units=$this->units->trash()
                                           ->get();  
        }else{
            $parent=(int)$request->parent; 
            $units=$this->units->getAll()
                                       ->where('parent',$parent)
                                       ->orderBy('active','desc')
                                       ->orderBy('order','desc')
                                       ->orderBy('updated_at','desc')
                                       ->get();  
        }
        
        
        return response()
            ->json([
                'units' => $units
            ]);
        
    }
    private function tree()
    {
        $units=$this->units->getAll()
                                       ->where('active',true)
                                       ->where('parent',0)
                                       ->orderBy('order','desc')
                                       ->orderBy('updated_at','desc')
                                       ->get();  
        if(count($units)){
            foreach ($units as $unit) {
                $unit->getChildren();
            }
        }
        
        return response()->json(['units' => $units ]);
            
    }
    public function create()
    {
        if(!request()->ajax()){
            return view('units.create');                   
        }  

        $unit= Unit::initialize();
       
        $options=$this->units->options();

        return response()->json([
                    'unit' => $unit,
                     'options' => $options
                ]); 
    }
    public function store(UnitRequest $request)
    {
        $current_user=$this->currentUser();
        $updated_by=$current_user->id;
        $removed=false;
        $values=$request->getValues($updated_by,$removed);
        
        $unit= Unit::create($values);
       
        return response()->json($unit);
      
    }
    public function show($id)
    {
        if(!request()->ajax()){
            $menus=$this->menus($this->key);            
            return view('units.details')
                    ->with([ 'menus' => $menus,
                              'id' => $id     
                        ]);
        }

        $current_user=request()->user();
        
        $unit=Unit::findOrFail($id);
        if(!$unit->canViewBy($current_user)){
            return  $this->unauthorized();   
        }
       
        $unit->getParent();

        $unit->canEdit=$unit->canEditBy($current_user);
        $unit->canDelete=$unit->canDeleteBy($current_user);
        return response()->json(['unit' => $unit]);
    }
    public function edit($id)
    {
        $unit=$this->units->findOrFail($id);    
        $current_user=$this->currentUser();
        if(!$unit->canEditBy($current_user)){
            return  $this->unauthorized(); 
        }

        $unit->getParent();

        $options=$this->units->options();

        return response()->json([
                    'unit' => $unit,
                     'options' => $options
                ]);        
    }
    public function update(UnitRequest $request, $id)
    {
         $current_user=$this->currentUser();       
         $unit = Unit::findOrFail($id);
         if(!$unit->canEditBy($current_user)){
            return  $this->unauthorized();       
         }
         $updated_by=$current_user->id;
         $removed=false;
         $values=$request->getValues($updated_by,$removed);  

         $unit->update($values);
         return response()->json($unit);
    }
    public function updateOrder(Request $request, $id)
    {
        $unit=$this->units->findOrFail($id);
        $current_user=$this->currentUser();
        if(!$unit->canEditBy($current_user)){
            return  $this->unauthorized();         
        }

        $updated_by=$current_user->id;
        $up=$request['up'];
        
        $unit=$this->units->updateDisplayOrder($unit ,$up, $updated_by);
        
        return response()
            ->json([
                'unit' => $unit
            ]);    

    }
    public function destroy($id)
    {
        $current_user=$this->currentUser();      
        $unit=$this->units->findOrFail($id);
        if(!$unit->canDeleteBy($current_user)){
            return  $this->unauthorized();     
        }
        $this->units->delete($id,$current_user->id);

        return response()
            ->json([
                'deleted' => true
            ]);
    }
    public function options()
    {
        $options=$this->units->options();

        return response()->json([
                     'options' => $options
                ]);   
    }
}
