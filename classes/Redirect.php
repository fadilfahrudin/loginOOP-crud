<?php

//class untuk me-redirect link page
class Redirect{
    public static function to($lokasi){//methode static dengan parameter lokasi file yang dituju
        header('location:'. $lokasi.'.php');
    }
}

?>