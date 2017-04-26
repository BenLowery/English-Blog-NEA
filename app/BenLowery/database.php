<?php
/*
*	Only contains database only functions
*/
namespace App\BenLowery;

/*
* Require all the models here, 
* Models gather our daabase logic
* and providers a set of functions we
* can use to gather information and query
* using an ORM, an ORM makes it incredibly
* easy to work with databases.
* Laravel goves many functions to 
* query the database, this makes things quicker and more
* efficiant for us.
*/
use App\BenLowery\Helper;
use App\Models\Comments as comment;
use App\Models\Posts as post;
use App\Models\Users as user;
use App\Models\Tokens as token;
use Storage;
use Illuminate\Support\Facades\DB;

class Database {


	public function __construct() {
		$this->helper = new \App\BenLowery\Helper;
	}

	public function doesPostExist($url) {
		// Get number of matching posts (should only be 1 or 0)
		$num = post::where('url', $url)->get()->count();

		if($num > 0) {
			return True;
		}

		// If it doesnt exist, return false
		return False;
	}

	// Given a param, get information from post table
	public function getPostInfo($column, $item, $method = "get") {
		// We may want to paginate results rather than getting them explicitly
		// Base this on the method we are given from the extra parameter
		if ($method === "paginate") {
			return post::where($column, $item)->paginate(5);
		}

		// Else return them simply
		return post::where($column, $item)->get();
	}

	// Return everything
	public function getUserInfo() {
		return user::all();
	}
	// Return specific thing (like the post info)
	public function getUserInfoFromIdentity($column, $item) {
		return user::where($column, $item)->get();
	}

	// This only gets accepted posts
	public function getPostInfoAndAccepted($column, $item) {
		return post::where($column, $item)->where('accepted', 'yes')->get();
	}


	public function UpdateCommentTable($emojiname, $url) {
		// Get post id from url
		$postid = post::where('url', $url)->get()[0]->id;

		// Create new comment and fill in info
		$newComment = new comment;
		$newComment->post_id = $postid;
		$newComment->emoji = $emojiname;
		// save to db
		return $newComment->save();
	}

	public function getMostPopularEmoji($url) {
		$pop = [];

		// Get post id from url
		$postid = post::where('url', $url)->get()[0]->id;

		// Get all rows with this post id and convert to array
		$rows = comment::where('post_id', $postid)->get();

		// If empty return happy emoji becasue everyone
		// needs a head start
		if($rows->count() === 0) {
			return "grin";
		}

		foreach ($rows as $row) {
			// Collect all emoji answers
			array_push($pop, $row->emoji);
		}
		// Get numeric values of emojis
		$pop = array_count_values($pop);

		// find most popular
		return array_search(max($pop), $pop);
	}

	/**
	* Pushes a students post to limbo stage of acceptance
	* @param data array
	* @return boolean
	*/
	public function publishPendingToDb($data) {
		/*
		* The data array works like
		* [0] -> title
		* [1] -> description
		* [2] -> contents
		* [3] -> tags
		* [4] -> author
		* [5] -> url
		*/

		// Prepare data for db (using try and catch if we have an error)
		
		$newPost = new post;
		$newPost->url = $data[5];
		$newPost->title = $data[0];
		$newPost->description = $data[1];
		// If tags are empty we pass it as null
		$newPost->tags = $data[3];
		$newPost->author = $data[4];
		// Accepted will always be default "no"
		$newPost->accepted = "no";

		// Create file containing post contents and write to it
		$file = fopen('../resources/views/posts_files/' . $data[5] . '.blade.php', 'w') or die("Something went wrong :(");
		fwrite($file, $data[2]);
		fclose($file);
		
		// Save to db and reroute back to home page
		return $newPost->save();
	}

	// remove the post from the db 
	public function removePostFromDb($item, $column = "url") {
		// Delete post and if it works, delete file and the profane words file using a different method
		if(post::where($column, $item)->delete()) {
			storage::delete('profane/' . $item . '.json');
			return unlink('../resources/views/posts_files/' . $item . '.blade.php');
		}
	}

	// Accept a post
	public function acceptPost($name) {
		// Delete the profane filter json file
		storage::delete('profane/' . $name . '.json');
		return post::where('url', $name)->update(['accepted' => 'yes']);
	}
	// Maybe add to users db if unique, otherwise go straight to token login
	public function perhapsAddToUsers($user_info) {
		// array [0] contains email
		// [1] -> name
		// [2] -> year
		
		// If the user doesnt exist, add user, otherwise pass
		// As true because we wont have errors
		if($this->doesUserExist($user_info[0])) {
			return True;
		}

		// Add user to users DB
		return $this->addItemToUsersTable($user_info);
	}

	
	// Create a user login string, save to db, and send to email
	public function createUserLoginToken($data) {
		$newToken = new token;
		// get user id given email
		$user_id = user::where('email', $data[0])->first()["id"];

		// generate token (encryption of a random 15 character string) - this is a built in laravel helper
		$token = encrypt(str_random(15));

		// Set up data for insertion in table
		$newToken->user_id = $user_id;
		$newToken->token = $token;
		// Send email with email and token
		$this->helper->sendEmail($data[0], $token);
		return $newToken->save();
	}

	// Verify a user login token
	public function doesTokenExist($token) {
		// Get number of matching tokens
		$num = token::where('token', $token)->get()->count();

		if($num > 0) {
			return True;
		}

		// If it doesnt exist, return false
		return False;
	}

	// Log user in
	public function setSessionAndDeleteToken($token) {
		// get user_id from token and set as session
		session()->set('userid', $this->getUserIdFromToken($token));
		
		// Remove token from table and return result
		return $this->removeTokenFromDb($token);
	}

	public function getUserInfoFromSession($item) {
		// First returns a 1d array rather than a multilayed one
		$user = user::where('id', session('userid'))->first();
		// return item user requested
		return $user[$item];
	}

	public function isAdmin() {
		// Get user session or check it exists
		if(session('userid') != null) {
			if(user::where('id', session('userid'))->where('role', 'admin')->get()->count() == 1) {
				return true;
			}
		}
		return False;
	}

	// Protected things, only this class can call them

	protected function getUserIdFromToken($token) {
		// get user
		$user = token::where('token', $token)->first();
		return $user['user_id'];
	}

	// Remove token row from db
	protected function removeTokenFromDb($token) {
		return token::where('token', $token)->delete();
	}

	// If a new user add the user to the table
	protected function addItemToUsersTable($data) {
		/*
		* [0] => email
		* [1] => name
		* [2] => year
		*/
		// Set up a new user and populate with data
		$user = new user;
		$user->email = $data[0];
		$user->author_name = $data[1];
		$user->year = $data[2];
		return $user->save();
	}

	protected function doesUserExist($email) {
		// checks if user 
		//  exists
		$query = user::where('email', $email)->get();

		// Check if number is found
		if (!$query->count() == 0) {
			// return results of query
			return True;
		}
		// If token isnt found
		return False;
	}

}
