@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Task
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')
					
                    <!-- New Task Form -->
                    <form action="{{ url('task') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Task Name -->
                        <div class="form-group">
                            <label for="task-name" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-6">
                                <input type="text" name="name" id="task-name" class="form-control" value="{{ old('task') }}" required focus>
                            </div>							
							<br /><br />

                        <!-- Task Detail -->							
                            <label for="task-name" class="col-sm-3 control-label">Details</label>
                            <div class="col-sm-6">
                                <textarea name="detail" id="task-name" class="form-control" value="" rows="4">Write details of the task here.</textarea>
                            </div>
							<br /><br />	
							
                        <!-- Add Task Dropdownlist for Project -->	
						    @if(session('success'))
							  <h1>{{session('success')}}</h1>
						    @endif						

							@if( count($projects)>0 )
								<br /><br /><br /><br />
								<label for="task-project" class="col-sm-3 control-label">Project</label>
								<div class="col-sm-6">									
										<select class="form-control" id="selectproject" name="project" required focus>
											<option value="" disabled selected>Please select project</option>        
												@foreach($projects as $project)
												<option value="{{$project->id}}_{{ $project->name }}">{{ $project->name }}</option>
												@endforeach
										</select>
								</div>									
							@else
								<br /><br /><br /><br />
								<div class="col-sm-6" style="padding-left: 110px;">	
									<label for="task-name" class="col-sm-3 control-label">No&nbsp;project&nbsp;exist&nbsp;for&nbsp;new&nbsp;task&nbsp;assignment.&nbsp;<a href="{{ url('projects') }}">Click&nbsp;here&nbsp;to&nbsp;create&nbsp;one</a>.</label>	
								</div>	
							@endif									
							
                        </div>

                        <!-- Add Task Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Add Task
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Tasks -->
            @if (count($tasks) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Current Tasks
                    </div>			
                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <thead>
                                <th>Name</th>
								<!--<th>Detail</th>-->
								<th>Priority</th>
								<th>Status</th>
								<th>Project</th>
								<th>Date</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody  class="list-group  connectedSortable" id="complete-item-drop">
								@if(!empty($completeItem) && $completeItem->count())
									@foreach ($completeItem as $key => $task)
										<tr item-id="{{ $task->id }}">
											<td class="table-text"><div>{{ $task->name }}</div></td>
											<!--<td class="table-text"><div>{{ $task->detail }}</div></td>-->											
											<td class="table-text"><div>{{ $task->priority }}</div></td>
											<td class="table-text"><div>{{ $task->status }}</div></td>
											<td class="table-text"><div>{{ $task->projectname() }}</div></td>
											<td class="table-text"><div>{{ $task->created_at }}</div></td>


											<!-- Task Edit Button -->
											<td>
												<form action="{{url('/edit')}}" method="POST">
													{{ csrf_field() }}			
													<input type="hidden" name="taskid" value="{{ $task->id }}" />
													<button type="submit" id="edit-task-{{ $task->id }}" class="btn btn-danger">
														<i class="fa fa-btn fa-trash"></i>Edit
													</button>
												</form>
											</td>
											
											<!-- Task Delete Button -->
											<td>
												<form action="{{url('task/' . $task->id)}}" method="POST">
													{{ csrf_field() }}
													{{ method_field('DELETE') }}

													<button type="submit" id="delete-task-{{ $task->id }}" class="btn btn-danger">
														<i class="fa fa-btn fa-trash"></i>Delete
													</button>
												</form>
											</td>
										</tr>
									@endforeach
								@endif	
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="panel panel-default"><div class="panel-body" style="text-align:center;"><h6>empty</h6></div></div>				
            @endif	
        </div>
    </div>					
	<!-- custom scripts below-->
	<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
	   // script for drag&drop below 
	  $( function() {
		$( "#complete-item-drop" ).sortable();
		
		$( ".connectedSortable" ).on( "sortupdate", function( event, ui ) {
			var accept = [];
			
			$("#complete-item-drop tr").each(function( index ) {
			  accept[index] = $(this).attr('item-id');
			});
			$.ajax({
				url: "{{ route('update.items') }}",
				method: 'POST',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {accept:accept},
				success: function(data) {
					console.log('success');
					window.location.reload();
				}
			});
			  
		});
	  });
	  
	  //script for dropdownlist below
	  var mytextbox = document.getElementById('displayproject');
	  var mydropdown = document.getElementById('selectproject');
	  mydropdown.onchange = function(){
		  //alert(this.value+'_'+mydropdown.innerText);
		  mytextbox.value = mytextbox.value  + this.value; //to appened
		  mytextbox.innerHTML = this.value;
		 }	  
	</script>	
	<!-- custom scripts above-->				
@endsection