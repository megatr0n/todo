<?php

//controller
namespace App\Http\Controllers;
use App\Task;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function itemView()
    {
    	$panddingItem = Task::where('id','>',0)
		                    ->orderBy('id')
							->get();
    	$completeItem = Task::where('id',1)
		                    ->orderBy('id')
							->get();
    	return view('test',compact('panddingItem','completeItem'));
    }
    public function updateItems(Request $request)
    {
		//READ THE TUTORIAL AGAIN AND STUDY THIS FUNCTION
    	$input = $request->all();
        
		if(!empty($input['pending']))
    	{
			foreach ($input['pending'] as $key => $value) {
				$key = $key + 1;
				Task::where('id',$value)
						->update([
							'id'=> 0,
							'id'=>$key
						]);
			}
		}
        
		if(!empty($input['accept']))
    	{
			foreach ($input['accept'] as $key => $value) {
				$key = $key + 1;
				Task::where('id',$value)
						->update([
							'id'=> 1,
							'id'=>$key
						]);
			}
		}
    	return response()->json(['user_id'=>'success']);
    }
}