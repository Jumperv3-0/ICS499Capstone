<?php
require_once 'functions.php';
require_once 'db_connection.php';

/**
 * User class that contains user data and controles user loggin and logout
 */
class User
{
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
  public function __construct($user = null)
  {
    $this->db_conn = SqlManager::getInstance();
    $this->sessionName = $GLOBALS['config']['session']['session_name'];
    $this->cookieName = $GLOBALS['config']['remember']['cookie_name'];
    if (!$user) {
      if (Session::exists($this->sessionName)) {
        $user = Session::get($this->sessionName);
        if ($this->find($user)) {
          $this->isLoggedIn = true;
        } else {
          // could not find user
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
  public function create($params = array())
  {
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
  public function login($username = null, $password = null, $remember = false)
  {
    if (!$username && !$password && $this->exists()) {
      Session::put($this->sessionName, $this->data()->user_id);
    } else {
      $user = $this->find($username);
      if ($user) {
        if (password_verify($password, $this->data()->password)) {
          Session::put($this->sessionName, $this->data()->user_id);
          if ($remember) {
            $hash = hash('sha256', uniqid() . random_bytes(10));
            $hashCheck = $this->db_conn->query("SELECT * FROM password_saver WHERE user_fk_id = ?", array($this->data()->user_id));
            if (!$hashCheck->getCount()) {
              $this->db_conn->query("INSERT INTO password_saver (session_id, time_stamp, user_fk_id) VALUES (?, NULL, ?);", array($hash, $this->data()->user_id));
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
  function exists()
  {
    return (!empty($this->data)) ? true : false;
  }

  /**
     * Searches db for user
     * @author Gary
     * @param  string [$user = null] enter a user_id or username to search
     * @return boolean  true if a user match was found else false
     */
  public function find($user = null)
  {
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

  public function edit($params = array(), $user = null)
  {
    $sql = "UPDATE users SET username = ? , password = ?, fname = ?, lname = ?, email = ? WHERE user_id = ?";
    if ($user) {
      $found = $this->find($user);
      if ($found) {
        $user_id = $this->data()->user_id;
        array_push($params, $user_id);
        $result = $this->db_conn->query($sql, $params);
        if ($result->getError()) {
          return true;
        }
      }
    } else {
      if ($this->exists()) {
        $user_id = $this->data()->user_id;
        array_push($params, $user_id);
        $result = $this->db_conn->query($sql, $params);
        if ($result->getError()) {
          return true;
        }
      }
    }
    return false;
  }

  /**
     * Gets user data information
     * @author Gary
     * @return array of data about user from db
     */
  public function data()
  {
    return $this->data;
  }

  /**
     * Checks to see if user is logged in
     * @author Gary
     * @return boolean true if user is logged in, else false
     */
  public function isLoggedIn()
  {
    return $this->isLoggedIn;
  }

  /**
     * Causes the user to logout
     * @author Gary
     */
  public function logout()
  { // TODO: logout is not deleting cookie.
    $this->db_conn->query('DELETE FROM password_saver WHERE user_fk_id = ?', array($this->data()->user_id));
    Session::delete($this->sessionName);
    Cookie::delete($this->cookieName);
  }
}

/**
 * Class represents an item for sale
 */
class Item
{ // TODO: need to implement
  private $db_conn;

  public function __construct($item = null)
  {
    $this->db_conn = SqlManager::getInstance();
  }

  public function create($params = array())
  {
    $sql = "";
    if (!$this->db_conn->query($sql, $params)) {
      throw new Exception("Error creating item!");
    }
  }
}

/**
 * Class represents a garageSale
 */
class GarageSale
{ // TODO: need to implement
  private $db_conn,
  $data;

  public function __construct($sale = null)
  {
    $this->db_conn = SqlManager::getInstance();
    if (!$sale) {
      // TODO: to be implemented?
    } else {
      $this->find($sale);
    }
  }

  public function find($gsale = null)
  {
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

  public function create($params = array())
  {
    $sql = "INSERT INTO garage_sales (gsale_id, sale_name, image_url, description, dates) VALUES (NULL, ?, ?, ?, ?);";
    if (!$this->db_conn->query($sql, $params)) {
      throw new Exception("Error creating account!");
    }
  }

  public function editSale($params = array())
  {
    // TODO: need to implement
  }

  /**
     * Gets user data information
     * @author Gary
     * @return array of data about user from db
     */
  public function getData()
  {
    return $this->data;
  }

  public function exists()
  {
    return empty($this->data);
  }

  public function lastAdded() {
    $sql = "SELECT  MAX(gsale_id) AS gsale_id FROM garage_sales;";
    $result = $this->db_conn->query($sql, array());
    if ($result->getCount() > 0) {
      $this->data = $result->getResult();
      return true;
    }
    return false;
  }
}

/**
 * Class to redirect you to a different page.
 */
class Redirect
{
  /**
     * Redirects to page given as parameter
     * eg. Redirect::page('index.php');
     * @author Gary
     * @param string [$location = null] page to go to
     */
  public static function page($location = null)
  {
    if ($location != null) {
      if (is_numeric($location)) {
        switch ($location) {
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
abstract class PageBuilder
{
  /**
     * Gets the navbar for the page
     * eg. PageBuilder::getHeader();
     * @author Gary
     */
  public function getHeader()
  {
    $this->active = '';
    $this->title = '';
    $this->header = '';
    $user = new User();
    $this->logged_in = $user->isLoggedIn();
    $array = explode('/', sanitizeInput($_SERVER['PHP_SELF']));
    $page_name = array_pop($array);
    switch ($page_name) {
      case "index.php":
        $this->active = 'index';
        $this->header = $this->makeHeader($this->active, $this->logged_in);
        echo $this->header;
        break;
      case "yourSales.php":
        $this->active = 'yourSales';
        $this->header = $this->makeHeader($this->active, $this->logged_in);
        echo $this->header;
        break;
      case "items.php":
        $this->active = 'items';
        $this->header = $this->makeHeader($this->active, $this->logged_in);
        echo $this->header;
        break;
      case "createAccount.php":
        $this->active = 'createAccount';
        $this->header = $this->makeHeader($this->active, $this->logged_in);
        echo $this->header;
        break;
      case "otherSales.php":
        $this->active = 'otherSales';
        $this->header = $this->makeHeader($this->active, $this->logged_in);
        echo $this->header;
        break;
      case "createSale2.php":
        $this->active = 'createSale'; // TODO: change active
        $this->header = $this->makeHeader($this->active, $this->logged_in);
        echo $this->header;
        break;
      case "createItem.php":
        $this->active = 'createItem';
        $this->header = $this->makeHeader($this->active, $this->logged_in);
        echo $this->header;
        break;
      case "editAccount.php":
        $this->active = 'createItem';
        $this->header = $this->makeHeader($this->active, $this->logged_in);
        echo $this->header;
        break;
      default:
        //$this->active = 'createSale';
        //$this->header = $this->makeHeader($this->active, $this->logged_in);
        echo "Add page";
    }
  }

  /**
     * Gets the footer for the page
     * eg. PageBuilder::getFooter();
     * @author Gary
     */
  static function getFooter()
  {
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
  static function getTitle()
  {
    $array = explode('/', sanitizeInput($_SERVER['PHP_SELF']));
    $page_name = array_pop($array);
    $array = array_reverse(explode('.', $page_name));
    $title = ucfirst(array_pop($array));
    echo $title . " | GSale";
  }

  /**
     * Makes the header for the page
     * @author Gary
     * @param  string $active sets the active class in header so user can tell what page they are on
     * @param  string $title of page
     * @param  boolean $logged_in true if the user is logged in else false
     * @return string html text for header
     */
  protected function makeHeader($active, $logged_in)
  {
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
								<a class="navbar-brand" href="index.php"><img src="../img/garage_logo_final2.jpg"/></a>
								</div>
								<div class="collapse navbar-collapse" id="MyNavbar">
									<ul class="nav navbar-nav navbar float-left">
           <li class="'. ((strcmp($this->getCurrentPage(), "index.php") == 0)?  'active' : '') . '"><a href="index.php">Home</a></li>
           <li role="separator" class="divider"></li>
            <li class="'. ((strcmp($this->getCurrentPage(), "otherSales.php") == 0)?  'active' :  '') . '"><a href="otherSales.php">Sales</a></li>
           <li role="separator" class="divider"></li>
            <li class="'. ((strcmp($this->getCurrentPage(), "items.php") == 0)? 'active' : '') . '"><a href="items.php">Items</a></li>
           <li role="separator" class="divider"></li>
									</ul>
									<ul class="nav navbar-nav navbar-right">
										<li>
											<form class="navbar-form navbar-right" role="search">
												<div class="input-group">
													<input id="search" type="text" class="form-control" placeholder="Search" name="search">
													<div class="input-group-btn">
														<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
													</div>
												</div>
											</form>
										</li>
										<li class="' . ((strcmp($this->getCurrentPage(), "createAccount.php") == 0) ? "active" : 'null') . '"><a href="createAccount.php">Create Account</a></li>
										<li><a class="'. ((strcmp($this->getCurrentPage(), "login.php") == 0)? "active" : '') . '" href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
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
								<a class="navbar-brand" href="#"><img src="../img/garage_logo_final2.jpg"/></a>
								</div>
								<div class="collapse navbar-collapse" id="MyNavbar">
									<ul class="nav navbar-nav navbar float-left">
									<li class="'. ((strcmp($this->getCurrentPage(), "index.php") == 0)? 'active' : '') . '"><a href="index.php">Home</a></li>
           <li role="separator" class="divider"></li>
            <li class="'. ((strcmp($this->getCurrentPage(), "otherSales.php") == 0) ? 'active' : '') . '"><a href="otherSales.php">Sales</a></li>
           <li role="separator" class="divider"></li>
            <li class="'. ((strcmp($this->getCurrentPage(), "items.php") == 0) ? 'active' : '') . '"><a href="items.php">Items</a></li>
           <li role="separator" class="divider"></li>
									</ul>
									<ul class="nav navbar-nav navbar-right">
										<li>
                      <form class="navbar-form navbar-right" role="search">
                        <div class="input-group">
                          <input id="search" type="text" class="form-control" placeholder="Search" name="search">
                          <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                          </div>
                        </div>
                      </form>
										</li>
										<li class="dropdown '. ((strcmp($this->getCurrentPage(), "yourSales.php") == 0) ? 'active' : '') . '">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Account <span class="caret"></span></a>
										<ul class="dropdown-menu">
											<li><a class="drop-link" href="yourSales.php">My Sales</a></li>
											<li role="separator" class="divider"></li>
											<li><a class="drop-link" href="editAccount.php">Edit Account</a></li>
											<li role="separator" class="divider"></li>
											<li><a class="drop-link" href="stats.php">Statics</a></li>
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
  protected function getActive($active)
  {
    $html = '';
    $active_index = '';
    switch ($active) { // TODO: add other cases
      case "index":
        $active_index = 0;
        break;
      case "otherSales":
        $active_index = 1;
        break;
      case "items":
        $active_index = 2;
        break;
      case "yourSales":
        $active_index = 0;
      case "createSales2":
        $active_index = 0;
      case "createItem":
        $active_index = 0;
      default:
        $active_index = 0;
    }

    $pages = array('index.php', 'otherSales.php', 'items.php');
    $selections = array('Home', 'Sales', 'Items');

    for ($i = 0; $i < (count($pages) * 2); $i++) {
      if ($i % 2 == 0 && $i == ($active_index * 2)) {
        $html .= '<li class="active"><a href="' . $pages[$active_index] . '">' . $selections[$active_index] . '</a></li>';
      } else if ($i % 2 == 0) {
        $html .= '<li class=""><a href="' . $pages[($i * .5)] . '">' . $selections[($i * .5)] . '</a></li>';
      } else {
        $html .= '<li role="separator" class="divider"></li>';
      }
    }
    return $html;
  }

  protected function getCurrentPage() {
    $array = explode('/', sanitizeInput($_SERVER['PHP_SELF']));
    $page_name = array_pop($array);
    return $page_name;
  }

  protected function getActivePage() {
    $active = array(false, false, false, false);
    switch ($this->getCurrentPage()) {
      case "index":
        $active[0] = true;
        break;
      case "otherSales":
        $active[0] = true;
        break;
      case "items":
        $active[0] = true;
        break;
      case "createAccount":
        $active[0] = true;
        break;
      case "createItem":
        $active[0] = true;
        break;
      case "yourSales":
        $active[0] = true;
        break;
      case "yourSales":
        $active[0] = true;
        break;
      case "yourSales":
        $active[0] = true;
        break;
      case "yourSales":
        $active[0] = true;
        break;

    }
  }



  /**
     * TODO: To be implemented by subclasses
     */
  abstract public function getContent();

}

class CreateItemsPage extends PageBuilder {
  private $user, $db_conn;

  public function __construct() {
    $this->user = new User();
    $this->db_conn = SqlManager::getInstance();
  }

  public function getContent() {

  }

}

/**
 * TODO: To be implemented by subclasses
 */
class IndexPage extends PageBuilder
{
  private $user, $db_conn;

  function __construct()
  {
    $this->user = new User();
    $this->db_conn = SqlManager::getInstance();
  }

  public function getContent()
  {
  }

  private function getTableData()
  {
    $sql = "SELECT count(gsale_id) as count FROM garage_sales";
    $result = $this->db_conn->query($sql, array());
    $sql = "SELECT min(gsale_id) as min FROM garage_sales";
    $max = $result->getResult()[0]->count;
    $result = $this->db_conn->query($sql, array());
    $min = $result->getResult()[0]->min;
    ($min > $max) ? $max = $min : false;
    $indexArray = array(rand($min, $max), rand($min, $max), rand($min, $max), rand($min, $max));
    $return_array = array();
    foreach ($indexArray as $index) {
      $garage_sale = new GarageSale($index);
      array_push($return_array, $garage_sale);
    }
    return $return_array;
  }

  private function getWelcome($size)
  {
    echo "<div class='container'>
				<div class='col-sm-{$size} text-left'>
					<h1>Welcome</h1>
					<p>Paragraph about us!</p>
					<p>We At G=Sale have a simple goal. That goal is to help connect those wishing to sell their unneeded possessions to those who are looking for deals cutting out the middleman. A trade between neighbors. You might be hard on for cash. Or your looking to unburden yourself with unnecessary things you have gathered over the years. Regardless of your sepenstance you can create an account and set up your garage sale for free! Or maybe you are looking for a old, no longer sold in stores item. or you just want to save some cash picking up a hand me down dresser. You don\'t need an account just simply check out our Sales page to find garage that are live near you. Or you can search by specific keyword if you already know what you\'re looking for.</p>
					<hr>
				</div>";
  }

  private function getLogin()
  {

  }

  public function getTable()
  {
    $sales = $this->getTableData();
    $html = "<div class='panel-group'>";
    $count = 1;
    foreach ($sales as $sale) {
      $gsale_id = $sale->getData()->gsale_id;
      $sale_name = $sale->getData()->sale_name;
      $image_url = $sale->getData()->image_url;
      $description = $sale->getData()->description;
      $dates = $sale->getData()->dates;

      $place = new Place($places_fk_id);
      $place_location = $place->getData()->street_number . " " . $place->getData()->route . " " . $place->getData()->locality .", " . $place->getData()->administrative_area_level_1 . " " . $place->getData()->postal_code;
      $place_location = "";
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
class RegisterPage extends PageBuilder
{

  public function getContent()
  {

  }

  protected function getTable()
  {

  }

  protected function getTableData()
  {

  }

}

/**
 * TODO: To be implemented by subclasses
 */
class SalesPage extends PageBuilder {
  private $user, $db_conn;

  public function __construct() {
    $this->user = new User();
    $this->db_conn = SqlManager::getInstance();
  }
  public function getContent() {
    $html = '<div class="container"><ul class="list-group">';
    $table_data = $this->getTableData();
    if (count($table_data) > 0 ) {
      foreach ($table_data as $row) {
        $dates = DateTimeFormater::getDays($row[0]->dates);
        $dates_max = count($dates);
        $html .= '<!-- list-group-of-sales -->
                <li class="list-group-item">
                  <div class="row">
                    <div class="col-sm-5">
                      <div class="col-sm-4">
                        <div class="collapse-header">Name:</div>
                        <div>' . $row[0]->sale_name . '</div>
                      </div>
                      <div class="col-sm-8">
                        <div class="col-sm-6" style="padding-left:0;">
                          <div class="collapse-header">Sart Date:</div><div>' . $dates[0] . '
                          </div>
                        </div>
                        <div class="col-sm-6" style="padding-left:0;">
                        <div class="collapse-header">End Date:</div>
                        <div>' . $dates[$dates_max-1]  . '</div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-7 text-right">
                      <div class="col-sm-3">
                        <a class="btn btn-primary form-control" href="otherSales.php?gsale_id=' . $row[0]->gsale_id . '">View&nbsp;<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                      </div>
                      <div class="col-sm-3">
                        <a class="btn btn-green-no-padding form-control" href="runSale.php?gsale_id=' . $row[0]->gsale_id . '">Run&nbsp;<span class="glyphicon glyphicon-play" aria-hidden="true"></span></a>
                      </div>
                      <div class="col-sm-3">
                        <a class="btn btn-warning form-control" href="?action=edit&amp;gsale_id=' . $row[0]->gsale_id . '">Edit&nbsp;<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                      </div>
                      <div class="col-sm-3">
                        <a class="btn btn-danger form-control" href="" data-toggle="modal" data-target="#deleteModal' . $row[0]->gsale_id . '">Delete&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span></a>
                      </div>
                    </div>
                  </div>
                  <!-- Modal -->
                <div class="modal fade" id="deleteModal' . $row[0]->gsale_id . '" role="dialog">
                  <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h4 class="modal-title"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span>&nbsp;Warning</h4>
                      </div>
                      <div class="modal-body">
                        <p>You are about to delete a sale are you sure you want to do that?</p>
                      </div>
                      <div class="modal-footer">
                        <a type="button" class="btn btn-danger pull-left" href="?action=delete&amp;gsale_id=' . $row[0]->gsale_id . '">Delete Sale</a>
                        <a type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
                      </div>
                    </div>
                  </div>
                </div>
                </li>
                ';
      }
    } else {
      $html .= '<!-- list-group-of-sales -->
                <li class="list-group-item">
                  <div class="row">
                    <div class="col-sm-12">
                      <div>No sales have been created</div>
                    </div>
                  </div>
                </li>';
    }

    $html .= "</div></ul>";
    return $html;
  }

  protected function getTable() {

  }

  protected function getTableData() {
    $user_id = $this->user->data()->user_id;
    $sql = "SELECT garage_sales_fk_id FROM garage_sales_users WHERE user_fk_id = ?";
    $result = $this->db_conn->query($sql, array($user_id));
    $sql = "SELECT * FROM garage_sales WHERE gsale_id = ?";
    $results = $result->getResult();
    $count = count($result);
    $gsales = array();
    foreach ($results as $result) {
      $result = $this->db_conn->query($sql, array($result->garage_sales_fk_id));
      if (!$result->getError()) {
        $gsales[] = $result->getResult();
      }
    }
    return $gsales;
  }
}

/**
 * TODO: To be implemented by subclasses
 */
class CreateSalesPage extends PageBuilder
{
  public function getContent()
  {

  }

  protected function getTable()
  {

  }

  protected function getTableData()
  {

  }
}


class SalesListTable {
  private $db_conn, $places, $gsales;
  public function __construct() {
    $this->db_conn = SqlManager::getInstance();
  }

  public function getTable($lat, $lng, $index, $size = 5) {
    $this->getTableData($lat, $lng, $index, $size);
    echo $this->createTable();
  }

  public function getRandomTable($numberOfSales) {

  }

  private function getTableData($lat, $lng, $index, $size) {
    $sql = "SELECT *,SQRT(POWER(? - places.lat, 2) + POWER(? - places.lng,2)) AS Distance FROM places WHERE place_id > ? ORDER BY Distance ASC LIMIT " . $size;
    $params = array($lat, $lng, $index);
    $result = $this->db_conn->query($sql,$params);
    if (!$result->getError()) {
      $this->places = $result->getResult();
    }
    $sql = "SELECT gsale_id, sale_name, image_url, description, dates, place_fk_id FROM garage_sales JOIN garage_sales_places ON garage_sales.gsale_id = garage_sales_places.garage_sale_fk_id WHERE place_fk_id = ?";
    $length = count($this->places);
    for ($i = 0; $i < $length; $i++) {
      $params = array($this->places[$i]->place_id);
      $result = $this->db_conn->query($sql, $params);
      if (!$result->getError()) {
        $this->gsales[] = $result->getResult();
      }
    }
  }

  private function createTable() {
    $table = '<h3>Near By:</h3><div class="panel-group">';
    $length = count($this->gsales);
    for ($i = 0; $i < $length; $i++) {
      $dates = DateTimeFormater::getDays($this->gsales[$i][0]->dates);
      $table .=
        "<div class='panel panel-default'>
          <div class='panel-heading' data-toggle='collapse' data-target='#collapse{$i}' " . ($i === 0 ? "aria-expanded='true'" : "") . ">
            <h5 class='panel-title collapse-header'>Location:</h5>
            <p class='collapse-header-text'>{$this->places[$i]->street_number} {$this->places[$i]->route} {$this->places[$i]->locality}, {$this->places[$i]->administrative_area_level_1} {$this->places[$i]->postal_code}</p>
            <span class='glyphicon glyphicon-chevron-down pull-right' aria-hidden='true'></span>
          </div>
          <div id='collapse{$i}' class='panel-collapse collapse " . ($i === 0 ? "in" : "") . "' " . ($i === 0 ? "aria-expanded='true'" : "") . ">
            <div class='panel-body'>
              <div class='row text-center'>
                <h5 class='collapse-header'>{$this->gsales[$i][0]->sale_name}</h5>
                <p></p>
              </div>
              <div class='row'>
                <div class='col-sm-2'>
                  <img src='{$this->gsales[$i][0]->image_url}'>
                </div>
                <div class='col-sm-4'>
                  <h5 class='collapse-header'>Date: </h5>
                  <p>{$dates[0]} - {$dates[count($dates)-1]}</p>
                </div>
                <div class='col-sm-5'>
                  <h5 class='collapse-header'>Description:</h5>
                  <p>{$this->gsales[$i][0]->description}</p>
                </div>
              </div>
              <div class='row'>
                <div class='col-xs-12 col-sm-8 pull-right'>
                  <a class='btn btn-primary form-control' href='otherSales.php?gsale_id={$this->gsales[$i][0]->gsale_id}'>See Details&nbsp;<span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></a>
                </div>
              </div>
            </div>
          </div>
        </div>";
    }
    $table .= '</div>';
    return $table;

  }

  public function getGsales() {
    return $this->gsales;
  }

  public function getPlaces() {
    return $this->places;
  }
}


/**
 * TODO: To be implemented by subclasses
 */
class ItemsPage extends PageBuilder
{
  public function getContent()
  {

  }

  protected function getTable()
  {

  }

  protected function getTableData()
  {

  }
}

/**
 * Class is used to vaidate user input and return any errors
 * in the input if any exist.
 */
class Validation
{
  private $passed,
  $errors,
  $db_conn;

  /**
     * Constructor that gets connection to db and intizes class variables
     */
  public function __construct()
  {
    $this->passed = false;
    $this->db_conn = SqlManager::getInstance();
    $this->errors = array();
  }

  /**
     * Checks to make sure ever rule on input passed
     * eg.
     * @return Validation returns itself so you can check for errors
     */
  public function check($submit_method, $tests = array())
  {
    foreach ($tests as $test => $rules) {
      foreach ($rules as $rule => $rule_value) {
        $value = sanitizeInput($submit_method[$test]);
        if ($rule === 'required' && empty($value)) {
          $this->addError("{$test} is required");
        } else if (!empty($value)) {
          switch ($rule) {
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
              $phone_number = preg_replace('/[\s+\(\)\-]+/', '', $phone_number);
              if (!is_numeric($phone_number)) {
                $this->addError("Phone number was not valid.");
              }
              break;
            case 'address': // TODO: need to implement
              $address = sanitizeInput($submit_method[$test]);
              $addressArray = explode(",", $address);
              if (count($addressArray) < 3) {
                $this->addError("Address was not valid.");
              } else {
                foreach ($addressArray as $field) {
                  if (strlen($field) < 2) {
                    $this->addError("Address was not valid.");
                    break;
                  }
                }
              }
              break;
            case 'image': // TODO: need to implement
              var_dump($submit_method[$rule]);
              break;
            case 'price': // TODO: need to implement
              break;
            case 'name': // TODO: need to implement
              break;
            case 'lat':
              if (abs(sanitizeInput($submit_method[$rule])) > 90) {
                $this->addError("Latitude out of bounds");
              }
              break;
            case 'lng':
              if (abs(sanitizeInput($submit_method[$rule])) > 180) {
                $this->addError("Longitude out of bounds");
              }
              break;
            case 'catagory': // TODO: need to implement
              break;
            case 'date':
              $dates = array();
              for ($i = 0; $i < count($value); $i++) {
                $dates[] = sanitizeInput($submit_method[$rule][$i]);
              }
              for ($i = 0; $i < count($submit_method['startTime']); $i++) {
                $startTime[] = sanitizeInput($submit_method['startTime'][$i]);
              }
              $count = 1;
              foreach ($dates as $date) {
                if (!is_numeric(substr($date, 0, 4))) {
                  $this->addError("Date {$count} was not valid");
                } else if ($date[4] != '-') {
                  $this->addError("Date {$count} was not valid");
                } else if (!is_numeric(substr($date, 5, 2))) {
                  $this->addError("Date {$count} was not valid");
                } else if ($date[7] != '-') {
                  $this->addError("Date {$count} was not valid");
                } else if (!is_numeric(substr($date, 8))) {
                  $this->addError("Date {$count} was not valid");
                } else if ((int)substr($date, 0, 4) < (int)date("Y") || (int)substr($date, 5, 2) < (int)date("m") || (int)substr($date, 8) < (int)date("d")) {
                  $this->addError("Date {$count} can not be before today");
                } else if ((int)substr($date, 0, 4) == (int)date("Y") && (int)substr($date, 5, 2) == (int)date("m") && (int)substr($date, 8) == (int)date("d") && $startTime != -1) {
                  //https://maps.googleapis.com/maps/api/timezone/json?location=39.6034810,-119.6822510&timestamp=1331766000&key=YOUR_API_KEY
                  // TODO: get timezone from google to get correct time
                }
                $count++;
              }
              break;
            case 'startTime':
              $startTime = array();
              for ($i = 0; $i < count($value); $i++) {
                $startTime[] = sanitizeInput($submit_method[$rule][$i]);
              }
              $count = 1;
              foreach ($startTime as $time) {
                if (!is_numeric(substr($time, 0, 2))) {
                  $this->addError("Start time {$count} was not a time");
                } else if (strlen($time) > 0 && $time[2] != ':') {
                  $this->addError("Start time {$count} was not a time");
                } else if (!is_numeric(substr($time, 3, 2))) {
                  $this->addError("Start time {$count} was not a time");
                }
                /* FUTURE: time vaild if its after current time today, currently only checking current time not future times.
                    if ((int)substr($time,0,2) < (int)date("H") || (int)substr($time,3,2) < (int)date("i")) {
                      $this->addError("Time {$count} can not be before now");
                    }*/
                $count++;
              }
              break;
            case 'endTime': // TODO: need to implement
              $endTime = array();
              for (!$i = 0; $i < count($value); $i++) {
                $endTime[] = sanitizeInput($submit_method[$rule][$i]);
              }
              $startTime = array();
              for (!$i = 0; $i < count($value); $i++) {
                $startTime[] = sanitizeInput($submit_method[$rule][$i]);
              }
              $count = 1;
              foreach ($endTime as $time) {
                if (!is_numeric(substr($time, 0, 2))) {
                  $this->addError("End time {$count} was not a time");
                } else if (strlen($time) > 0 && $time[2] != ':') {
                  $this->addError("End time {$count} was not a time");
                } else if (!is_numeric(substr($time, 3, 2))) {
                  $this->addError("End time {$count} was not a time");
                }
                if ((int)substr($time,0, 2) < (int)substr($startTime[$i-1], 0, 2) || (int)substr($time,3, 2) < (int)substr($startTime[$i-1], 3, 2)) {
                  $this->addError("End time {$count} must not be before Start time");
                }
                /* FUTURE: time vaild if its after current time today, currently only checking current time not future times.
                  if ((int)substr($time,0,2) < (int)date("H") || (int)substr($time,3,2) < (int)date("i")) {
                    $this->addError("Time {$count} can not be before now");
                  }*/
                $count++;
              }
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

  function checkArray($submit_method, $tests = array())
  {

  }

  /**
     * Adds an error to the list of errors
     * @param string $error to be added to error array
     */
  private function addError($error)
  {
    $this->errors[] = $error;
  }

  /**
     * Gets the list of errors
     * @return array of errors
     */
  public function getErrors()
  {
    return $this->errors;
  }

  /**
     * Returns true if all test on input were passed else
     * it returns false.
     * @return boolean true if passed, else false
     */
  public function passed()
  {
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
    if (self::exists($name)) {
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
   * @param  string $name of session variable
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
   * @param  string $name of session variable
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
    self::put($name, '', time() - 1);
  }
}

abstract class DB_Object {
  protected $db_conn, $data;

  public function __construct() {
    $this->db_conn = SqlManager::getInstance();
    $this->data = array();
  }

  public abstract function create($params = array());

  public abstract function edit($params = array(), $object_id = null);

  public abstract function remove($object_id = null);

  public abstract function find($object_id = null);

  // Gets the max index aka the most recently added object
  public abstract function lastAdded();

  public function exists() {
    return (!empty($this->data)) ? true : false;
  }

  public function getData() {
    return $this->data;
  }
}


class Phone extends DB_Object{
  /**
   * Constructor that initiazes class variables
   * @author Gary
   * @param integer [$phone_id = null]       id of phone number desired from db
   */
  public function __construct($phone_id = null) {
    parent::__construct();
    if ($phone_id != null) {
      $this->find($phone_id);
    }
  }

  public function create($params = array()) {
    // TODO: change phone number to auto inc
    $sql = "INSERT INTO phones (phone_id, phone_number) VALUES (NULL, ?);";
    $result = $this->db_conn->query($sql, $params);
    if ($result->getError()) {
      throw new Exception("Error creating phone number!");
    }
  }

  public function edit($params = array(), $phone_id = null) {
    $sql = "UPDATE phones SET phone_number = ? WHERE phone_id = ?";
    if ($phone_id) {
      $found = $this->find($phone_id);
      if ($found) {
        $phone_id = $this->getData()[0]->phone_id;
        array_push($params, $phone_id);
        $result = $this->db_conn->query($sql, $params);
        if (!$result->getError()) { // no error
          return true;
        }
      }
    } else {
      if ($this->exists()) {
        $phone_id = $this->getData()[0]->phone_id;
        array_push($params, $phone_id);
        $result = $this->db_conn->query($sql, $params);
        if (!$result->getError()) { // no error
          return true;
        }
      }
    }
    return false;
  }

  // TODO: need to implement phone remove
  public function remove($phone_id = null) {
    // don't forget about garage_sales_phones
  }

  public function find($phone_id = null) {
    if ($phone_id != null) {
      $sql = "SELECT * FROM phones WHERE phone_id = ?";
      $params = array($phone_id);
      $result = $this->db_conn->query($sql, $params);
      if ($result->getCount() > 0) {
        $this->data = $result->getResult();
        return true;
      }
    }
    return false;
  }

  public function lastAdded() {
    $sql = "SELECT  MAX(phone_id) AS phone_id FROM phones;";
    $result = $this->db_conn->query($sql, array());
    if ($result->getCount() > 0) {
      $this->data = $result->getResult();
      return true;
    }
    return false;
  }

  /**
   * Formats give input to (xxx)-xxx-xxxx
   * @author Gary
   * @param  string $phone_number that needs to be formatted
   * @return string formatted number
   */
  public static function formatNumber($phone_number) {
    $pattern = '/\D/';
    $replace = '';
    $phone_number = preg_replace($pattern, $replace, $phone_number);
    $number_length = strlen($phone_number);
    if($number_length < 10) {
      return null;
    } else if ($number_length === 10) {   // format (xxx)-xxx-xxxx
      $phone_number = "(" . $phone_number;
      $phone_number = substr($phone_number, 0, 4) . ")-" . substr($phone_number, 4, 3) . "-" . substr($phone_number, 7);
    } else if ($number_length === 11) {   // format x(xxx)-xxx-xxxx
      $phone_number = substr($phone_number, 0, 1) . "(" . substr($phone_number, 1);
      $phone_number = substr($phone_number, 0, 5) . ")-" . substr($phone_number, 5, 3) . "-" . substr($phone_number, 8);
    } else if ($number_length === 12) {   // format xx(xxx)-xxx-xxxx
      $phone_number = substr($phone_number, 0, 2) . "(" . substr($phone_number, 2);
      $phone_number = substr($phone_number, 0, 6) . ")-" . substr($phone_number, 6, 3) . "-" . substr($phone_number, 9);
    } else {
      return null;
    }
    return $phone_number;
  }
}

class Place extends DB_Object {
  private $json;

  public function __construct($place_id = null) {
    parent::__construct();
    if ($place_id) {
      $this->find($place_id);
    }
  }

  public function create($params = array()) {
    $sql = "INSERT INTO places (place_id, street_number, route, locality, administrative_area_level_1, country, postal_code, lat, lng) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?);";
    $startIndex = 0;
    if (count($this->json) > 0 && strcmp($this->json['results'][0]['address_components'][3]['types'][0], "premise") == 0) {
      $locationArray = $this->json['results'][0]['address_components'];
      $lat_lng_array = $this->json['results'][0]['geometry']['location'];
      $params = array(
        $locationArray[1]['short_name'],    // street_number
        $locationArray[2]['short_name'],    // route
        $locationArray[3]['short_name'],    // locality
        $locationArray[5]['short_name'],    // admin_area_lvl_1
        $locationArray[6]['short_name'],    // country
        $locationArray[7]['short_name'],    // postal_code
        $lat_lng_array['lat'],              // latitude
        $lat_lng_array['lng']               // longitude
      );
    } else {
      // FIXME: look at order of insert
      $locationArray = $this->json['results'][0]['address_components'];
      $lat_lng_array = $this->json['results'][0]['geometry']['location'];
      $params = array(
        $locationArray[0]['short_name'],    // street_number
        $locationArray[1]['short_name'],    // route
        $locationArray[2]['short_name'],    // locality
        $locationArray[4]['short_name'],    // admin_area_lvl_1
        $locationArray[5]['short_name'],    // country
        $locationArray[6]['short_name'],    // postal_code
        $lat_lng_array['lat'],              // latitude
        $lat_lng_array['lng']               // longitude
      );
    }
    $result = $this->db_conn->query($sql, $params);
    if ($result->getError()) {
      throw new Exception("Error creating place!");
    }
  }

  public function edit($params = array(), $object_id = null) {
    $sql = "UPDATE places SET route = ? , street_number = ?, locality = ?, administrative_area_level_1 = ?, postal_code = ?, country = ?, lat = ?, lng = ? WHERE place_id = ?";
    if ($place_id) {
      $found = $this->find($place_id);
      if ($found) {
        $place_id = $this->data()->place_id;
        array_push($params, $place_id);
        $result = $this->db_conn->query($sql, $params);
        if ($result->getError()) {
          return true;
        }
      }
    } else {
      if ($this->exists()) {
        $place_id = $this->data()->place_id;
        array_push($params, $place_id);
        $result = $this->db_conn->query($sql, $params);
        if ($result->getError()) {
          return true;
        }
      }
    }
    return false;
  }

  public function remove($place_id = null) {
    $sql = "DELETE FROM garage_sales_places WHERE place_fk_id = ?;";
    $sql = "DELETE FROM places WHERE place_id = ?;";
    if (!$place_id && $this->exists()) {
      // TODO: remove current place
    }
    if ($place_id != null) {
      if ($this->find($place_id)) {
        $result = $this->db_conn->query($sql, array($place_id));
        if (!$result->getError()) {
          return true;
        }
      }
    }
    return false;
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

  public function lastAdded() {
    $sql = "SELECT  MAX(place_id) AS place_id FROM places;";
    $result = $this->db_conn->query($sql, array());
    if ($result->getCount() > 0) {
      $this->data = $result->getResult();
      return true;
    }
    return false;
  }

  public function getPlaceJSON($place, $key = "&key=AIzaSyDn4zPdPO8C7P1s-4YoVPG_FuMabLYqVcw") {
    $url = "https://maps.googleapis.com/maps/api/geocode/json?";
    $searchType = "";
    if (is_array($place)) {
      $search = "latlng={$place['lat']},{$place['lng']}";
    } else {
      if (!$place || strcmp($place, "") == 0) {
        throw new Exception("Place can't be null or blank");
      }
      $search = "address=" . str_replace(" ", "+", $place);
    }
    $response = file_get_contents($url . $search . $key);
    if (!$response) {
      throw new Exception("Error happened loading place from google");
    }
    $json = json_decode($response, true);
    if (strcmp($json['status'], "OK") == 0) {
      $this->json = $json;
    } else {
      throw new Exception("Error happened loading place from google");
    }
    return $this->json;
  }
}

class DateTimeFormater {

  public static function formatDateTime($time1, $time2, $date) {
    // TODO: need to implment
  }



  public static function getDateTime($date_time) {
    $return_array = array();
    $date_time = explode(',',$date_time);
    foreach ($date_time as $param) {
      $return_array[] = explode('-', $param);
    }
    return $return_array;
  }

  public static function getDays($date_time) {
    $date_time = DateTimeFormater::getDateTime($date_time);
    $times = array();
    $count = count($date_time);
    if ($count == 1) {
      $times[] = DateTimeFormater::parseDay($date_time[0][2]);
    } else {
      for ($i = 0; $i < $count; $i++) {
        $times[] = DateTimeFormater::parseDay($date_time[$i][2]);
      }
    }
    return $times;
  }

  public static function getTimes($date_time) {
    $date_time = DateTimeFormater::getDateTime($date_time);
    $times = array();
    $count = count($date_time);
    if ($count == 1) {
      $times[] = DateTimeFormater::parseTime($date_time[0][0]) . " - " . DateTimeFormater::parseTime($date_time[0][1]);
    } else if($count > 1) {
      for ($i = 0; $i < $count; $i++) {
        $times[] = DateTimeFormater::parseTime($date_time[$i][0]) . " - " . DateTimeFormater::parseTime($date_time[$i][1]);
      }
    } else {
      // no times
    }
    return $times;
  }

  private static function parseTime($time) {
    $standard_time = "";
    //$time = explode(':',$time);
    switch ($time) {
      case $time < 12:
        $standard_time = $time . "am";
        break;
      case "12:00":
        $standard_time = $time . "pm";
        break;
      case $time > 12:
        $standard_time = (explode(":",$time)[0] % 12) . ":" . explode(":",$time)[1] . "pm";
        break;
      default:
        $standard_time = "error";
    }
    return $standard_time;
  }

  private static function parseDay($day) {
    $standard_day = "";
    $mmddyyyy = explode('/', $day);
    $month = "";
    $day_of_week = DateTimeFormater::parseDayOfWeek($day);
    switch ($mmddyyyy) {
      case $mmddyyyy[0] == '1':
        $month = "Jan";
        break;
      case $mmddyyyy[0] == '2':
        $month = "Feb";
        break;
      case $mmddyyyy[0] == '3':
        $month = "Mar";
        break;
      case $mmddyyyy[0] == '4':
        $month = "Apr";
        break;
      case $mmddyyyy[0] == '5':
        $month = "May";
        break;
      case $mmddyyyy[0] == '6':
        $month = "Jun";
        break;
      case $mmddyyyy[0] == '7':
        $month = "Jul";
        break;
      case $mmddyyyy[0] == '8':
        $month = "Aug";
        break;
      case $mmddyyyy[0] == '9':
        $month = "Sept";
        break;
      case $mmddyyyy[0] == '10':
        $month = "Oct";
        break;
      case $mmddyyyy[0] == '11':
        $month = "Nov";
        break;
      case $mmddyyyy[0] == '12':
        $month = "Dec";
        break;
    }
    return $day_of_week . ", " . $month . " " . $mmddyyyy[1];
  }

  private static function parseDayOfWeek($date) {
    $dates = explode('/', $date);
    $month = ($dates[0] + 10) % 12;
    $date = $dates[1];
    $year = (int)substr($dates[2], 2);
    $year2 = (int)substr($dates[2], 0, 2);
    $date = ($date + floor((2.6*$month) - .2) -(2*20) + $year + floor($year/4) + floor($year2/4))%7;
    $day = "";
    switch($date) {
      case 0:
        $day = "Sun";
        break;
      case 1:
        $day = "Mon";
        break;
      case 2:
        $day = "Tue";
        break;
      case 3:
        $day = "Wed";
        break;
      case 4:
        $day = "Thur";
        break;
      case 5:
        $day = "Fri";
        break;
      case 6:
        $day = "Sat";
        break;
      default:
        $day = "error";
    }
    return $day;
  }
}

class ImageProcesser {
  private $max_size, $errors, $new_location;

  public function __construct($imageName, $location = "../uploads/sales/") {
    $this->max_size = 500000;
    $this->errors = array();
    //var_dump($_FILES);
    $newFile = "";
    $target_file = $location . basename($_FILES[$imageName]["name"]);
    if ($this->validateImage($imageName, $target_file)) {
      do {
        $newFile = $location . $this->getUniqueName() . "." . pathinfo($target_file,PATHINFO_EXTENSION);
      } while($this->searchImageNames($newFile));
      if (!$this->transferImage($_FILES[$imageName]["tmp_name"], $newFile)) {
        $this->errors[] = "Error uploading image";
      } else {
        // upload was successful
        $this->new_location = $newFile;
      }
    } else {
      // there was an error
    }
  }

  private function validateImage($imageName, $target_file) {
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    if (strcmp($imageFileType, "") === 0) {
      $this->errors[] = "Error no file selected";
      return false;
    }
    $check = getimagesize($_FILES[$imageName]["tmp_name"]);
    if($check !== false) { // FUTURE: this is a poor method of validation
      // Check file size
      if ($_FILES["$imageName"]["size"] > $this->max_size) {
        $this->errors[] = "Sorry, your file is too large.";
        return false;
      } else if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ){
        // Allow certain file formats
        $this->errors[] =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        return false;
      } else {
        return true;
      }
    } else {
      $this->errors[] =  "File uploaded was not an image";
      return false;
    }
  }

  private function searchImageNames($name) {
    return (file_exists($name));
  }

  private function getUniqueName() {
    return md5(uniqid());
  }

  private function transferImage($file, $location) {
    return move_uploaded_file($file, $location);
  }

  public function getErrors() {
    return $this->errors;
  }

  public function getNewName() {
    return $this->new_location;
  }

}

// TODO: change all dabase objects subclass to use DB_Object class
// TODO: fix indexpage display sales near you table
// TODO: your sales page html needs to be finsihed
// TODO: finish create sale
// TODO: how to implement keywords catagories for items for sale?
// FUTURE: change each class to their own file then create Objects.php file that requires all objects?
?>
