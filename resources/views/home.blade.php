<!DOCTYPE html>
<html lang="en">
<head>
	<!--Include css file(s)-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="{{url('css/home.css')}}">
	
	<title>SHTC English</title>
</head>
<body>
	<nav>
		Navbar goes here.
	</nav>

	<div class="header">
		<img src="{{url('img/Shtc_english_logo.png')}}" alt="SHTC english">
		<h1>English @ SHTC</h1>
	</div>
	<div class="postlist__container">
		@foreach ($posts as $post) 
			<div class="postlist__item">
				<h3><a href="post/{{$post->url}}">{{$post->title}}</a></h3>
				<p>{{$post->description}}...</p>
			</div>
		@endforeach
	</div>
	
</body>
</html>