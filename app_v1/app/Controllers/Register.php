<?php

namespace App\Controllers;

class Register extends BaseController

{
    public function index() {
        $data['error'] = "";
        echo view("template/header");
        echo view("register", $data);
        echo view("template/footer");

    }

    public function check_register() {
        $data['errors'] = "";
        $model = model('App\Models\Register_model');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $email = $this->request->getPost('email');
        
        $model = model('App\Models\Register_model');
        
        $check_username = $model-> check_username($username);
        $check_email = $model -> check_email($email);

        if ($check_username) {
            echo view('template/header');
            echo "username must be unique";
            echo view('template/return_register');
            echo view('template/footer');
        } 
        else if(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z]{8,20}$/', $password)){
            echo view('template/header');
            echo "password length must between 8-20 and at least one upper letter or a lower letter, no unique symbol like '!@' support ";
            echo view('template/return_register');
            echo view('template/footer');
        }
        else if($check_email){
            echo view('template/header');
            echo "email must be unique";
            echo view('template/return_register');
            echo view('template/footer');
        }
        else{
            //$res = $model->send_email('qyzyh@foxmail.com','qyzyh@foxmail.com','123'); 
            //var_dump($res);die;
            $session = session();
            $session->set('email',$email);
            $session->set('username',$username);
            $code = $model->generate_email_code($len = 16);
            $session->set('code',$code);
            $send_email = $model->send_email($email,$username,$code); 
            $hash_password = hash('md4',$password);
            $check = $model->register($username, $hash_password,$email);
            echo view('template/header1');
            echo 'wellcome!'.$username;
            echo view('email',$data);
            echo view('template/footer');
        }
    }
    public function check_email_code() {
        $data['errors'] = "";
        $code_input = $this->request->getPost('code');
        $session = session();
        $code = $session->get('code');
        $username = $session->get('username');
        if($code_input == $code) {
            $db = \Config\Database::connect();
            $builder = $db->table('app_accounts');
            $builder->set('email_check',1);
            $builder->where('username',$username);
            $builder->update();
            $session->destroy();
            echo view('template/header1');
            echo 'email verify successfully';
            echo view('template/return_login');
            echo view('template/footer');
        } else{
            $session->destroy();
            echo view('template/header1');
            echo 'your code is not correct, Please login and verify email at the user interface';
            echo view('login');
            echo view('template/footer');
        }
    }

    public function verify_email() {
        $data['error'] ='';
        echo view('template/header');
        echo view('email',$data);
        echo view('template/footer');

    }
    public function add_phone_index(){
        $data['error'] ='';
        echo view('template/header');
        echo view('add_phone',$data);
        echo view('template/footer');

    }
    public function add_phone_action(){
        $db = \Config\Database::connect();
        $builder = $db->table('app_accounts');
        $builder->set('email_check',1);
        $builder->where('username',$username);
        $builder->update();
        echo view('template/header');
        echo 'your phone number has updated successful';
        echo view('template/footer');

    }

}