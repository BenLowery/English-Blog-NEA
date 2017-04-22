<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// We arent using the db file, instead including post straight up
use App\Models\Posts as post;
use Validator;

class searchController extends Controller
{

	public function __construct() {
		
	}

    public function display() {
        return View('search');
    }

    public function showResults(Request $request) {

    	/* Validate that the dearch query matches our deifned delimetres,
			Also sanitizes the input so no malicious code gets in.
			We accoomplish this by deifning rules we want the validator to follow
    	*/
    	$validation = Validator::make($request->all(), [
    		'query' => 'required|max:255'
    	]);

    	// redirect if errors
    	if ($validation->fails()) {
            return redirect('/search')
              ->withErrors($validation)
              ->withInput();
       	} 

       	/* 
       	*  Search for post
       	*  since this is a bespoke function
       	* its a protected function in this class
       	* rather than in the db helper class 
       	*/
       	return view('search', array('posts' => $this->searchQuery($request->input('query'))));
    }

    protected function searchQuery($query) {
    	// Where clause using the %like% parameter
    	// we are searching multiple columns
    	// then convert them to arrays so we can merge

    	// search title
    	$title = post::where('title', 'LIKE', '%' . $query . '%')->get()->toArray();
    	// search tags
    	$tags = post::where('tags', 'LIKE', '%' . $query . '%')->get()->toArray();
    	// search author
    	$author = post::where('author', 'LIKE', '%' . $query . '%')->get()->toArray();

    	// merge arrays
    	$results = array_merge($title, $tags, $author);

    	// Sort regular flag to allow multidimensional arrays
    	// to be compared
    	return array_unique($results, SORT_REGULAR);

    }

}
