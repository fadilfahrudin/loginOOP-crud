<?php

class Session{

    //static methode dengan parameter $nama, untuk mengecek bahwa benar ada $nama
    public static function exists($nama){
        //mengembalikan sesi yang di set dengan parameter $nama jika ada maka true, jika tidak maka false
        return (isset($_SESSION[$nama])) ? true : false;
    }

    //static methode untuk me-set data dari parameter nama & nilai
    public static function set($nama, $nilai){
        return $_SESSION[$nama] = $nilai;//mengembalikan sesi nilai

    }

    //methode dapatkan parameter dan disimpan sebagai variabel nama
    public static function get($nama){
        //mengembalikan sessi yang berisi variabel nama
        return $_SESSION[$nama];
    }

    //methode pesan flash
    public static function flash($nama, $pesan = ''){//mengirimkan parameter nama lokasi file dan pesan default nya kosong
        if(self::exists($nama)){//jika methode dari kelas itu sendriri adalah $nama
            $session = self::get($nama);//sesi = dapatkan nama yang di kirim ke parameter exists
            self::delete($nama);//methode hapus sesi dari class itu sendiri
            return $session;//kembalikan sesi
        }else{
            self::set($nama, $pesan);//methode set untuk nama dan pesan
        }
    }
    
    //methode untuk unset 
    public static function delete($nama){
        if(self::exists($nama)){//session di fungsi exists ada, maka
            unset($_SESSION[$nama]);//unset sessi
        }
    } 
}
?>