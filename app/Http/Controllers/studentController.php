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
    	// for dev
    	//session()->set('userid', 1);
		
    	// Get author name
    	$author_name = $this->db->getUserInfoFromSession('author_name');
    	// Retrieve post information
    	$posts = $this->db->getPostInfo('author', $author_name);
    	return View('student.PostManagement', array('posts' => $posts, 'author' => $author_name));
    }
}
