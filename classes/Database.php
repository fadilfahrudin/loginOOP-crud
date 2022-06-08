<?php

class Database {

    private static $INSTANCE = null;
    private $mysqli,
            $HOST = 'localhost',
            $USER = 'root',
            $PASS = '',
            $DB   = 'db_latcrud';

    public function __construct()//methode yang di panggil pertama untuk konek database
    {
        $this->mysqli = new mysqli($this->HOST, $this->USER, $this->PASS, $this->DB);
        if ( mysqli_connect_error( ) ) {
            die ('gagal koneksi');
        }
    }

    // Singleton pattern, menguji agar koneksi tidak double
    public static function getInstance(){
        if (!isset(self::$INSTANCE)) {//jika $INSTANCE dari class itu sendiri tdk ter-sett, maka
            self::$INSTANCE = new Database(); //deklarasikan bahwa $INSTANCE = Class Database __construct
        }

        return self::$INSTANCE;
    }

    public function insert($table, $fields = array()){//methode insert yang menerima $table dan array dari $fields

        //mengambil data kolom yang terisi key dan dismipan pada variabel $colomn
        $colomn = implode(",", array_keys($fields)); // setiap index arrray akan di pisah dengan tanda ","
        

        //logic untuk mengambil data values dan di simpan pada variabel values
        $valuesArrays = array();
        $i = 0;
        foreach($fields as $key => $values){
            if (is_int($values)) {
            $valuesArrays[$i] = $this->escape($values);//menggunakan methode escape yang di dalamnya terisi values
            }else{
            $valuesArrays[$i] = "'" . $this->escape($values) . "'" ;
            $i++; 
            }
        }
        $values = implode(",", $valuesArrays);

        $query = "INSERT INTO $table ($colomn) VALUES ($values)";
        return $this->run_query($query, 'Gagal saat proses input data');//kembalikan ke methode run_query yang terisi $query dan pesan

        //noted: implode merupakan fungsi mengubah array menjadi plain text/kalimat
        // array_keys merupakan fungsi php untuk mengambil key pada index array
    }

    public function delete($table, $id){
        $query =  "DELETE FROM $table where id=$id";
        return $this->run_query($query, 'gagal saat hapus data');
        // print_r($query);
        // die();
    }

    public function get_info($table, $colomn = '', $value = ''){

        if(!is_int($value))
            $value = "'" . $value . "'"; 

        if ($colomn != '') {//jika colomn tidak kosong
            $query = "SELECT * FROM $table WHERE $colomn = $value";
            $result = $this->mysqli->query($query);
            while($row = $result->fetch_assoc()){
                return $row; 
            }
        }else{
            $query = "SELECT * FROM $table";
            $result = $this->mysqli->query($query);
            while($row = $result->fetch_array()){
            $results[] = $row;
            } 
            return $results;
        }
    }
    public function update($table, $fields, $id){
        //mengambil nilai
        $valuesArrays = array();
        $i = 0;
        foreach($fields as $key => $values){
        if (is_int($values)) {
        $valuesArrays[$i] = $key . "=" . $this->escape($values);
        }else{
        $valuesArrays[$i] = $key . "='" . $this->escape($values) . "'" ;
        $i++;
        }
        }
        $values = implode(",", $valuesArrays);

        $query = "UPDATE $table SET $values WHERE id=$id";
        // die($query);
        return $this->run_query($query, 'Masalah saat mengupdate data');
    }
    
    public function run_query($query, $pesan){//menjalankan methode run_query dengan mengambil data $query dan $pesan
        if ($this->mysqli->query($query)) return true;
        else die($pesan);//jika gagal matika script dan jalankan pesan
    }

    public function escape($name){//escape merupakan fungsi sekuritas sederhana untuk mengamankan data yang di input ke database ke web aplikasi
        return $this->mysqli->real_escape_string($name);
    }

} 


?>