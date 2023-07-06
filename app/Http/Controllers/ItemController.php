<?php

//controller
namespace App\Http\Controllers;
use App\Task;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function itemView()
    { //CHANGE TO USE COLUMN NAMES OF TASKS TABLE
    	$panddingItem = Task::where('status',0)
		                    ->orderBy('priority')
							->get();
    	$completeItem = Task::where('status',1)
		                    ->orderBy('priority')
							->get();
    	return view('test',compact('panddingItem','completeItem'));
    }
    public function updateItems(Request $request)
    { 
	  //DONE*** MODIFY TASK TABLE TO INCLUDE 'STATUS' AND 'ORDER' COLUMNS.
	  //consider using strings for status such as 'pending' and 'complete'
    	$input = $request->all();
        
		if(!empty($input['pending']))
    	{
			foreach ($input['pending'] as $key => $value) {
				$key = $key + 1;
				Task::where('id',$value)
						->update([
							'status'=>0,
							'priority'=>$key
						]);
			}
		}
        
		if(!empty($input['accept']))
    	{
			foreach ($input['accept'] as $key => $value) {
				$key = $key + 1;
				Task::where('id',$value)
						->update([
							'status'=>1,
							'priority'=>$key
						]);
			}
		}
    	return response()->json(['status'=>'success']);
    }
}