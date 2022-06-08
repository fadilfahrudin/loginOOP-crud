<?php
require_once('core/init.php');

//function mengecek apakah sudah login
if ($user->is_loggedIn()) {
    Redirect::to('profile');//static fungsi untuk redirect ke halaman dengan parameter profile
}

//Fungsi jika sesi ada(login)
if(Session::exists('login')){
echo Session::flash('login');//tampilkan pesan dari sesi login
}

//variabel error
$error = array();

//logic submit button
if (Input::get('submit')){

    // 1. Mengecek Token pada form
    if(Token::check(Input::get('token'))){

        //2. mengambil objek Validation
        $validation = new Validation();

        //3. Menjalankan Metode cek
        $validation = $validation->cek(array(
            'username' => array('required' => true),
            'password' => array('required' => true)
        ));
        
        // 4. Lulus atau tidak
        if ($validation->passed()) {
            if ($user->cek_nama(Input::get('username'))) {
            if ($user->login_user( Input::get('username'), Input::get('password') )) {
                    Session::set('username', Input::get('username'));
                    Redirect::to('profile');
                }else{
                $erros[] = "login gagal";
                }
            }else{
            $erros[] = "Nama tidak di temukan";
            }
        }else{
        $erros = $validation->errors();
        }
    }//end of token
}//end of input submit

require_once('components/header.php')
?>

<div class="container d-flex vh-100">
    <div class="row m-auto align-items-center">
        <div class="card py-3">
            <div class="card-title">
                <h5 class="text-center">Hello World</h5>
            </div>
            <div class="card-body">
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username">
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password"><br>
                    </div>

                    <input type="hidden" name="token" value="<?= Token::generate(); ?>">
                    <input type="submit" name="submit" class="btn btn-block btn-primary" value="Login Sekarang">

                    <div class="text-center mt-4">
                        <p>Sudah Daftar?<a href="register.php">Daftar Sekarang!</a></p>
                    </div>
                    <!-- Logic Error -->
                    <?php if (!empty($erros)) {?>
                    <div id="error">
                        <?php foreach($erros as $error) {?>
                        <li><?= $error; ?></li>
                        <?php } ?>
                    </div>
                    <?php } ?>

                </form>

            </div>
        </div>
    </div>
</div>