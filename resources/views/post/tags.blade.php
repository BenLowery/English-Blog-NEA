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
	<h1 style="text-align: center;">Posts tagged with <a href="#">{{$tag}}</a></h1>
	<div class="results__container">
		@while ($count > 0)
			<div class="results__item"><a href="/post/{{$post[$count - 2]}}">{{$post[$count - 1]}}</a></div><br /><br />
			{{--Decrease value by two--}}
			@php
				$count -= 2
			@endphp
		@endwhile
	</div>
</body>
</html>