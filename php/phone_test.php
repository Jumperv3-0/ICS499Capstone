<?php
require_once 'init.php';
require_once 'Objects.php';
$user = new User();
if (!$user->isLoggedIn()) {
  Redirect::page('404.php');
}

//$phone = new Phone();
//try {
//	$phone->create(array("(123)-456-7891"));
//} catch (Exception $e) {
//	var_dump($e);
//}
//var_dump($phone);

var_dump($user->data()->user_id);
//var_dump(Phone::formatNumber(sanitizeInput("(123)-456-7891")));
