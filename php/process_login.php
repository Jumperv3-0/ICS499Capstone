<?php
	require_once 'db_config.php';


	$instance = SqlManager::getInstance();
	$conn = $instance->getConnection();



	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password'])) {
			if (login(sanitizeInput($_POST['username']), sanitizeInput($_POST['password']),$conn)) {
				header("Location: index.php?login=success");
				//echo "success";
			}
			else {
				//echo "fail";
				header("Location: index.php?login=fail");
			}
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

	function login($username, $password, $conn) {
		$sql = "SELECT password FROM users WHERE username = :username";
		$statement= $conn->prepare($sql);
		$statement->execute(array(':username'=> $username));
		$result =  $statement->fetch();

		if (password_verify($password,$result['password'])) {
// 			$user_browser = $_SERVER['HTTP_USER_AGENT'];
//			$user_id = preg_replace("/[^0-9]+/", "", $user_id);
//			$_SESSION['user_id'] = $user_id;
//			$_SESSION['username'] = $username;
//			$_SESSION['login_string'] = hash('sha512', $db_password . $user_browser); // Login successful.
			return true;

		}
			else {
				//TODO: login failed need to implement
				return false;
			}
		return false;

	}

function login_check($conn) {
	if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
		$user_id = $_SESSION['user_id'];
		$login_string = $_SESSION['login_string'];
		$username = $_SESSION['username'];

		$user_browser = $_SERVER['HTTP_USER_AGENT'];


	}
}




	/**
	 * Sanitizes input to make sure it is safe to use
	 * @param  string $input to be sanitized
	 * @return string safe to use input
	 */
	function sanitizeInput($input) {
		$data = trim($input);
		$data = stripslashes($input);
		$data = htmlspecialchars($input);
		return $data;
	}
?>
