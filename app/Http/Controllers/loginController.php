<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\BenLowery\helper;
use App\BenLowery\database;
use Validator;

class loginController extends Controller
{
    
	public function __construct() {
		$this->helper = new \App\BenLowery\helper;
		$this->db = new \App\BenLowery\database;

	}

    public function loginPage() {
    	// Return login view
    	return view('login');

    }

    // Checks email then sends a verification token to the valid email
    public function SendVerify(Request $request) {
    	$info = [];

    	// Validate its actually an email, also sanitises request
        // Validator is a built in laravel function, seen as a wrapper,
        // to normal validation in php. But we are still doing,
        // Most of the work
    	$validation = Validator::make($request->all(), [
    		'email' => 'required|email|regex:/(([A-z]{2,})([0-9])?)@shtc(2)?\.org\.uk/|max:255'
    	], 
    	// Custom error messages
    	['regex' => 'You need to use your school email']);
    	
    	// If validation fails
    	if ($validation->fails()) {
    		return redirect('/login')
            ->withErrors($validation)
            ->withInput();
    	} 

        // Check if user is a verified teacher
        if($this->isTeacher($request->input('email'))) {
            // We can skip the parsing and create login token
            // Push to array
            array_push($info, $request->input('email'));
            // send token
            return $this->CheckTokenSent($info);
        }
       
    	/* School email student format follows the style of:-
		*  lastName -> FirstNameInitial -> Number(Last digit of year joined) @ -> school domain
    	*/
		$parsed_email = $this->helper->parseStudentSchoolEmail($request->input('email'));

    	if($parsed_email === 'f') {
    		// If something doesnt go right return an error message
            session()->flash('error', 'please use school email!');
            return view('login', array('flash' => session('error')));
    	}

    	// Make array of items
    	array_push($info, $request->input('email'), strtoupper($parsed_email[1]) . '. ' .$parsed_email[0], $parsed_email[2]);
    	
        // Check if first login and make sure no errors
        if(!$this->db->perhapsAddToUsers($info)) {
            abort(404);
        }

        
        // Send token and check
       return $this->CheckTokenSent($info);

    	
    }

    // Log in user who has a matching token
    public function VerifyLogin($token) {
        // Check token exists
    	if($this->db->doesTokenExist($token)) {
           // delete token and set session
            if($this->db->setSessionAndDeleteToken($token)) {
                return redirect('/');
            }
        }

        abort(404);
    }

    // Logout user
    public function logout() {
        // Forget user
        session()->forget('userid');
        return redirect('/login');
        

        // If something went wrong
        return view('errors.404');
    }  

    // Protected function to find teacher
    protected function isTeacher($email) {
        // Find said user
        $user = $this->db->getUserInfoFromIdentity('email', $email);

        // If user doesnt exist return false
        if(count($user) === 0) {
            return false;
        } 
        
        // Get user role and check it is admin
        if($user[0]["role"] === "user") {
            return false;
        }

        // All good return the
        return true;

    }

    protected function CheckTokenSent($info) {
         // Create a user login token
        if($this->db->createUserLoginToken($info)) {
            
            // show request has been acknowledged
            session()->flash('loginSent', 'Login email sent!');
            return view('login', array('flash' => session('loginSent')));
        }

        // If someone botches up
        return die("Email Couldn't send"); 
    }

}
