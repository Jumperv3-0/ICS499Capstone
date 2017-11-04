<?php

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

	function formatDates() {
		$string = '';
		for($i = 0; $i < count($_POST['date']); $i++) {
			$string .= sanitizeInput($_POST['date'][$i]) . sanitizeInput($_POST['startTime'][$i]) . sanitizeInput($_POST['endTime'][$i]);
		}
		return $string;
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

