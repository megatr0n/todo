@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Project
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

					
                    <!-- New Project Form -->
                    <form action="{{ url('project') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Project Name -->
                        <div class="form-group">
					
						
                            <label for="task-name" class="col-sm-3 control-label">Name</label>

                            <div class="col-sm-6">
                                <input type="text" name="name" id="task-name" class="form-control" value="{{ old('project') }}">
                            </div>
                            <br /><br />
                            <label for="task-name" class="col-sm-3 control-label">Details</label>

                            <div class="col-sm-6">
                                <textarea name="detail" id="task-name" class="form-control" value="{{ old('detail') }}" rows="4">Write details of the project here.</textarea>
                            <br /><br />								
                            </div>
						
						
							<!-- remove below this -->

							<!-- remove above this -->							
						
                        <!-- Add Project Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6"><span>&nbsp&nbsp</span>
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Add Project
                                </button>
                            </div>
                        </div>
                    </form>	
                </div>
            </div>
        </div>
            <!-- Current Projects -->
            @if (count($projects) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Current Projects
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <thead>
                                <th>Name</th>
								<th>Details</th>
								<th>Date</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr>
                                        <td class="table-text"><div>{{ $project->name }}</div></td>
										<td class="table-text"><div>{{ $project->detail }}</div></td>
										<td class="table-text"><div>{{ $project->created_at }}</div></td>
										
										
										<!-- Project Modify Button -->
										<td>
											<form action="{{url('/modify')}}" method="POST">
												{{ csrf_field() }}			
												<input type="hidden" name="projectid" value="{{ $project->id }}" />
												<button type="submit" id="modify-project-{{ $project->id }}" class="btn btn-danger">
													<i class="fa fa-btn fa-trash"></i>Modify
												</button>
											</form>
										</td>	
										
										
                                        <!-- Project Delete Button -->
                                        <td>
                                            <form action="{{url('project/' . $project->id)}}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <button type="submit" id="delete-project-{{ $project->id }}" class="btn btn-danger">
                                                    <i class="fa fa-btn fa-trash"></i>Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>									
                                @endforeach
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