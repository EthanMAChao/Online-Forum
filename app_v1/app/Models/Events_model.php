<?php

namespace App\Models;

use CodeIgniter\Model;
class Events extends Model
{

    public function events($month, $day, $title, $detail, $uid) {
        $event = [
            'month' => $month,
            'day' => $day,
            'title' => $title,
            'detail' => $detail,
            'uid' => $uid,
        ];
        $db = \Config\Database::connect();
        $builder = $db->table('events');
        if ($builder->insert($event)) {
            return true;
        } else {
            return false;
        }

    }

}