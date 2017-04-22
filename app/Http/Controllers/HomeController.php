<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Our custom database helper
use App\BenLowery\Database;

class HomeController extends Controller
{

	public function __construct() {
		$this->db = new \App\BenLowery\Database;
	}

    public function DisplayPosts() {
        $posts = $this->db->getPostInfo('accepted', 'yes');
        return view('home', Array('posts' => $posts));
    }

    public function DisplayAbout() {
    	return view('about');
    }
}
