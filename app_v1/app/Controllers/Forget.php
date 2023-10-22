<?php

namespace App\Controllers;

class Forget extends BaseController
{
    // forget password
    public function index()
    {
        $data['error'] ='';
        echo view('template/header');
        echo view('forget_password',$data);
        echo view("template/footer");

    }
    //after users input email,check email, if registered, go next 
    //else return 'forget_password'
    public function email_action() {
        $email = $this->request->getPost('email');
        $model = model('App\Models\Register_model');
        $code = $model->generate_email_code($len = 16);
        $check_email = $model -> check_email($email);
        if($check_email) {
        $session = session();
        $session->set('code',$code);
        $session->set('email',$email);
        $username = 'dear user';
        $send_email = $model->send_email($email,$username,$code); 

        $data['error'] ='';
        echo view('template/header1');
        echo view('forget_password_email',$data);
        echo view('template/footer');
        } else {
            echo view('template/header1');
            echo 'your email is not registered, please check email before next step';
            echo view('forget_password');
            echo view('template/footer');

        }
        


    }

    // load input code inteface
    public function email_check_index() {
        $data['error'] = '';
        echo view('template/header1');
        echo view('forget_password_email',$data);
        echo view('template/footer');
        
    }

    // check users input and system sending's code
    // if sucess return,else return to 'login'
    public function email_check() {
        $data['error'] = '';
        $session = session();
        $email = $session->get('email');
        $code = $session->get('code');
        $code_input = $this->request->getPost('code');
        if($code_input==$code) {
            echo view('template/header1');
            echo view('new_password',$data);
            echo view('template/footer');
        } else {
            $session = session();
            $session->destroy();
            echo view('template/header');
            echo 'plz re-click forget password';
            echo view('login',$data);
            echo view("template/footer");
        }


    }

    public function new_password_index() {
        $data['error'] = '';
        echo view('template/header');
        echo view('new_password',$data);
        echo view('template/footer');

    }

    public function new_password() {
        $data['error'] = '';
        $password = $this->request->getPost('password');
        $model = model('App\Models\Register_model');
        $session = session();
        $email = $session->get('email');
        $session->destroy();
        if(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z]{8,20}$/', $password)) { 
            echo view('template/header');
            echo 'password must between 8-20 and have 1 upletter and 1 lowletter';
            echo '<br>';
            echo 'password must only combined with digit and letters ';
            echo view('new_password');
            echo view('template/footer'); 
        } else{
            $db = \Config\Database::connect();
            $builder = $db->table('app_accounts');
            $hash_password = hash('md4',$password);
            $builder->set('password',$hash_password);
            $builder->where('email',$email);
            $builder->update();
            echo 'your password has been updated successful';
            echo view('template/header');
            echo view('template/return_login');
            echo view('template/footer');
        }
    
    }

}