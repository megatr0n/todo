<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel Quickstart - Intermediate</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>

    <!-- drag&drop scripts and components -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
<!--   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 --> 
  <style>
    #draggable { 
        width: 150px;
        height: 150px;
        padding: 0.5em;
    }
  </style>	
	
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Task List
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')


	<!-- drag&drop components below-->CONSIDER INTEGRATE TESTBLADE.PHP HERE
	<div class="container">
	  <div class="row">
		<div class="col-md-12">
			<h2 class="text-center pb-3 pt-1">Learning drag and dropable - CodeCheef</h2>
			<div class="row">
				<div class="col-md-5 p-3 bg-dark offset-md-1">
					<ul class="list-group shadow-lg connectedSortable" id="padding-item-drop">
					  @if(!empty($panddingItem) && $panddingItem->count())
						@foreach($panddingItem as $key => $value)
						  <li class="list-group-item" item-id="{{ $value->id }}">{{ $value->name }}</li>
						@endforeach
					  @endif
					</ul>
				</div>
				<div class="col-md-5 p-3 bg-dark offset-md-1 shadow-lg complete-item">
					<ul class="list-group  connectedSortable" id="complete-item-drop">
					  @if(!empty($completeItem) && $completeItem->count())
						@foreach($completeItem as $key => $value)
						  <li class="list-group-item " item-id="{{ $value->id }}">{{ $value->name }}</li>
						@endforeach
					  @endif
					</ul>
				</div>
			</div>
		</div>
	  </div>
	</div>
	<!-- drag&drop components above-->					
	<!-- scripts for drag&drop below -->
	<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
	  $( function() {
		$( "#padding-item-drop, #complete-item-drop" ).sortable({
		  connectWith: ".connectedSortable",
		  opacity: 0.5,
		});
		$( ".connectedSortable" ).on( "sortupdate", function( event, ui ) {
			var pending = [];
			var accept = [];
			$("#padding-item-drop li").each(function( index ) {
			  if($(this).attr('item-id')){
				pending[index] = $(this).attr('item-id');
			  }
			});
			$("#complete-item-drop li").each(function( index ) {
			  accept[index] = $(this).attr('item-id');
			});
			$.ajax({
				url: "{{ route('update.items') }}",
				method: 'POST',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {pending:pending,accept:accept},
				success: function(data) {
				  console.log('success');
				}
			});
			  
		});
	  });
	</script>	
	<!-- scripts for drag&drop above -->			
	
	

</body>
</html>
