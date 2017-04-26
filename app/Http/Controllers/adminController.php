<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

// Our custom database helper
use App\BenLowery\Database;

use Storage;

class adminController extends Controller {
    // Content file
    public $contentfile;
    // temp contents
    public $tempcontents;

    // Instantiation method
  	public function __construct() {
       // Define database class
  		$this->db = new \App\BenLowery\Database;
  	}

    public function dashboard() {
      // If admin, go to admin dashboard, otherwise, go to student
      if($this->db->isAdmin()) {
    	  return view('admin.UserAdmin');
      } else {
        // student ashboard
        return view('student.UserStudent');
      }
    }

    public function displayPostReview() {
      $badwords = [];
      
      // Gather all posts that need to be approved
      $posts = $this->db->getPostInfo('accepted', 'no');
      // get corrosponding profanity file
      if($posts->count() > 0) {
        // Convert posts to array to handle easier. 

        // Foreach post check and get profanity file
        foreach ($posts as $post) {
          // Get corrspondind posts file
          $this->contentfile = file_get_contents('../resources/views/posts_files/' . $post["url"] . '.blade.php');

          // check if bad word file exists
          if(Storage::exists('profane/' . $post["url"] . '.json')) {
            $profanityfile = Storage::get('profane/' . $post["url"] . '.json');
            
            // Decode json file with that posts bar words
            $badwords = json_decode($profanityfile, True);
            // We only need the keys of the array
            $badwords = array_keys($badwords);
              
            // Make all badwords marked
            $Markedbadwords = $badwords;
            array_walk($Markedbadwords, 
                function(&$value, $key) { 
                    $value = "<mark>" . $value . "</mark>";
                }
            );
          
            // highlight all bad words
            $this->tempcontents = str_replace($badwords, $Markedbadwords, $this->contentfile); 

            // Push to array
            $post["contents"] = $this->tempcontents;

          } else {
            // Just push original file to array
            $post["contents"] = $this->contentfile;
          }
        }
      }
      return view('admin.PostReview', array('posts' => $posts));
    }

    public function displaySettings() {
      return view('admin.settings');
    }

    public function manageUsers() {
      $postsCount = [];
      $tempCount = 0;

      $users = $this->db->getUserInfo();

      // Get number of posts for each user
      foreach ($users as $user) {
        // count number of published posts for each user
        $tempCount = $this->db->getPostInfoAndAccepted('author', $user->author_name)->count();
        array_push($postsCount, $tempCount);
      }
      
      // pass to view
      return view('admin.ManageUsers', array('user_info' => $users, 'published_posts' => $postsCount));
    }
   	/*Accept post*/
   	public function accept($id) {
   		if($this->db->acceptPost($id)) {
   			return redirect('/dashboard');
   		}
   		return redirect(404);
   	}

   	/*Deny Post*/
   	public function deny($id) {
   		// Use db helper to delete post permanetly from the database.
   		// If it doesnt work return an error response
   		if(!$this->db->removePostFromDb($id)) {
   			echo "The post couldn't delete :(";
   			die();
   		}

   		//redirect back to the admin screen
   		return redirect('/dashboard');
   	}
}
