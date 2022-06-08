<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="profile.php">Home</a>
            </li>
            <?php
                //  if( Session::exists('username') ) 
                if($user->is_admin(Session::get('username')))
                { ?>
            <li class="nav-item">
                <a class="nav-link" href="user.php">User</a>
            </li>
            <?php }elseif($user->is_siswa(Session::get('username'))) {?>
            <li class="nav-item">
                <a class="nav-link" href="siswa.php">Siswa</a>
            </li>
            <?php } elseif($user->is_guru(Session::get('username'))) {?>
            <li class="nav-item">
                <a class="nav-link" href="guru.php">Guru</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="siswa.php">Siswa</a>
            </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>
</header>