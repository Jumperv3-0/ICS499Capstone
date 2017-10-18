<?php
require_once 'functions.php';
require_once 'db_connection.php';

/**
 * User class that contains user data and controles user loggin and logout
 */
class User {
    private $db_conn,
            $data,
            $sessionName,
            $cookieName,
            $isLoggedIn;

    /**
     * Constructor that checks to see if user is logged in, if
     * user is logged in it returns that user therewise constructor
     * searches for user from db. eg $user = new User() // gets current
     * user thats logged in if there is one, or $user = new User(4)
     * // gets user a user_id = 4 from db, or $user = new User('id4766wa')
     * // gets user with a username = id4766wa from db.
     * @param string [$user = null] leave blank to get current user,
     * otherwise give it a param of a user_id or a username.
     * @author Gary
     */
    public function __construct($user = null) {
        $this->db_conn = SqlManager::getInstance();
        $this->sessionName = $GLOBALS['config']['session']['session_name'];
        $this->cookieName = $GLOBALS['config']['remember']['cookie_name'];
        if (!$user) {
            if (Session::exists($this->sessionName)) {
                $user = Session::get($this->sessionName);
                if ($this->find($user)) {
                    $this->isLoggedIn = true;
                } else {
                    // process logout
                }
            }
        } else {
            $this->find($user);
        }
    }

    /**
     * Creates a new user in the database from an array of parameters
     * @param array paramerter values
     */
    public function create($params = array()) {
        $sql = "INSERT INTO users (user_id, username, password, fname, lname, email) VALUES (NULL, ?, ?, ?, ?, ?);";
        if (!$this->db_conn->query($sql, $params)) {
            throw new Exception("Error creating account!");
        }
    }

    /**
     * Verifies user loggin informantion is correct then creates session
     * @author Gary
     * @param  string [$username = null] username submitted by user
     * @param  string [$password = null] password submitted by user
     * @return boolean  true if loggin was successful, else false
     */
    public function login($username = null, $password = null, $remember = false) {
        if (!$username && !$password && $this->exists()) {
          Session::put($this->sessionName, $this->data()->user_id);
        } else {
          $user = $this->find($username);
          if ($user) {
              if(password_verify($password, $this->data()->password)) {
                  Session::put($this->sessionName, $this->data()->user_id);
                  if ($remember) {
                      $hash = hash('sha256', uniqid() . random_bytes(10));
                      $hashCheck = $this->db_conn->query("SELECT * FROM login_attempts WHERE user_fk_id = ?", array($this->data()->user_id));
                      if (!$hashCheck->getCount()) {
                          $this->db_conn->query("INSERT INTO login_attempts (attempt_id, attempt_success, session_id, time_stamp, user_fk_id) VALUES (NULL, ?, ?, NULL, ?);", array('1', $hash, $this->data()->user_id));
                      } else {
                          $hash = $hashCheck->getResult()[0]->session_id;
                      }
                    Cookie::put($this->cookieName, $hash, $GLOBALS['config']['remember']['cookie_expire']);
                  }
                  return true;
              }
          }
        }
                return false;
    }

    /**
     * Checks to see if the user that calls this method has data
     * and that the user exists in our db
     * @author Gary
     * @return boolean true if the user exists, else false
     */
    function exists() {
      return (!empty($this->data)) ? true : false;
    }

    /**
     * Searches db for user
     * @author Gary
     * @param  string [$user = null] enter a user_id or username to search
     * @return boolean  true if a user match was found else false
     */
    public function find($user = null) {
        if ($user != null) {
            $field = (is_numeric($user)) ? 'user_id' : 'username';
            $sql = "SELECT * FROM users WHERE " . $field . " = ?";
            $params = array($user);
            $result = $this->db_conn->query($sql, $params);
            if ($result->getCount() > 0) {
                $this->data = $result->getResult()[0];
                return true;
            }
        }
        return false;
    }

    /**
     * Gets user data information
     * @author Gary
     * @return array of data about user from db
     */
    public function data() {
        return $this->data;
    }

    /**
     * Checks to see if user is logged in
     * @author Gary
     * @return boolean true if user is logged in, else false
     */
    public function isLoggedIn() {
        return $this->isLoggedIn;
    }

