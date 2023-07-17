@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Task
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')
					
                    <!-- Edit Task Form -->
					@if(!empty($task))
						<form action="{{ url('update') }}" method="POST" class="form-horizontal">
							{{ csrf_field() }}

							<!-- Task Name -->
							<div class="form-group">
								<label for="task-name" class="col-sm-3 control-label">Name</label>

								<div class="col-sm-6">
									<input type="text" name="name" id="task-name" class="form-control" value="{{ $task->name }}" required focus>
									<input type="hidden" name="taskid" value="{{ $task->id }}" />
								</div>							
								<br /><br />
								
							<!-- Task Detail -->							
								<label for="task-name" class="col-sm-3 control-label">Details</label>
								<div class="col-sm-6">
									<textarea name="detail" id="task-name" class="form-control" value="" rows="4">{{ $task->detail }}</textarea>
								</div>
								<br /><br />	
							
							<!-- Add Task Dropdownlist for Project -->	
								@if(session('success'))
								  <h1>{{session('success')}}</h1>
								@endif						
								<label for="task-project" class="col-sm-3 control-label">Project</label>

								<div class="col-sm-6">
									<select class="form-control" id="selectproject" name="project" required focus>
										<option value="{{$task->project}}">{{$task->projectname()}}</option>        
											@foreach($projects as $project)
											<option value="{{$project->id}}">{{ $project->name }}</option>
											@endforeach
									</select>								
								</div>	

								<div class="col-sm-6">
									@if($task->status > 0)
									<br>	
									<span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>completed <input type="radio" name="status" value="1" checked> 
									<br>
									<span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>incomplete <input type="radio" name="status" value="0"> 											
									@endif

									@if($task->status == 0)
									<br>	
									<span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>completed <input type="radio" name="status" value="1"> 
									<br>
									<span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>incomplete <input type="radio" name="status" value="0"> 		
									@endif									
								</div>
							
							</div>

							<!-- Save Task Button -->
							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-6">
									<button type="submit" class="btn btn-default">
										<i class="fa fa-btn fa-plus"></i>Save Task
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