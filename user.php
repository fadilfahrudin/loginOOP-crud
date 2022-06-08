<?php
require_once('core/init.php');

if (!$user->is_loggedIn()) {
    Redirect::to('login');
}
    $user_data = $user->get_data(Session::get('username'));

if (Input::get('submit')) {
        $id = Input::get('id');
        $user->delete_user($id);
        '<script>alert("Data berhasil di hapus"); window.location = "user.php"</script>';
        // print_r($d);
        // die();
}

if (Input::get('edit')) {

        $id = Input::get('id');
        header('location: edit.php?'.'id='. $id);
// <!-- // print_r($id);
// // die(); -->

} 


require_once('components/header.php');
require_once('components/navbar.php');
?>

<h1>Hello User <?php echo $user_data['nama'] ?></h1>

<div class="container">

    <Table class="table">
        <a href="register.php">Tambah User</a>

        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Username</th>
                <th scope="col">Role</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            
            $no = 1;
            foreach($user->tampil_data() as $tampil){
                ?>
            <form action="user.php?id=<?= $tampil['id'] ?>" method="POST">

                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $tampil['nama'] ?></td>
                    <td><?= $tampil['username'] ?></td>
                    <td><?= $tampil['role'] ?></td>
                    <td>
                        <input type="submit" name="edit" value="Edit Data">
                        <input type="submit" name="submit" value="Delete"
                            onclick="return confirm('Yakin ingin menghapus data user yang bernama <?= $tampil['nama'] ?>?');">
                    </td>
                </tr>
            </form>

            <?php }?>
        </tbody>
    </Table>
</div>