<?php

namespace App\Models;

use CodeIgniter\Model;
// this code is from prac
class User_model extends Model
{
    public function login($username, $password)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('app_accounts');
        $builder->where('username', $username);
        $builder->where('password', $password);   
        $query = $builder->get();
        if ($query->getRowArray()) {
            return true;
        }
        return false;
    }
}