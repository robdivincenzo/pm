<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Resource Management Tool</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css">
	<!-- ui stylesheet -->
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/ui-lightness/jquery-ui.min.css">
	<!-- custom css -->
	<link rel="stylesheet" href="../css/styles.css" />	
</head>
<body>
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
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
						<li class="nav-header">Welcome, {{ ucwords(Auth::user()->username) }}</li>
						<li> {{ HTML::link('admin', 'Home') }}</li>
						<li> {{ HTML::link('collections', 'Collections View') }} </li>
						<li> {{ HTML::link('excel', 'Excel View') }} </li>
						<li> {{ HTML::link('readers', 'Readers') }} </li>
						<li> {{ HTML::link('contacts', 'Contact Tags') }} </li>
						<li> {{ HTML::link('locations', 'Location Tags') }} </li>
						<li> {{ HTML::link('objects', 'Object Tags') }} </li>
						<li> {{ HTML::link('logout', 'Logout') }} </li>
					@else
						<li>{{ HTML::link('', 'Home') }}</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Projects <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>{{ HTML::link('projects', 'View Projects') }}</li>
								<li>{{ HTML::link('projects/create', 'Add Project') }}</li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Tasks <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>{{ HTML::link('tasks', 'View Tasks') }}</li>
								<li>{{ HTML::link('tasks/create', 'Add Task') }}</li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Resources <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>{{ HTML::link('resources', 'View Resources') }}</li>
								<li>{{ HTML::link('resources/create', 'Add Resource') }}</li>
							</ul>
						</li>		
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>{{ HTML::link('reports/workload', 'View Workload') }}</li>
								<li>{{ HTML::link('reports/due-today', 'Due Today') }}</li>
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
</body>
<script type="text/javascript">
var $ = jQuery.noConflict();

function clone_empty(element) {
	$("."+element.id+"_clone").clone().removeClass("hidden "+element.id+"_clone").addClass(element.id+"_row").insertAfter("."+element.id+"_row:last");
	$("."+element.id+"_row:last > div:last > button").bind("click", function( ){
		clone_delete(this);
	});
	$('.date-picker').each(function(){
		$(this).removeClass('hasDatepicker').datepicker({ dateFormat: "yy-mm-dd" });
	});
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
	$(this).datepicker({ dateFormat: "yy-mm-dd" });
	if( $(this).hasClass("today") ) {
		$(this).datepicker( "setDate", new Date());
	}
});

var date_from = moment().startOf('week').format("YYYY-MM-DD");
var date_to = moment().endOf('week').format("YYYY-MM-DD");

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

</script>
</html>
