<?php
class User{
    private $_db;//variabel private berfungsi di dalam class ini saja dan tdk berfungsi di kelas turunannya maupun diluar kelas

    public function __construct()//akan dijalankan terlebih dahulu
    {
        $this->_db = Database::getInstance();//deklarasikan bahwa $_db = methode static getInstance() yang ada di dalam class Database
    }

    public function register_user($fields = array()){//isi dari $fields merupakan array() yang dikirim dari  methode Get pada class Input
        if ($this->_db->insert('admin', $fields)) return true; //panggil methode insert yang sudah terisi nama tabel dan array dari variabel $fields pada class database
        else return false;
    }

    public function delete_user($id){
        if ($this->_db->delete('admin', $id )) return true;
        else return false;
    }

    public function login_user($username, $password){
    
        $data = $this->_db->get_info('admin', 'username', $username);
        // print_r($data);//debuging
        // die();//debuging
        if (password_verify($password, $data['password'])) 
            return true;
        else false;
    }

    public function cek_id($id){
        $data = $this->_db->get_info('admin', 'id', $id);
        // print_r($data);
        // die();
        if(empty($data)) return false;
        return true;
    }

    public function cek_nama($username){
        $data = $this->_db->get_info('admin', 'username', $username);
        if(empty($data)) return false;
        return true;
    }

    public function is_admin($username){
        $data = $this->_db->get_info('admin', 'username', $username);
        if($data['role'] ==  'admin') return true;
        return false;
    }

    public function is_guru($username){
        $data = $this->_db->get_info('admin', 'username', $username);
        if($data['role'] == 'guru') return true;
        return false;
    }

    public function is_siswa($username){
        $data = $this->_db->get_info('admin', 'username', $username);
        if($data['role'] == 'siswa') return true;
        return false;
    }

    //methode memasitikan kalau sudah login
    public function is_loggedIn(){
        //jika sesi username ada, maka benar
        if(Session::exists('username')) return true;
        return false;
    }

    public function get_data($username){
        if($this->cek_nama($username))
            return  $this->_db->get_info('admin', 'username', $username);
        else
        return false;
    }

    public function update_user($fields = array(), $id){
        if($this->_db->update('admin', $fields, $id )) 
        // print_r($data);
        // die();
        return true;
        else return false;
    }

    public function tampil_data(){
        // print_r($this->_db->get_info('admin'));
        // die(); 
        // debbuging dengan methode print_r
        return $this->_db->get_info('admin');
    }

    public function data($id){
        // print_r($id);
        // die();
        if($this->cek_id($id))
            return $this->_db->get_info('admin', 'id', $id);
        else
        return false;
    }
}
?>