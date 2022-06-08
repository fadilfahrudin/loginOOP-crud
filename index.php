<?php
require_once('core/init.php');

if (!$user->is_loggedIn()) {
Redirect::to('login');
}

Redirect::to('profile');//redirect ke profile

?>