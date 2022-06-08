<?php

require_once('core/init.php');
//menjalankan class Input dengan static function get yang didalamnya terdapat variabel submit yang di kirim dari btn denganname=submit

if (!$user->is_loggedIn()) {
    Redirect::to('login');
}

$erros = array();
if (Input::get('submit')) {
   //jika sudah di klik btn dengan name=submit maka jalankan methode register_user yang ada di class user dengan metode array

    if(Token::check(Input::get('token'))){
    //1. memanggil obj validasi
            $validation = new Validation();

            //2. metode cek
            $validation = $validation->cek(array(
            'nama' => array(
                    'required' => true,
                    'min' => 3,
                    'max' => 25,
                    ),
            'username' => array(
                    'required' => true,
                    'min' => 3,
                    'max' => 25,
                    ),
            'password' => array(
                    'required' => true,
                    'min' => 3,
                    'max' => 25,
                    ),
            'password_verify' => array(
                    'required' => true,
                    'match' => 'password'
            ),
            'role' => array()
        ));

        if ($user->cek_nama(Input::get('username'))) {
            $errors[] = "username sudah ada";
        }else{
                //3. lolos uji atau tidak
                if ($validation->passed()) {
                    $user->register_user(array(
                        'nama' => Input::get('nama'),//ambil key nama di dalam methode get yang berisi values nama
                        'username' => Input::get('username'),//password_hash merupakan fitur php untuk meng enskripsi password ketikadi input
                        'password' => password_hash(Input::get('password'), PASSWORD_DEFAULT),
                        'role' => Input::get('role')
                    ));


                    Session::flash('profile', 'Selamat data berhasil di daftarkan');
                    Session::set('username', Input::get('username'));
                    Redirect::to('profile');
                }else{
                    $erros = ($validation->errors());
                }
            }
    }//end of token
}//end of submit
require_once('components/header.php');
require_once('components/navbar.php');

?>


<div class="container d-flex">
    <div class="row m-auto">
        <div class="card p-3" style="width: 25rem;">
            <div class="card-title">
                <h5 class="text-center">Tambah User Baru</h5>
                <hr>
            </div>

            <form action="register.php" method="post">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" name="nama" required>
                </div>

                <div class="form-group">
                    <select name="role" class="form-control" required>
                        <option selected>--Pilih--</option>
                        <option value="admin">Admin</option>
                        <option value="siswa">Siswa</option>
                        <option value="guru">Guru</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <div class="form-group">
                    <label>Ulangi Password</label>
                    <input type="password" class="form-control" name="password_verify" required>
                </div>

                <div class="form-group">
                    <input type="hidden" name="token" value="<?=  Token::generate(); ?>">
                    <input type="submit" name="submit" class="btn btn-block btn-primary" value="Daftar Sekarang">
                </div>
                <?php if (!empty($errors)) {?>
                <div id="error">
                    <?php foreach($errors as $error) {?>
                    <li><?= $error; ?></li>
                    <?php } ?>
                </div>
                <?php } ?>

            </form>

        </div>
    </div>
</div>