<?php

namespace App;
use App\User;
use App\Project;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'detail', 'priority', 'status', 'project'];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'int',
    ];

    /**
     * Get the user that owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
	
	
    /**
     * Get the name of project from the id of project.
     */
    public function projectname()
	{
		$projectname = NULL;
		$projects = Project::where('id', $this->project)->get();
			foreach ($projects as $project)//under normal circumstance this will run only once. 
			{
			 $projectname = $project->name;
			}		
		return $projectname;
    }

	
    /**
     * Get the detail of project from using id of project.
     */
    public function projectdetail()
	{
		$projectdetail = NULL;		
		$projects = Project::where('id', $this->project)->get();
			foreach ($projects as $project)//under normal circumstance this will run only once. 
			{
			 $projectdetail = $project->detail;
			}		
		return $projectdetail;
    }
	
}
