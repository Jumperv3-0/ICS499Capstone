<?php
	 require_once 'db_config.php';
  require_once 'Objects.php';

  ob_start();
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
  if (Cookie::exists($GLOBALS['config']['remember']['cookie_name']) && !Session::exists($GLOBALS['config']['session']['session_name'])) {
    $hash = Cookie::get($GLOBALS['config']['remember']['cookie_name']);
    $hashCheck = SqlManager::getInstance()->query("SELECT * FROM password_saver WHERE session_id = ?", array($hash));

    if ($hashCheck->getCount()) {
      $user = new User($hashCheck->getResult()[0]->user_fk_id);
      $user->login();
    }
  }
