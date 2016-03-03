<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Resource Management Tool</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

	<!-- ui stylesheet -->
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/ui-lightness/jquery-ui.min.css">
	
	<!-- data tables include -->
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.css"> 
	
	-<!-- custom css -->
	{!! Html::style('css/styles.css') !!}
	<style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body>
	<div class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">RM Tool</a>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					@if(Auth::user())
						<li class="nav-header">{{ ucwords(Auth::user()->username) }}</li>
						<li>{{ Html::link('', 'Home') }}</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Projects <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>{{ Html::link('projects', 'View Projects') }}</li>
								<li>{{ Html::link('projects/create', 'Add Project') }}</li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Tasks <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>{{ Html::link('tasks', 'View Incomplete Tasks') }}</li>
								<li>{{ Html::link('tasks/create', 'Add Task') }}</li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Resources <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>{{ Html::link('resources', 'View Resources') }}</li>
								<li>{{ Html::link('resources/create', 'Add Resource') }}</li>
							</ul>
						</li>		
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>{{ Html::link('reports/workload', 'View Workload') }}</li>
								<li>{{ Html::link('reports/due-today', 'Due Today') }}</li>
							</ul>
						</li>
					@endif
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
                                <li><a href="{{ url('/profile') }}"><i class="fa fa-btn fa-user"></i>Profile</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>

			</div><!--/.nav-collapse -->
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				@yield('content')
			</div>
		</div>
	</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
	<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.js"></script>
</body>
<script type="text/javascript">
var $ = jQuery.noConflict();

function clone_empty(element) {
	$("."+element.id+"_clone").clone(true, true).removeClass("hidden "+element.id+"_clone").addClass(element.id+"_row").insertAfter("."+element.id+"_row:last");
	$("."+element.id+"_row:last > div:last > button").bind("click", function( ){
		clone_delete(this);
	});

	$("."+element.id+"_row:last").find('.date-picker').datepicker({ dateFormat: "yy-mm-dd" });

	$("."+element.id+"_row").find(":checkbox").on("click",function( ){
		var target = $(this).parent().find('input.hidden').val();
		if( $(this).prop("checked") ) {
		        target = 1;
		} else {
			target = 0;
		}
		$(this).parent().find('input.hidden').val(target);
	});
};

function clone_delete(element){
	$(element).closest('div.row').remove();
};

var date_from = moment().startOf('week').format("YYYY-MM-DD");
var date_to = moment().endOf('week').format("YYYY-MM-DD");

$(document).ready( function () {
	$('.data-table').DataTable();

	$('.clone-empty').each( function( ) {
		$(this).bind ("click", function( ){
			clone_empty(this);
		});
	});

	$('.clone-delete').each( function( ) {
		$(this).bind("click", function( ){
			clone_delete(this);
		});
	});

	$('.date-picker').each(function(){
		if(! $(this).parent().parent().hasClass("clone") ) {
			$(this).datepicker({ dateFormat: "yy-mm-dd" });
			if( $(this).hasClass("today") ) {
				$(this).datepicker( "setDate", new Date());
			}
		}
	});


	$( "#from_date" ).datepicker({
	  dateFormat: "yy-mm-dd",
	  changeMonth: true,
	  changeYear: true,
	  onClose: function( selectedDate ) {
	    $( "#to_date" ).datepicker( "option", "minDate", selectedDate );
	  }
	});

	$( "#to_date" ).datepicker({
	  dateFormat: "yy-mm-dd",
	  changeMonth: true,
	  changeYear: true,
	  onClose: function( selectedDate ) {
	    $( "#from_date" ).datepicker( "option", "maxDate", selectedDate );
	  }
	});

	$(':checkbox').on("click",function( ){
		var hidden_input = $(this).parent().find('input.hidden');
		if( $(this).prop("checked") ) {
			hidden_input.val(1);
		} else {
			hidden_input.val(0);
		}
	});

	$(':checkbox').each(function(){
		var hidden_input = $(this).parent().find('input.hidden');
		if( $(this).prop("checked") ) {
			hidden_input.val(1);
		} else {
			hidden_input.val(0);
		}
	});
} );
</script>
</html>
