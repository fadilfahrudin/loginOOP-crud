<?php
require_once('core/init.php');

if (!$user->is_loggedIn()) {
    Redirect::to('login');
}

if(Session::exists('profile')){
    echo Session::flash('profile');
}

if(Input::get('nama')){
    $user_data = $user->get_data(Input::get('nama'));
}else{
    $user_data = $user->get_data(Session::get('username'));
    // die($user_data);
}

require_once('components/header.php');
require_once('components/navbar.php');

?>

<h2>selamat datang <?php echo $user_data['nama'];  ?> </h2>

<?php require_once('components/footer.php') ?>