<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

// Our custom database helper
use App\BenLowery\Database;

use Storage;

class adminController extends Controller
{
  	public function __construct() {
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
        $profanityfile = Storage::get('profane/' . $posts[0]->url . '.json');
        $badwords = json_decode($profanityfile, True);
        // We only need the keys of the array
        $badwords = array_keys($badwords);
      }

      return view('admin.PostReview', array('posts' => $posts, 'badwords' => $badwords));
    }

    public function displaySettings() {
      return view('admin.settings');
    }

    public function manageUsers() {
      $users = $this->db->getUserInfo();
      return view('admin.ManageUsers', array('user_info' => $users));
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
