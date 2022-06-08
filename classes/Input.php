<?php

//class input
class Input{
    //jika static function bisa di panggil menggunakan self::
    public static function get($nama){//$nama merupakan variabel sementara yang nanti akan di isi ketika fungtion get() dipanggil
        if (isset($_POST[$nama])) {//jika $post yang berisi variabel terisi maka jalankan..
            return $_POST[$nama];
        }else if(isset($_GET[$nama])) {
        return $_GET[$nama];
        }

        return false;
    }
}

?>