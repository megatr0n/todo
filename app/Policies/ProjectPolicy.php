<?php

namespace App\Policies;

use App\User;
use App\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can delete the given project.
     *
     * @param  User  $user
     * @param  Project  $project
     * @return bool
     */
    public function destroy(User $user, Project $project)
    {
        return $user->id === $project->user_id;
    }


	/**
	* Determine whether the user can change the project.
	*
	* @param  \App\User  $user
	* @param  \App\Project  $project
	* @return mixed
	*/
	public function change(User $user, Project $project)
	{
	return $user->id == $project->user_id;
	}
	
}
