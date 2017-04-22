<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin Panel</title>
	<!--Include css file(s)-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="{{url('css/global.css')}}">
	<link rel="stylesheet" href="{{url('css/Student.css')}}">
	<!--Font awesome-->
	<script src="https://use.fontawesome.com/5f362bc36d.js"></script>
	<!--Twemoji library-->
	<link href="https://rawgit.com/ellekasai/twemoji-awesome/gh-pages/twemoji-awesome.css" rel="stylesheet">
</head>
<body>
	@include('nav')
	<div class="intro"><h1>Hello, {{$author}}</h1></div>
	<div class="user__table__container">
		<div class="flex">
			<div class="column__post__name">
				<h3>Post title</h3>
				@foreach($posts as $post)
					@if($post->accepted === "yes")
						<p><a href="/post/{{$post->url}}">{{$post->title}}</a></p>
						<br /><br />
					@else
						<p>{{$post->title}}</p>
						<br /><br />
					@endif
				@endforeach
			</div>
		</div>
		<div class="flex">
			<div class="column__post__status">
				<h3>Status</h3>
				@foreach($posts as $post)
					@if($post->accepted === "yes")
						<p>Accepted</p>
						<br /><br />
					@else
						<p>Pending</p>
						<br /><br />
					@endif
				@endforeach
			</div>
		</div>
		<div class="flex">
			<div class="column__post__emoji">
				<h3>Most Popular Reaction</h3>
				Coming soon
			</div>
		</div>
	</div>
</body>
</html>