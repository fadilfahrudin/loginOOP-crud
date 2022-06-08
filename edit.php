<?php 
require_once('core/init.php');

if (!$user->is_loggedIn()) {
header('location: login.php');
Session::flash('login', 'Anda harus login');
}

//Ambil data ID yang di kirimkan dari url
$data_user = $user->data(Input::get('id'));
// print_r($data_user);
// die();
if (Input::get('submit')) {
    //Ambil data ID yang dikirimkan dari URL setelah user klik submit
    $data = $user->data(Input::get('id'));

    if(Token::check(Input::get('token'))){
        $validation = new Validation();
        $validation = $validation->cek(array(
                'nama'            => array(
                                    'required' => true,
                                    'min' => 3,
                                    'max' => 25,
                                    ),
                'username'       => array(
                                    'required' => true,
                                    'min' => 3,
                                    'max' => 25,
                ),
                'password'       => array('required' => true),
                'password_baru'  => array(
                                    'required' => true,
                                    'min'      => 3,
                                    ),
                'password_verify'=> array(
                                'required'=> true,
                                'match'   => 'password_baru'),
                'role' => array('required'=> true,)
        ));
        
        if ($user->cek_nama(Input::get('username'))) {
        $errors[] = "username sudah ada";
        }else{

            if ($validation->passed()) {
                if (password_verify(Input::get('password'), $data['password']) ) {

                    $user->update_user(array(
                    'nama' => Input::get('nama'),
                    'role' => Input::get('role'),
                    'username' => Input::get('username'),
                    'password' => password_hash(Input::get('password_baru'), PASSWORD_DEFAULT)
                    ), $data['id']);

                    Session::flash('profile', 'Selamat anda berhasil Ganti Password');
                    Redirect::to('profile');
                }else{
                $errors[] = 'password lama anda salah';
                }
            }else{
            $errors = $validation->errors();
            }
        }
    }
}

require_once('components/header.php');
?>

<div class="container vh-100 d-flex align-items-center">
    <div class="row m-auto">
        <div class="card">
            <div class="card-title mt-5">
                <h5 class="text-center">Ubah Data</h5>
            </div>
            <div class="card-body" style="width: 25rem;">
                <form action="edit.php?id=<?php echo $data_user['id']; ?>" method="POST">
                    <div class="form-group">
                        <label>Nama</label>
                        <input class="form-control" type="text" name="nama" value="<?php echo $data_user['nama']; ?>">
                    </div>

                    <div class="form-group">
                        <select name="role" class="form-control" required>
                            <option>--Pilih--</option>
                            <option value="admin" <?php if($data_user['role'] == 'admin' ) echo "selected"; ?>>Admin
                            </option>
                            <option value="siswa" <?php if($data_user['role'] == 'siswa' ) echo "selected"; ?>>Siswa
                            </option>
                            <option value="guru" <?php if($data_user['role'] == 'guru' ) echo "selected"; ?>>Guru
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" type="text" name="username"
                            value="<?php echo $data_user['username']; ?>">
                    </div>

                    <div class="form-group">
                        <label>Password Lama</label>
                        <input class="form-control" type="password" name="password">
                    </div>

                    <div class="form-group">
                        <label>Password Baru</label>
                        <input class="form-control" type="password" name="password_baru">
                    </div>

                    <div class="form-group">
                        <label>Password Verifikasi</label>
                        <input class="form-control" type="password" name="password_verify">
                    </div>

                    <input type="hidden" name="token" value="<?= Token::generate(); ?>">
                    <input type="submit" name="submit" class="btn btn-block btn-primary" value="Ubah Data">

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
</div>