<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin Panel</title>
	<!--Include css file(s)-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="{{url('css/global.css')}}">
	<link rel="stylesheet" href="{{url('css/admin.css')}}">
	<!--Font awesome-->
	<script src="https://use.fontawesome.com/5f362bc36d.js"></script>
</head>
<body>
	@include('nav')
	<div class="intro"><h1>Manage Users</h1></div>
	<div class="user__table__container">
		<div class="flex">
			<div class="column__user">
				<h3>Name/Year</h3>
				<hr /><br />
				{{--Loop every user--}}
				@foreach ($user_info as $user)
					<p><a href="#">{{$user->author_name}}</a> / {{$user->year}}</p>
					<br /><br />
				@endforeach

			</div>
		</div>
		<div class="flex">
			<div class="column__role">
				<h3>Role</h3>
				<hr /><br />
				{{--loop again for the roles--}}
				@foreach ($user_info as $user)
					<p>{{$user->role}}</p>
					<br /><br />
				@endforeach
			</div>
		</div>
		<div class="flex">
			<div class="column__published">
				<h3>Published Posts</h3>
				<hr /><br />
				{{--Echo all published posts number--}}
				@foreach ($published_posts as $num)
					<p>{{$num}}</p>
					<br /><br />
				@endforeach
			</div>
		</div>
	</div>
</body>
</html>
