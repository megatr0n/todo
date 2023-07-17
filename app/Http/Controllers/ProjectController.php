<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Project; 
use App\Repositories\ProjectRepository;
class ProjectController extends Controller
{
    /**
     * The Project repository instance.
     *
     * @var ProjectRepository
     */
    protected $projects; 

    /**
     * Create a new controller instance.
     *
     * @param  ProjectRepository  $projects
     * @return void
     */
    public function __construct(ProjectRepository $projects)
    {
        $this->middleware('auth');

        $this->projects = $projects;
    }

    /**
     * Display a list of all of the user's projects.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    { 
        return view('projects.index', [
            'projects' => $this->projects->forUser($request->user()),
        ]);
    }

    /**
     * Create a new project.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request->user()->projects()->create([
            'name' => $request->name, 'detail' => $request->detail,
        ]);

        return redirect('/projects');
    }

	
    /**
     * Modify the given project.
     *
     * @param  Request  $request
     * @param  Project  $project
     * @return Response
     */
    public function modify(Request $request)
    {   $project = NULL;
		$project = Project::where('id',$request->projectid)->first();		
        return view('/projects.modify', ['project'=>$project]);
    }		
	

    /**
     * Change the given project record.
     *
     * @param  Request  $request
     * @param  Project  $project
     * @return Response
     */	
    public function change(Request $request)
    {
		$project = Project::where('id',$request->projectid)->first();
        $this->authorize('change', $project);
		
		//update the project record
		Project::where('id', $project->id)->update([
		'name' => $request->name,
		'detail' => $request->detail,
		]);		
        return redirect('/projects');
    }
	
	
    /**
     * Destroy the given project.
     *
     * @param  Request  $request
     * @param  Project  $project
     * @return Response
     */
    public function destroy(Request $request, Project $project)
    {	
		$this->authorize('destroy', $project);
		$project->delete();
		return redirect('/projects');
    }

	

	
}


