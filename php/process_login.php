<?php
	require_once 'db_connection.php';

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
?>