    /**
     * Causes the user to logout
     * @author Gary
     */
    public function logout() { // TODO: logout is not deleting cookie.
      $this->db_conn->query('DELETE FROM login_attempts WHERE user_fk_id = ?', array($this->data()->user_id));
    	Session::delete($this->sessionName);
			Cookie::delete($this->cookieName);
    }
}

/**
 * Class represents an item for sale
 */
class Item { // TODO: need to implement
	private $db_conn;

    public function __construct($item = null) {
        $this->db_conn = SqlManager::getInstance();
    }

    public function create($params = array()) {
        $sql = "";
        if (!$this->db_conn->query($sql, $params)) {
            throw new Exception("Error creating item!");
        }
    }
}

/**
 * Class represents a place
 */
class Place { // TODO: need to implement
  private $db_conn, $data;

  public function __construct($place = null) {
    $this->db_conn = SqlManager::getInstance();
    if ($place) {
      $this->find($place);
    }  else { // TODO: Do I need to implement?

    }
  }

  public function create($params = array()) {
     $sql = "INSERT INTO places (place_id, address, city, state, zip_code, country) VALUES (NULL, ?, ?, ?, ?, ?);";
      if (!$this->db_conn->query($sql, $params)) {
          throw new Exception("Error creating place!");
      }
  }

  public function find($place = null) {
    if ($place) {
      $sql = "SELECT * FROM places WHERE place_id = ?";
      $result = $this->db_conn->query($sql, array($place));
      if ($result->getCount()) {
        $this->data = $result->getResult()[0];
        return true;
      }
    }
    return false;
  }

  public function getData() {
    return $this->data;
  }

}

/**
 * Class represents a garageSale
 */
class GarageSale { // TODO: need to implement
	private $db_conn,
					$data;

	public function __construct($sale = null) {
    $this->db_conn = SqlManager::getInstance();
    if (!$sale) {
      // TODO: to be implemented?
    } else {
      $this->findSale($sale);
    }
	}

	public function findSale($gsale = null) {
		if ($gsale != null) {
      $sql = "SELECT * FROM garage_sales WHERE gsale_id = ?";
      $params = array($gsale);
      $result = $this->db_conn->query($sql, $params);
      if ($result->getCount() > 0) {
          $this->data = $result->getResult()[0];
          return true;
      }
    }
    return false;
	}
	
	public function create($params = array()) {
    $sql = "INSERT INTO garage_sales (gsale_id, sale_name, image_url, description, start_date, end_date, places_fk_id, user_fk_id) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?);";
    if (!$this->db_conn->query($sql, $params)) {
      throw new Exception("Error creating account!");
    }
  }
	
	public function editSale($params = array()) {
		// TODO: need to implement
	}
	
	    /**
     * Gets user data information
     * @author Gary
     * @return array of data about user from db
     */
    public function getData() {
        return $this->data;
    }
}

/**
 * Class to redirect you to a different page.
 */
class Redirect {
    /**
     * Redirects to page given as parameter
     * eg. Redirect::page('index.php');
     * @author Gary
     * @param string [$location = null] page to go to
     */
    public static function page($location = null) {
        if ($location != null) {
            if(is_numeric($location)) {
                switch($location) {
                    case 404:
                        header('HTTP/1.0 404 Not Found');
                        include '404.php';
                        exit();
                    break;
                }
            }
            header('Location: ' . $location);
            exit();
        }

    }
}

/**
 * Abstract class PageBuilder that has methods to the navbar, footer, and tables.
 */
