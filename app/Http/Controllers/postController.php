<?php

namespace App\Http\Controllers;

// Laravel classes
use Illuminate\Http\Request;
use App\Http\Requests;

// Custom Classes (our code)
use App\BenLowery\Database;
use App\BenLowery\Helper;

class postController extends Controller
{

	public function __construct() {
		// Define our custom classes to be callable within functions.
		$this->db = new \App\BenLowery\Database;
      $this->helper = new \App\BenLowery\Helper;
	}
   public function display($slug) {
   		// Use database class to verify url exists
         // And also include to make sure it accepted
   		// If it doesnt match params return a 404 view.
   		if(!$this->db->doesPostExist($slug)) {
   			abort(404);
   		} 

   		// Get all the required information...
   		$infoArray = $this->db->getPostInfo('url', $slug);

         // ...Well except her where we get most popular emoji
         $popEmoji = $this->mostPopularEmoji($slug);

         // Convert tag contents in the db into an array
         $infoArray[0]['tags'] = explode(',', $infoArray[0]['tags']);
         
   		// Return view and pass variables
   		return view('post.post', Array(
   			// Use [0] as we only have one result and we only want information form that
   			// One person
   			'info' => $infoArray[0],
            'emoji' => $popEmoji,
   		)
   		);
   }


   // Add comment to comment table 
   public function addComment(Request $request) {
      // add to database
      $this->db->UpdateCommentTable($request->input('emoji'), $request->input('url'));

      // Return the post view
      return redirect('post/' . $request->input('url'));
   }
   
   // Author posts view
   public function author($name) {
      // Deslug url
      $name = $this->helper->deslug($name);
      
      // We are checking that the post is accepted as well as having thr same author name
      $authorPosts = $this->db->getPostInfoAndAccepted('author', $name);
      if(count($authorPosts) === 0) {
            abort(404);
      }

      // return view
      return view('post.author', Array('posts' => $authorPosts));
   }

   /* The definition of innefficiancy!
      Laravle blade wasnt very good when dealing with this,
      So i've used php to generate an array of relevant tags,
      then pass it through to the view.
   */
   public function tags($id) {
      
      // Create and array of tags
      $tagsarr = Array();
      
      // We want the tags from every post
      $posts = $this->db->getPostInfo('accepted', 'yes');
      foreach ($posts as $post) {
         // Convert to array
         $tags = explode(',', $post["tags"]);
         foreach ($tags as $tag) {
           if ($tag === $id) {
               // push tags to array
               array_push($tagsarr, $post["url"], $post["title"]);
           }
         }
      }

      // Finally, generate view passing array of posts, the tag, and count variables
      return view('post.tags', array('post' => $tagsarr, 'tag' => $id, 'count' => count($tagsarr)));
   }

   // Return the most popular emoji
   protected function mostPopularEmoji($url) {
         return $this->db->getMostPopularEmoji($url);
   }

}
