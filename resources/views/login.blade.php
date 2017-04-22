<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<!--Include css file(s)-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="{{url('css/global.css')}}">
	<link rel="stylesheet" href="{{url('css/login.css')}}">
</head>
<body>
	@include('nav')
	<div class="login__container">
			<h1>Login</h1>
			<p>Please enter your school Email, an email containing your login link will then be sent to your school email address.</p><br />
			
			{{--If we have an error flash message--}}
			@if(isset($flash))
				<div class="error">
			                <div style="color:red;"><i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;{{$flash}}</div>
			     </div><br />
		    @endif

			@if (count($errors) > 0)
		       @foreach ($errors->all() as $error)
		            <div class="error">
		                <div style="color:red;"><i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;{{ $error }}</div>
		            </div><br />
		        @endforeach
		    @endif
			<div class="login__form">
				<form id="form" action="{{url('/login')}}" method="post">
					<input type="text" name="email" placeholder="School email" /><br />
					{{ csrf_field() }}
					<button type="submit" name="submit">Submit</button>
				</form>
			</div>
	</div>
</div>
</body>
</html>