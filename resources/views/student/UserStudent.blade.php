<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin Panel</title>
	<!--Include css file(s)-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="{{url('css/global.css')}}">
	<link rel="stylesheet" href="{{url('css/User.css')}}">
	<!--Font awesome-->
	<script src="https://use.fontawesome.com/5f362bc36d.js"></script>
</head>
<body>
@include('nav')
	<div class="intro"><h1>Hello, B. Student</h1></div>
	<div class="user__option__container">
		<div class="flex"><div class="user__option">Manage Email Subscription<br /><br /><a href="#">Subscribe</a>/<a href="#" style="color:#000;">Unsubscribe</a></div></div>
		<div class="flex"><div class="user__option">Post Management<br /><br /><a href="/student/posts"><i class="fa fa-align-left fa-4x" aria-hidden="true"></i></a></div></div>
		<div class="flex"><div class="user__option">Create post<br /><br /><a href="/create"><i class="fa fa-pencil-square-o fa-4x" aria-hidden="true"></i></a></div></div>
	</div>
</div>
</body>
</html>