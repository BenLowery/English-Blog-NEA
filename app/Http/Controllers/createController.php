<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
// Our custom database helper
use App\BenLowery\Database;
// For validating pages
use Validator;

// For storing things
use Storage;

class createController extends Controller {


	// Variables for text analysis
	private $text;
	private $textArr;
	

    public function __construct() {
    	$this->db = new \App\BenLowery\Database;
    }

	public function editor() {
		return view('editor');
	}

	public function publishPending(Request $request) {
		// Empty array containing post data
		$info = [];

		// Using the laravel validation package, it makes things easier
		// We use validation so we dont get any dodgy inputs inside our database
		// The title only allowed characters which are alphanumeric or space.
		$validation = Validator::make($request->all(), [
				'title' => 'required|regex:/^[\pL\s\d]+$/u|max:128|unique:post,title', 
				'contents' => 'required'
		], 
		// Custom error message for the regex handler
		['regex' => 'the :attribute has to be alphanumeric and only contain spaces']);

		// If their are errors then redirect with custom error mesages
		if ($validation->fails()) {
            return redirect('/create')
              ->withErrors($validation);
       	 }

       	// Get url
       	$url = str_replace(' ','_',$request->input('title'));
       	
       	// Get a description by cutting the content to 128 characters
		$description = substr(strip_tags($request->input('contents')), 0, 128) . '...';

		// Get author_name
		$author = $this->db->getUserInfoFromSession('author_name');

       	// Use our analyse function to get banned words
       	$words = $this->analyse($request->input('contents'));

       	// if the array is not empty we make further checks
       	if(!empty($words)) {
       		// Check value of banned words
       		$score = $this->obtainWordValue($words);
       		// Apply rules defined in the NEA document
       		if ($score > 9) {
       			// If something doesnt go right return an error message
	            session()->flash('error', 'Your post was not suitable');
       			return view('editor', array('error' => session('error')));
       		}

       		// Since we have a minor score, 
       		// store the contents in the storage/app/profane folder
       		// in a folder
       		$this->storewords($words, $url);
       	}
		
		// Get the inputs and place them in an array
		// using the request variable we have access to the
		// users inputs on the create page
		// For explanation for whats what go to BenLowery\database and look at publishPendingToDb
		array_push($info, $request->input('title'), $description,  $request->input('contents'), str_replace(' ', '', $request->input('tags')), $author, $url);
			


		if($this->db->publishPendingToDb($info)) {
			return redirect('/');
		} else {
			return die("Something went wrong :(");
		}

	}

	protected function analyse($text) {
		/*
		*    Will return one of two results:
		*    deny, refer
		*/
		$this->text = $text;
		$this->formatText();
		return $this->compareBannedWords();
	}

	// Format the input
	protected function formatText() {
		// Remove html tags.
		$this->text = strtolower(strip_tags($this->text));

		// Replace remaining special characters
		$this->text = preg_replace('/[^A-z0-9\ ]/', '', $this->text);

		// Regex for parametres of words, punctuations and whitespace, using general unicode characters
		 $delimetres = "/
		 		  ([\pZ\pC]*)
		 		  ([^\pP\pZ\pC]+)
		 		  ([\pZ\pC]*)
		 		 /xu";

		 // Match all the occurences using php preg_match_all over a for loop
		 preg_match_all($delimetres, $this->text, $this->textArr);
		
		// We need the last item in array, after all the matches so set that as our
		// global textArr variable
		$this->textArr = $this->textArr[2];

	}

	protected function compareBannedWords() {
		// Get json file
		$json = $this->getProfanityFilterKeyValuePairs();

		// Compare arrays with array_intersect
		// return list of banned words
		return array_intersect($this->textArr, array_keys($json));
	}

	protected function obtainWordValue($profanities) {
		// count variable
		$count = 0;

		// Get json file
		$keyValuePairs = $this->getProfanityFilterKeyValuePairs();

		// Since the profanities are the keys to the array.
		// To do the value we need to just do this
		foreach ($profanities as $profanity) {
			$count += $keyValuePairs[$profanity];
		}
		// Return count number
		return $count;
	}

	protected function storeWords($profanities, $fileName) {
		// init array
		$wordsForFile = [];

		// get json file
		$arrayOriginal = $this->getProfanityFilterKeyValuePairs();

		// Just get the values we need
		foreach ($profanities as $profanity) {
			$wordsForFile[$profanity] = $arrayOriginal[$profanity];
		}
		// Push to file
		Storage::put('profane/' . $fileName . '.json', json_encode($wordsForFile));
	}

	// Find file for the profanity folder
	protected function getProfanityFilterKeyValuePairs() {
		// Get json file form the laravel storage folder
		// from https://github.com/wooorm/cuss/blob/master/index.json
		// Some numbers have been changed based on my personal discrepency
		// -> Due to some being a tad too harsh/leant
		$file = storage_path('ProfaneFilter.json');
		// Decode json
		return json_decode(file_get_contents($file), True);
	}
}
