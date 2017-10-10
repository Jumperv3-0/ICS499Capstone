<?php
class User {
  public function User($username, $email, $password, $city, $street, $zip, $phonenumber, $fname, $lname) {
		$this->username = $username;
		$this->email = $email;
		$this->password = $password;
		$this->city = $city;
		$this->street = $street;
		$this->zip = $zip;
		$this->phonenumber = $phonenumber;
		$this->fname = $fname;
		$this->lname = $lname;
    }
}

class Item {
	public function Item ($image, $description, $price, $issold, $keyword) {
		$this->image = $image;
		$this->description = $description;
		$this->price = $price;
		$this->issold = $issold;
		$this->keyword = $keyword;
	}
}

//pull "location" from google maps. Otherwise replace with: City, Street, Zip.
class GarageSale {
	public function GarageSale ($image, $description, $date, $location, $items, $user) {
		$this->image = $image;
		$this->description = $description;
		$this->date = $date;
		$this->location = $location;
		$this->items = $items;
		$this->user = $user;
	}
}

/**
	class SessionManager() {
		private $cookie;
		private $session_name;
		$secure = SECURE;
    // This stops JavaScript being able to access the session id.
		$httponly = true;

		public __construct() {
			$this->session_name = 'sec_session_id'; // need to change to random/custom session id
			if (ini_set('session.use_only_cookies', 1) === false) {
				header("Location: index.php?err=true");
				exit();
			}
			$cookieParams = session_get_cookie_params();
			session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
			session_name($session_name);
			session_start();
			session_regenerate_id();
		}

		public RemoveSession() {

		}

		public validateSession() {

		}
	}
	**/

?>
