<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Email\Email;
//methods from :https://codeigniter.com/user_guide/database/query_builder.html
class Register extends Model
{ 
    public $email_code_ver;
    public function check_username($username) {
        $db = \Config\Database::connect();
        $builder = $db->table('app_accounts');
        $unique_username = $builder->getWhere(['username'=>$username]);
        return $unique_username->getNumRows() >0;
    }
    public function check_email($email) {
        $db = \Config\Database::connect();
        $builder = $db->table('app_accounts');
        $unique_email = $builder->getWhere(['email'=>$email]); 
        return $unique_email ->getNumRows() >0;
    }
    public function register($username, $password, $email)
    {
        $user = [
            'username' => $username,
            'password' => $password,
            'email' => $email,
        ];
        $db = \Config\Database::connect();
        $builder = $db->table('app_accounts');
        if ($builder->insert($user)) {
            return true;
        } else {
            return false;
        }
    }


    public function generate_email_code($len = 16) {
        $str = md5(rand());
        $email_code_ver = substr($str,0,$len);
        return $email_code_ver;
    }

    // This code is from lecture week 6
    public function send_email($to_email, $username, $code) {
        helper(['form']);
        $email = new Email();
        $emailConf = [
            'protocol' => 'smtp',
            'wordWrap' => true,
            'SMTPHost' => 'mailhub.eait.uq.edu.au',
            'SMTPPort' => 25
        ];
        $email -> initialize($emailConf);
        $email->setTo($to_email);
        $email->setFrom('chao.ma2@uqconnect.edu.au');
        $subject = 'this is verification code';
        $email->setSubject($subject);
        $email->setMessage($code);

        if(!$email->send()) {
            echo'plz try anagin';
        }

        
    }

    public function insertFiles($file_name,$uploaded_on,$account_id) {
        $file = [
            'file_name' => $file_name,
            'uploaded_on' =>$uploaded_on,
            'account_id' => $uploaded_on

        ];
        $db = \Config\Database::connect();
        $builder = $db->table('files');
        if ($builder->insert($file)) {
            return true;
        } else {
            return false;
        }}}