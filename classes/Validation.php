<?php

class Validation{

    private $_passed = false,
            $_errors = array();

    function cek($items = array()){
        foreach($items as $item => $rules){
            foreach ($rules as $rule => $rule_value) {
                switch ($rule) {
                    case 'required':
                        if (trim(Input::get($item)) == false && $rule_value == true) {
                            $this->adderror("$item Wajib diisi");
                        }
                        break;
                    case 'min':
                        if (strlen(Input::get($item)) < $rule_value ) {
                            $this->adderror("$item minimal diisi $rule_value karakter");
                        }
                        break;
                    case 'max':
                        if (strlen(Input::get($item)) > $rule_value ) { 
                            $this->adderror("$item maksimal diisi $rule_value karakter");
                        }
                        break;
                    case 'match':
                        if (Input::get($item) != Input::get($rule_value)) {
                        $this->adderror("$item pastikan sama denga $rule_value");
                        }
                        break;
                    
                    default:
                        break;
                }
            }
        }//END FIRS FOREACH
            if (empty($this->_errors)) {//jika ga ada error
                $this->_passed = true;//maka passed menjadi true
            } 
        return $this;
    }

    //menambahkan fungsi error jika data yg di input tdk sesuai
    private function adderror($error){
        $this->_errors[] = $error;
    }

    //menegmbalikan nilai variabel errors dalam bentuk array
    public function errors(){
        return $this->_errors;
    }

    //passed mengembalikan nilai false
    public function passed(){
        return $this->_passed;
    }
}

?>