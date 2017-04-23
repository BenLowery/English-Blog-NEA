<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Our custom database helper
use App\BenLowery\Database;

class studentController extends Controller
{

	public function __construct() {
		$this->db = new \App\BenLowery\Database;
	}

    public function index() {
        return View('student.UserStudent');
    }

    public function postManagement() {
        $popEmoji = [];

    	// Get author name
    	$author_name = $this->db->getUserInfoFromSession('author_name');
    	// Retrieve post information...
    	$posts = $this->db->getPostInfo('author', $author_name)
            //...and sort by accepted in descending order
            ->sortBy('accepted', SORT_REGULAR, True);


        // To go through emojis we only want the accepted posts
        $tempPosts = $this->db->getPostInfoAndAccepted('author', $author_name);
        //get most popular emoji for each post
        foreach ($tempPosts as $post) {
            // Using db function
            $emoji = $this->db->getMostPopularEmoji($post->url);
            array_push($popEmoji, $emoji);
        }

    	return View('student.PostManagement', array('posts' => $posts, 'author' => $author_name, 'popular_emoji' => $popEmoji));
    }
}