abstract class PageBuilder {
	/**
	 * Gets the navbar for the page
	 * eg. PageBuilder::getHeader();
	 * @author Gary
	 */
	public function getHeader() {
		$this->active = '';
		$this->title = '';
		$this->header = '';
    $user = new User();
		$this->logged_in = $user->isLoggedIn();
		$array = explode('/', sanitizeInput($_SERVER['PHP_SELF']));
		$page_name = array_pop($array);
		switch($page_name) {
			case "index.php":
				$this->active = 'index';
				$this->header = $this->makeHeader($this->active, $this->title, $this->logged_in);
				echo $this->header;
				break;
			case "yourSales.php":
				$this->active = 'yourSales';
				$this->header = $this->makeHeader($this->active, $this->title, $this->logged_in);
				echo $this->header;
				break;
			case "items.php":
				$this->active = 'items';
				$this->header = $this->makeHeader($this->active, $this->title, $this->logged_in);
				echo $this->header;
				break;
			case "createAccount.php":
				$this->active = 'createAccount';
				$this->header = $this->makeHeader($this->active, $this->title, $this->logged_in);
				echo $this->header;
				break;
			case "otherSales.php":
				$this->active = 'otherSales';
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

	/**
	 * Gets the footer for the page
	 * eg. PageBuilder::getFooter();
	 * @author Gary
	 */
	static function getFooter() {
	echo <<<CONTENT
		<div class="container text-center">
			<h4>Contact Us</h4>
			<div>
				<div class="contact-info">Phone Number: 612 978 5555<span class="glyphicon glyphicon-earphone"></span></div>
				<div class="contact-info">Email Address: GSalesStaff@Gsales.net<span class="glyphicon glyphicon-envelope"></span></div>
			</div>
		</div>
CONTENT;
    }

	/**
	 * Gets the tile for the page
	 * eg. PageBuilder::getTitle();
	 * @author Gary
	 */
	static function getTitle() {
		$array = explode('/', sanitizeInput($_SERVER['PHP_SELF']));
		$page_name = array_pop($array);
		$array = array_reverse(explode('.',$page_name));
		$title = ucfirst(array_pop($array));
		echo $title . " | GSale";
	}

	/**
	 * Makes the header for the page
	 * @author Gary
	 * @param  string $active    sets the active class in header so user can tell what page they are on
	 * @param  string $title     of page
	 * @param  boolean $logged_in true if the user is logged in else false
	 * @return string html text for header
	 */
	protected function makeHeader($active, $title, $logged_in) {
		$header = '';
		if (!$logged_in) {
			$header = '
						<nav class="navbar navbar-expand navbar-inverse">
							<div class="container">
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#MyNavbar">
										<span class="sr-only">Toggle navigation</span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>
								<a class="navbar-brand" href="index.php"><img src="../img/garage_logo_final.png" /></a>
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
										<li><a href="createAccount.php">Create Account</a></li>
										<li><a href="#"><span class="glyphicon glyphicon-log-in"></span>Login</a></li>
									</ul>
								</div>
							</div>
						</nav>';
		} else {
			$header = '
						<nav class="navbar navbar-expand navbar-inverse">
							<div class="container">
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
											<li><a href="yourSales.php">My Sales</a></li>
											<li role="separator" class="divider"></li>
											<li><a href="#">My Items</a></li>
											<li role="separator" class="divider"></li>
											<li><a href="#">Prefered Items</a></li>
											<li role="separator" class="divider"></li>
											<li><a href="#">One more separated link</a></li>
										</ul>
									</li>
									<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
									</ul>
								</div>
							</div>
						</nav>';
		}
		return $header;
	}

	/**
	 *
	 * @param  string $active page
	 * @return string html of with class of active page
	 */
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
        $selections = array('Home', 'Sales', 'Items');

		for ($i = 0; $i < (count($pages) * 2); $i++ ) {
			if ($i % 2 == 0 && $i == ($active_index * 2)) {
				$html .= '<li class="active"><a href="' . $pages[$active_index] . '">' . $selections[$active_index] . '</a></li>';
			} else if ($i % 2 == 0){
				$html .= '<li class=""><a href="' . $pages[($i * .5)] . '">' . $selections[($i * .5)] . '</a></li>';
			} else {
				$html .= '<li role="separator" class="divider"></li>';
			}
		}
        return $html;
	}

    /**
     * TODO: To be implemented by subclasses
     */
    abstract public function getContent();

}

 /**
  * TODO: To be implemented by subclasses
  */
class IndexPage extends PageBuilder {
  private $user, $db_conn;

  function __construct() {
    $this->user = new User();
    $this->db_conn = SqlManager::getInstance();
  }

  public function getContent(){}

