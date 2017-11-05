<?php
  require_once 'init.php';
  require_once 'Objects.php';

  $user = new User();
  $user->logout();
  Session::flash('logout', 'You have been logged out!');
  Redirect::page('index.php');
?>
