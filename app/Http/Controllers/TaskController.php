<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Task;
use App\Project;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $tasks; 
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
	 $projects = $this->populateProjects();
	 $this->itemView();
        return view('tasks.index', [
            'tasks' => $this->tasks->forUser($request->user()), 'completeItem' => $this->completeItem, 'projects' => $projects,
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
		$tnum = count($this->tasks);
        $this->validate($request, [
            'name' => 'required|max:255',
			'project' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name, 'detail' => $request->detail, 'project' => $request->project, 'priority' => $tnum,
        ]);
		$this->tasks = Task::all();
		$tnum = count($this->tasks);		
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
	

    /**
     * Edit the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function edit(Request $request)
    {   $task = NULL;
		$projects = $this->populateProjects(); 
		$task = Task::where('id',$request->taskid)->first();		
        return view('/tasks.edit', ['task'=>$task, 'projects'=>$projects]);
    }	


    /**
     * Update the given task record.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */	
    public function update(Request $request)
    {
		$task = Task::where('id',$request->taskid)->first();
        $this->authorize('update', $task);
		
		//update the task record
		Task::where('id', $task->id)->update([
		'name' => $request->name,
		'detail' => $request->detail,		
		'status' => $request->status,
		'project' => $request->project,
		]);		
        return redirect('/tasks');
    }	


    /**
     * ItemView(View) all tasks as a list of items.
     *
     */	
    public function itemView()
    {
		if (Task::exists()) {
			$this->completeItem = Task::where('status','>=',0)->orderBy('priority')->get();
		die();
		} else {
		}		
	}
			
			
    public function updateItems(Request $request)
    { 
    	$input = $request->all();	
			if(!empty($input['accept']) && Task::exists())
			{
				foreach ($input['accept'] as $key => $value) {
					
			    //update the task priority
					$key = $key + 1;
					Task::where('id',$value)
							->update([
								'priority'=>$key
							]);
				}
			}
    	return response()->json(['status'=>'success']);
    }

	
	public function populateProjects()
	{
	$projects = Project::all();
	return $projects; 
	}	

	

	
}


