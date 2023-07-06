<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Task;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $tasks; 
	protected $panddingItem; 
	protected $completeItem;

    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository  $tasks
     * @return void
     */
    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');

        $this->tasks = $tasks;
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    { 
	 $this->itemView();
        return view('tasks.index', [
            'tasks' => $this->tasks->forUser($request->user()), 'panddingItem' => $this->panddingItem, 'completeItem' => $this->completeItem,
        ]);
    }

    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect('/tasks');
    }

    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/tasks');
    }
	

    public function itemView()
    { //CHANGE TO USE COLUMN NAMES OF TASKS TABLE
    	$this->panddingItem = Task::where('status',0)
		                    ->orderBy('priority')
							->get();
    	$this->completeItem = Task::where('status',1)
		                    ->orderBy('priority')
							->get();
    	//return view('test',compact('panddingItem','completeItem')); this return result of compact(...) 'test' view page.
    	//return view('tasks.index',compact('panddingItem','completeItem'));// send data to 'tasks.index.blade.php' view page.
		 //return compact('panddingItem','completeItem');
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
