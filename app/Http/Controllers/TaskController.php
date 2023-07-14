<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
		$tnum = count($tasks);
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name, 'project' => $request->user_selected, 'priority' => $tnum,
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
    {
    	$this->completeItem = Task::where('status',1)
		                    ->orderBy('priority')
							->get();
	}
			
			
    public function updateItems(Request $request)
    { 
    	$input = $request->all();
		
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

	
	public function populateProjects()
	{
	$projects = Project::all();
	//return view('projects.index', compact(users));
	return $projects; 
	}	
	
	public function saveUser(Request $rq)
	{
	$selectedUser = new SelectedUser;
	$selectedUser->name = $rq->user_selected;
	$selectedUser->save();

	return redirect()->back()->with('success', 'Selected Username added successfuly');
	}
	

	
}


