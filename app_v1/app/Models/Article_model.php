<?php

namespace App\Models;

use CodeIgniter\Model;
class article extends Model
{
    public function insertArticle($title, $content, $uid) {
        $article = [
            'title' => $title,
            'content' => $content,
            'uid' => $uid,
        ];
        $db = \Config\Database::connect();
        $builder = $db->table('articles');
        if ($builder->insert($article)) {
            return true;
        } else {
            return false;
        }

    }

    public function insertComments($comment, $uid, $qid) {
        $comment = [
            'comment' => $comment,
            'uid' => $uid,
            'qid' => $qid,
        ];
        $db = \Config\Database::connect();
        $builder = $db->table('comments');
        if ($builder->insert($comment)) {
            return true;
        } else {
            return false;
        }

    }

}