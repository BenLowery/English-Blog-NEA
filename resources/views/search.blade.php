<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin Panel</title>
	<!--Include css file(s)-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="{{url('css/global.css')}}">
	<link rel="stylesheet" href="{{url('css/search.css')}}">
	<!--Font awesome-->
	<script src="https://use.fontawesome.com/5f362bc36d.js"></script>
</head>
<body>
	@include('nav')
	<div class="search__input__container">
		<form class="form" id="form" action="{{url('/search')}}" method="post">
			<i style="color: #696969; height: 40px;" class="fa fa-search fa-2x" aria-hidden="true"></i><input type="text" name="query" placeholder="Search" />
			{{ csrf_field() }}
			<button type="submit" name="submit">Search</button>
		</form>
	</div>
	<div class="results__container">
		{{--isset and Forelse so we can have an empty array--}}
		@if (isset($posts)) 
			@forelse ($posts as $post)
				<div class="results__item">
					{{--Because we changed to array we need to treat all these as an array--}}
					<h3><a href="post/{{$post['url']}}">{{$post['title']}}</a></h3>
					<p>{{$post['description']}}...</p>
				</div>
			@empty
				<p style="text-align: center; font-size: 22px;">Nothing found.</p>
			@endforelse
		@endif
	</div>
</body>
</html>
