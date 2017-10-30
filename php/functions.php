<?php

	/**
	 *
	 * @param  string $username submited by user
	 * @param  string $password submited by user
	 * @param  PDO $conn     PDO connection to database
	 * @return boolean  true if login attempt was succesful, else false.

	function login($username, $password, $conn) {
		$sql = "SELECT password FROM users WHERE username = :username"; // sql statement
		$statement = $conn->prepare($sql); // preparing statement
		$statement->execute(array(':username'=> $username)); // linking $username param to  :username in $sql statement and exicuting sql quary
		$result =  $statement->fetch(); // result of sql command

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
	}*/

	function sec_session_start() {
			$session_name = 'sec_session_id';   // Set a custom session name
			$secure = SECURE;
			// This stops JavaScript being able to access the session id.
			$httponly = true;
			// Forces sessions to only use cookies.
			if (ini_set('session.use_only_cookies', 1) === FALSE) {
					header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
					exit();
			}
			// Gets current cookies params.
			$cookieParams = session_get_cookie_params();
			session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
			// Sets the session name to the one set above.
			session_name($session_name);
			session_start();            // Start the PHP session
			session_regenerate_id();    // regenerated the session, delete the old one.
	}

	function login ($username, $password, PDO $db_connection) {
		try {
			$sql = "SELECT user_id, username, password FROM users WHERE username = :username"; // sql statement
			if ($stmt = $db_connection->prepare($sql)) {  // preparing statement
				$stmt->execute(array(':username'=> $username)); // linking $username param to  :username in $sql statement and exicuting sql quary
				$result = $stmt->fetchAll();
				if (count($result) == 1) {
					$user_id = $result[0]['user_id'];
					if (checkbrute($user_id, $db_connection) == true) {
						return false;
					} else {
						if (password_verify($password, $result[0]['password'])) {
							$user_browser = $_SERVER['HTTP_USER_AGENT'];
							// XSS protection as we might print this value
							$user_id = preg_replace("/[^0-9]+/", "", $user_id);
							$_SESSION['user_id'] = $user_id;
							// XSS protection as we might print this value
							$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
							$_SESSION['username'] = $username;
							$_SESSION['login_string'] = hash('sha512', $db_password . $user_browser);
							// Login successful.
							return true;
						} else {
							// Password is not correct
							// We record this attempt in the database
							$sql = "INSERT INTO login_attempts (attempt_id, user_fk_id, attempt_success, session_id, time_stamp) VALUES (NULL, ?, ?, ?, CURRENT_TIMESTAMP)";
							$stmt = $conn->prepare($sql);
							$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
							$stmt->bindParam(2, 0, PDO::PARAM_INT);
							$stmt->bindParam(3, $_SESSION['login_string'], PDO::PARAM_STR);
							$stmt->execute();
							return false;
						}
					}
				} else {
					// No user exists
					return false;
				}
			}
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}

	function checkbrute($user_id, $db_connection) {
			// Get timestamp of current time
			$now = time();

			// All login attempts are counted from the past 2 hours.
			$valid_attempts = $now - (2 * 60 * 60);

		$sql = "SELECT * FROM users;"; // sql statement
			$statement = $conn->prepare($sql); // preparing statement
			//$statement->execute(array(':username'=> $username)); // linking $username param to  :username in $sql statement and exicuting sql quary
			$statement->execute();
			$result =  $statement->fetchAll(); // result of sql command

			if ($stmt = $db_connection->prepare("SELECT time
															 FROM login_attempts
															 WHERE user_id = ?
															AND time > '$valid_attempts'")) {
					$stmt->bind_param('i', $user_id);

					// Execute the prepared query.
					$stmt->execute();
					$stmt->store_result();

					// If there have been more than 5 failed logins
					if ($stmt->num_rows > 5) {
							return true;
					} else {
							return false;
					}
			}
	}


	/**
	 *
	 * @param [[Type]] $conn [[Description]]
	 */
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
		if (is_array($input)) {
			for($i = 0; $i < count($input); $i++) {
				$data = $input[$i];
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				$input[$i] = $data;
			}
			return $input;
		} else {
			$data = $input;
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
	}
?>
