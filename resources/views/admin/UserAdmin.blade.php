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
	<div class="intro"><h1>Admin Dashboard</h1></div>
	<div class="user__option__container">
		<div class="flex"><div class="user__option">Review Posts<br /><br /><a href="/admin/post_review"><i class="fa fa-archive fa-4x" aria-hidden="true"></i></a></div></div>
		<div class="flex"><div class="user__option">View Users<br /><br /><a href="/admin/manage"><i class="fa fa-id-card fa-4x" aria-hidden="true"></i></a></div></div>
		<div class="flex"><div class="user__option">Create post<br /><br /><a href="/create"><i class="fa fa-pencil-square-o fa-4x" aria-hidden="true"></i></a></div></div>
		<div class="flex"><div class="user__option">Settings<br /><br /><a href="/admin/settings"><i class="fa fa-cogs fa-4x" aria-hidden="true"></i></a></div></div>
	</div>
</div>
</body>
</html>