  private function getTableData() {
		$sql = "SELECT count(gsale_id) as count FROM garage_sales";
		$result = $this->db_conn->query($sql, array());
    $sql = "SELECT min(gsale_id) as min FROM garage_sales";
    $max = $result->getResult()[0]->count;
    $result = $this->db_conn->query($sql, array());
    $min = $result->getResult()[0]->min;
    ($min > $max) ? $max = $min : false;
    $indexArray = array(rand($min,$max), rand($min,$max), rand($min,$max), rand($min,$max));
    $sql = "SELECT * FROM garage_sales WHERE gsale_id = ?";
    $return_array = array();
    foreach ($indexArray as $index) {
      $garage_sale = new GarageSale($index);
      array_push($return_array, $garage_sale);
    }
    return $return_array;
  }

  private function getWelcome($size) {
     echo "<div class='container'>
				<div class='col-sm-{$size} text-left'>
					<h1>Welcome</h1>
					<p>Paragraph about us!</p>
					<p>We At G=Sale have a simple goal. That goal is to help connect those wishing to sell their unneeded possessions to those who are looking for deals cutting out the middleman. A trade between neighbors. You might be hard on for cash. Or your looking to unburden yourself with unnecessary things you have gathered over the years. Regardless of your sepenstance you can create an account and set up your garage sale for free! Or maybe you are looking for a old, no longer sold in stores item. or you just want to save some cash picking up a hand me down dresser. You don\'t need an account just simply check out our Sales page to find garage that are live near you. Or you can search by specific keyword if you already know what you\'re looking for.</p>
					<hr>
				</div>";
  }

  private function getLogin() {

  }

  public function getTable() {
		$sales = $this->getTableData();
    $html = "<div class='panel-group'>";
    $count = 1;
    foreach ($sales as $sale) {
      $gsale_id = $sale->getData()->gsale_id;
      $sale_name = $sale->getData()->sale_name;
      $image_url = $sale->getData()->image_url;
      $description = $sale->getData()->description;
      $start_date = $sale->getData()->start_date;
      $end_date = $sale->getData()->end_date;
      $places_fk_id = $sale->getData()->places_fk_id;

      $place = new Place($places_fk_id);
      $place_location = $place->getData()->address . " " . $place->getData()->city . ", " . $place->getData()->state . " " . $place->getData()->zip_code;
      $html .= "<div class='panel panel-default'>
                  <div class='panel-heading' data-toggle='collapse' data-target='#collapse{$count}' aria-expanded='true'>
                    <h4 class='panel-title'><h5 class='collapse-header'>Location:</h5><p class='collapse-header-text'>{$place_location}</p><span class='glyphicon glyphicon-chevron-down pull-right' aria-hidden='true'></span></h4>
                  </div>
						      <div id='collapse{$count}' class='panel-collapse collapse in' aria-expanded='true' style=''>
                    <div class='panel-body'>
                      <div class='row text-center'>
                        <a class='' href='#{$gsale_id}'>Name: {$sale_name}</a>
                      </div>
								      <div class='row'>
									     <div class='col-sm-4'>
                       <img src='../img/{$image_url}'>
									   </div>
									   <div class='col-sm-4'>
                      <h5 class='collapse-header'>Date:</h5>
                      <p>{$start_date} - {$end_date}</p>
									   </div>
									   <div class='col-sm-4'>
                      <h5 class='collapse-header'>Description:</h5>
                      <p>{$description}</p>
									   </div>
                    </div>
                  </div>
                </div>
              </div>";
      $count++;
    }
    $html .= "</div>";
    return $html;
  }
}
 /**
  * TODO: To be implemented by subclasses
  */
class RegisterPage extends PageBuilder {

		public function getContent() {

		}

    protected function getTable() {

    }

    protected function getTableData() {

    }

}
 /**
  * TODO: To be implemented by subclasses
  */
class SalesPage extends PageBuilder {
		public function getContent() {

		}

    protected function getTable() {

    }

    protected function getTableData() {

    }
}
 /**
  * TODO: To be implemented by subclasses
  */
class ItemsPage extends PageBuilder {
		public function getContent() {

		}

    protected function getTable() {

    }

    protected function getTableData() {

    }
}

/**
 * Class is used to vaidate user input and return any errors
 * in the input if any exist.
 */
class Validation {
    private $passed,
            $errors,
            $db_conn;

    /**
     * Constructor that gets connection to db and intizes class variables
     */
    public function __construct() {
        $this->passed = false;
        $this->db_conn = SqlManager::getInstance();
        $this->errors = array();
    }

