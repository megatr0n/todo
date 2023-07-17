@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Project
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')
					
                    <!-- Edit Project Form -->
					@if(!empty($project))
						<form action="{{ url('change') }}" method="POST" class="form-horizontal">
							{{ csrf_field() }}

							<!-- Project Name -->
							<div class="form-group">
								<label for="task-name" class="col-sm-3 control-label">Name</label>

								<div class="col-sm-6">
									<input type="text" name="name" id="task-name" class="form-control" value="{{ $project->name }}" required focus>
									<input type="hidden" name="projectid" value="{{ $project->id }}" />
								</div>			
								<br /><br />
								
							<!-- Project Details -->								
								<label for="project-name" class="col-sm-3 control-label">Details</label>

								<div class="col-sm-6">
									<textarea name="detail" id="task-name" class="form-control" value="" rows="4">{{ $project->detail }}</textarea>
								<br /><br />								
							</div>

							<!-- Save Project Button -->
							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-6">
									<button type="submit" class="btn btn-default">
										<i class="fa fa-btn fa-plus"></i>Save Project
									</button>
								</div>
							</div>
						</form>
					@endif
                </div>
            </div>
        </div>
    </div>									
@endsection