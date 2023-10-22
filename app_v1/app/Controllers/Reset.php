<?php

namespace App\Controllers;

class Reset extends BaseController
{

    public function index() {
        $data['error'] = '';
        echo view('template/header');
        echo view('reset_password',$data);
        echo view('template/footer');
    }
}