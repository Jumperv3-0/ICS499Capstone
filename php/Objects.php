<?php
require_once 'functions.php';
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

abstract class PageBuilder {
	//$session_validator; // TODO: used to check if session if valid or needs to start

	public function getHeader() {
		$this->active = '';
		$this->title = '';
		$this->header = '';
		$this->logged_in = false; // TODO: change to dynamic
		$array = explode('/', sanitizeInput($_SERVER['PHP_SELF']));
		$page_name = array_pop($array);
		switch($page_name) {
			case "index.php":
				$this->active = 'index';
				$this->header = $this->makeHeader($this->active, $this->title, $this->logged_in);
				echo $this->header;
				break;
			case "Your sales.php":
				$this->active = 'Your sales';
				$this->header = $this->makeHeader($this->active, $this->title, $this->logged_in);
				echo $this->header;
				break;
			case "items.php":
				$this->active = 'items';
				$this->header = $this->makeHeader($this->active, $this->title, $this->logged_in);
				echo $this->header;
				break;
			case "createAccount.php":
				$this->active = 'index';
				$this->header = $this->makeHeader($this->active, $this->title, $this->logged_in);
				echo $this->header;
				break;
			case "other sales.php":
				$this->active = 'index';
				$this->header = $this->makeHeader($this->active, $this->title, $this->logged_in);
				echo $this->header;
				break;
			default:
				$active = '';
				$title = '';
				$header = 'add Page';
				echo $this->header;
		}
	}

	public function getFooter() {

	}

	static function getTitle() {
		$array = explode('/', sanitizeInput($_SERVER['PHP_SELF']));
		$page_name = array_pop($array);
		$array = array_reverse(explode('.',$page_name));
		$title = ucfirst(array_pop($array));
		echo $title . " | GSale";
	}

	protected function makeHeader($active, $title, $logged_in) {
		$header = '';
		if ($logged_in) {
			$header = '
						<nav class="navbar navbar-expand navbar-inverse navbar-fixed-top">
							<div class="container-flex">
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#MyNavbar">
										<span class="sr-only">Toggle navigation</span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>
								<a class="navbar-brand" href="#"><img src="../img/garage_logo_final.png" /></a>
								</div>
								<div class="collapse navbar-collapse" id="MyNavbar">
									<ul class="nav navbar-nav navbar float-left">
									' . $this->getActive($active) . '
									</ul>
									<ul class="nav navbar-nav navbar-right">
										<li>
											<a href="#">
												<form class="navbar-form navbar-right" role="search">
													<div class="input-group">
														<input id="search" type="text" class="form-control" placeholder="Search" name="search">
														<div class="input-group-btn">
															<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
														</div>
													</div>
												</form>
											</a>
										</li>
										<li><a href="#"><span class="glyphicon glyphicon-log-in"></span>Login</a></li>
										<li><a href="createAccount.php">Create Account</a></li>
									</ul>
								</div>
							</div>
						</nav>';
		} else {
			$header = '
						<nav class="navbar navbar-expand navbar-inverse navbar-fixed-top">
							<div class="container-flex">
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#MyNavbar">
										<span class="sr-only">Toggle navigation</span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>
								<a class="navbar-brand" href="#"><img src="../img/garage_logo_final.png" /></a>
								</div>
								<div class="collapse navbar-collapse" id="MyNavbar">
									<ul class="nav navbar-nav navbar float-left">
									' . $this->getActive($active) . '
									</ul>
									<ul class="nav navbar-nav navbar-right">
										<li>
											<a href="#">
												<form class="navbar-form navbar-right" role="search">
													<div class="input-group">
														<input id="search" type="text" class="form-control" placeholder="Search" name="search">
														<div class="input-group-btn">
															<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
														</div>
													</div>
												</form>
											</a>
										</li>
										<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Account <span class="caret"></span></a>
										<ul class="dropdown-menu">
											<li><a href="#">My Sales</a></li>
											<li role="separator" class="divider"></li>
											<li><a href="#">My Items</a></li>
											<li role="separator" class="divider"></li>
											<li><a href="#">Prefered Items</a></li>
											<li role="separator" class="divider"></li>
											<li><a href="#">One more separated link</a></li>
										</ul>
									</li>
									<li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
									</ul>
								</div>
							</div>
						</nav>';
		}
		return $header;
	}

	protected function getActive($active) {
		$html = '';
		$active_index = '';
		switch($active) { // TODO: add other cases
			case "index":
				$active_index = 0;
				break;
			case "otherSales":
				$active_index = 1;
				break;
			case "items":
				$active_index = 2;
				break;
			default:
				$active_index = 0;
		}
		$pages = array('index.php', 'otherSales.php', 'items.php');
		echo "count is: " . count($pages);

		for ($i = 0; $i < (count($pages) * 2); $i++ ) {
			if ($i % 2 == 0 && $i == ($active_index * 2)) {
				echo "active";
				$html .= '<li class="active"><a href="' . $pages[$active_index] . '">' . $active . '</a></li>';
			} else if ($i % 2 == 0){
				echo "noormal";
				$html .= '<li class=""><a href="' . $pages[$active_index] . '">$active</a></li>';
			} else {
				echo "divider";
				$html .= '<li role="separator" class="divider"></li>';
			}
			return $html;
		}
	}

}

class IndexPage extends PageBuilder {

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
