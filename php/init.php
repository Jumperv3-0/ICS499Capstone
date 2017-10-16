<?php
	require_once 'db_config.php';
	$GLOBALS['config'] = array(
        'remember' => array(
            'cookie_name' => 'hash',
            'cookie_expire' => 604800
        ),
        'session' => array(
            'session_name' => 'user',
            'token_name' => 'token'
        )
    );
//    $session_name = 'user'; // Set a custom session name
//	$secure = SECURE;
//	$httpOnly = true;
//
//	if (ini_set('session.use_only_cookies', 1) === FALSE) {
//		header("Location: 404.php?error=Please enable cookies");
//		exit();
//	}
//	$cookieParams = session_get_cookie_params();
//	session_set_cookie_params($cookieParams['lifetime'], $cookieParams['path'], $cookieParams['domain'], $secure, $httpOnly);
//	session_name($session_name);
	session_start();
//	session_regenerate_id();
