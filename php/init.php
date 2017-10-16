<?php
	require_once 'db_config.php';
    session_start();
    session_regenerate_id();
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
