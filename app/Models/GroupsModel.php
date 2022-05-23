<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupsModel extends Model
{
  protected $table = 'auth_groups';
  protected $allowedFields = ['name', 'description'];

  public function getAllGroup()
  {
    $query = "SELECT `ag`.*, COUNT(`agu`.`group_id`) AS 'user_amount'
    FROM `auth_groups` AS `ag`
    LEFT JOIN `auth_groups_users` AS `agu`
    ON `ag`.`id` = `agu`.`group_id`
    GROUP BY `ag`.`id`
    ";
    return $this->db->query($query);
  }
}
