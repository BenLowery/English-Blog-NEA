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
	<div class="intro"><h1>Settings <i class="fa fa-cogs" aria-hidden="true"></i></h1></div>
	<div class="setting__container">
		<div class="twitter__container"><label>Add Twitter handle:</label><input type="text" name="twitter" placeholder="@username"></div>
		<label>Banned words (click to edit):</label><br /><div class="content" contenteditable="true">the, actual, words, will, be, added, when, in, production, i, personally, dont, want, to, swear, here, so, here, is, some, loreum, ipsum, or, not</div><br />
		<a href="#addPagePopup">Add new Page (brings up popup)</a>
	<br /><br />
	<a class="styledButton" href="#">Update</a>
	</div>
</body>
</html>