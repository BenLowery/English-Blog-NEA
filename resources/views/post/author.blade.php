<!DOCTYPE html>
<html lang="en">
<head>
	<title>SHTC english blog</title>
	
	<!--Include css file(s)-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="{{url('css/global.css')}}">
	<link rel="stylesheet" href="{{url('css/meta.css')}}">

</head>
<body>
	@include('nav')
	<h1 style="text-align: center;">Posts by {{$posts[0]->author}}</h1>
	<div class="results__container">
		
		@foreach($posts as $post)
			<div class="results__item"><a href="/post/{{$post->url}}">{{$post->title}}</a></div><br />
		@endforeach
	</div>
</body>
</html>