   /**
    * Checks to make sure ever rule on input passed
    * eg.
    * @return Validation returns itself so you can check for errors
    */
    public function check($submit_method,  $tests = array()) {
        foreach($tests as $test => $rules) {
            foreach($rules as $rule => $rule_value) {
                $value = sanitizeInput($submit_method[$test]);
                if ($rule === 'required' && empty($value)) {
                    $this->addError("{$test} is required");
                } else if(!empty($value)) {
                    switch($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError("{$test} must be a minimum of {$rule_value} characters.");
                            }
                            break;
                         case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError("{$test} must be a maximum of {$rule_value} characters.");
                            }
                            break;
                         case 'matches':
                            if ($value != sanitizeInput($submit_method[$rule_value])) {
                                $this->addError("{$rule_value} must match {$test}");
                            }
                            break;
                         case 'unique':
                            $check = $this->db_conn->query("SELECT * FROM {$rule_value} WHERE {$test} = '{$value}'", array());
                            if ($check->getCount() > 0) {
                                $this->addError("{$test} alread exists.");
                            }
                            break;
                         case 'email':
                            $email_address = sanitizeInput($submit_method[$rule]);
                            if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
                                $this->addError("{$test} was not a valid email.");
                            }
                            break;
                         case 'phone':
                            $phone_number = sanitizeInput($submit_method[$rule]);
                            $phone_number = preg_replace('/\s+/', '', $phone_number);
                            if (!is_numeric($phone_number)) { //TODO: need to implement
                                $this->addError("Phone number was not valid.");
                            }
                            break;
                        case 'address': // TODO: need to implement

                            break;
                    }
                }
            }
        }

        if (empty($this->errors)) {
            $this->passed = true;
        }
        return $this;
    }

    /**
     * Adds an error to the list of errors
     * @param string $error to be added to error array
     */
    private function addError($error) {
        $this->errors[] = $error;
    }

    /**
     * Gets the list of errors
     * @return array of errors
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Returns true if all test on input were passed else
     * it returns false.
     * @return boolean true if passed, else false
     */
    public function passed() {
        return $this->passed;
    }
}

/**
 * Class represents a random token string to prevent cross site attacks
 */
class Token {
    /**
     * Generates a random token string
     * @author Gary
     * @return string token string generated
     */
    public static function generate() {
        return Session::put($GLOBALS['config']['session']['token_name'], md5(uniqid()));
    }

    /**
     * Checks to see if two tokens match
     * @author Gary
     * @param  string $token to be checked
     * @return boolean  true if tokens match, else false
     */
    public static function check($token) {
        $tokenName = $GLOBALS['config']['session']['token_name'];

        if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
            Session::delete($tokenName);
            return true;
        }
        return false;
    }
}

/**
 * Class that handles seeion mangagement
 */
class Session {
    /**
     * Deletes a session variable
     * @author Gary
     * @param string $name of session var to delete
     */
    public static function delete($name) {
        if(self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    /**
     * Checks to see if a session exists
     * @author Gary
     * @param  string $name of session var to check
     * @return boolean true if the session exists, else false
     */
    public static function exists($name) {
        return (isset($_SESSION[$name])) ? true : false;
    }

    /**
     * Puts a value in session variable
     * @author Gary
     * @param  string $name  of session variable
     * @param  string $value to put in session variable
     * @return string value inserted
     */
    public static function put($name, $value) {
        return $_SESSION[$name] = $value;
    }

    /**
     * Gets a session variable
     * @author Gary
     * @param  string $name of sesion variable to get
     * @return string value of session variable
     */
    public static function get($name) {
        return $_SESSION[$name];
    }

    /**
     * Sets a one time message
     * @author Gary
     * @param  string $name           of session variable
     * @param  string [$message = ''] message to be saved
     * @return string value of session variable
     */
    public static function flash($name, $message = '') {
        if (self::exists($name)) {
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::put($name, $message);
        }
    }
}

class cookie {

    public static function exists($name) {
        return (isset($_COOKIE[$name])) ? true : false;
    }

    public static function get($name) {
        return $_COOKIE[$name];
    }

    public static function put($name, $value, $expiry) {
        if (setcookie($name, $value, time() + $expiry, '/')) {
            return true;
        }
        return false;
    }

    public static function delete($name) {
        self::put($name, '' , time()-1);
    }
}

?>
