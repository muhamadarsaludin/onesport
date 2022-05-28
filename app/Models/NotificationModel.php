<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notification';
    protected $useTimestamps = true;
    protected $allowedFields = ['user_id','message','link'];
    

    public function getTheLatestNotifications($userId)
    {
        $query = "SELECT `n`.*
        FROM `notification` AS `n`
        WHERE `n`.`user_id` = $userId
        ORDER BY `created_at` DESC
        LIMIT 5
        ";
        return $this->db->query($query);
    }

}
