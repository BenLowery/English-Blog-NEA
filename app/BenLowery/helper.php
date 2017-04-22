<?php 


/*
* Helper functions for litle niche things
*/

namespace App\BenLowery;

use Mail;
use App\Mail\sendToken;

class Helper {

	// Convert a url friendly string into a normal string
	public function deslug($name) {
		// Lower case
		$name = strtolower($name);
		// Replace underscores with spaces.
		$name = str_replace("_", " ", $name);
		return $name;
	}

	public function parseStudentSchoolEmail($email) {
		// Empty array containing information
		$info = [];

		// Find string position of @ symbol and keep everything before that.
		$pos = strpos($email, '@');
		$string = substr($email, 0, $pos);

		// Now parse the surname (two characters before the end)
		// The first name (second to last character)
		// Number (last character)
		array_push($info, substr($string, 0, strlen($string) - 2), substr($string, -2, 1), substr($string, -1));
		
		// Incase we've been given a dodgy string, we fail the string
		if (!is_numeric($info[2])) {
			return "f";
		}

		// Find corresponding year given number
		$info[2] = $this->getSchoolYear($info[2]);

		return $info;
	}

	/*
	* Send an email
	* for testing purposes we are using mailtrap.io
	*/
	public function sendEmail($email, $token) {
		 Mail::to($email)->send(new sendToken($token));

	}
	public function getToken() {
		return $this->token;
	}

	protected function getSchoolYear(int $num) {
		return 7 + (substr(date('Y'), -1) - ($num + 1));
	}
}