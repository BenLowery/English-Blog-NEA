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
	<div class="intro"><h1>Posts needing review</h1></div>
	<div class="post__review__container">
		@foreach ($posts as $post)
			<div class="flex"><a href="#">{{$post->title}}</a>&nbsp;&nbsp;&nbsp;<a href="#postReview_{{$post->url}}"><button>Show</button></a>&nbsp;&nbsp;&nbsp;<a href="/admin/acceptPost/{{$post->url}}"><button>Accept</button></a>&nbsp;&nbsp;&nbsp;<a href="/admin/denyPost/{{$post->url}}"><button>Deny</button></a></div><br />
		@endforeach
	</div>

	@foreach ($posts as $post)
	<!--Post review popup-->
	<div id="postReview_{{$post->url}}" class="popup__container">
		<div class="popup__item__quit"><a href="#"><h1>X</h1></a></div>
	<div class="popup__item__container">
		<div class="popup__item__contents">
			<div class="header">possibly innapropriate words:<br />
				@foreach ($badwords as $badword)
					<mark>{{$badword}}</mark>&nbsp;&nbsp;
				@endforeach
			</div><br /><br />
			<div class="popup__item__text">
				<p>@include('posts_files/' . $post->url)</p>
			</div>	
		</div>
	</div>	
    </div>
    @endforeach
</body>
</html>