@if(session()->has('userid'))
	<nav>
	    <a href="/">Home</a>&nbsp;&nbsp;<a href="/about">About</a>&nbsp;&nbsp;<a href="/search">Search</a>&nbsp;&nbsp;<a href="https://www.twitter.com">Twitter</a>&nbsp;&nbsp;<a href="/create">Create</a><a class="right-float" href="/logout">Logout</a><a class="right-float" href="/dashboard">Dashboard</a>
	</nav>
@else
	<nav>
	    <a href="/">Home</a>&nbsp;&nbsp;<a href="/about">About</a>&nbsp;&nbsp;<a href="/search">Search</a>&nbsp;&nbsp;<a href="https://www.twitter.com">Twitter</a>&nbsp;&nbsp;<a href="/create">Create</a><a class="right-float" href="/login">Login</a>
	</nav>
@endif