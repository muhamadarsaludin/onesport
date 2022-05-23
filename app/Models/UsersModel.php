<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
  protected $table = 'users';
  protected $allowedFields = ['email', 'username', 'password_hash', 'user_image',  'active'];
  protected $useTimestamps = true;


  public function getUserById($id)
  {
    $query = "SELECT `u`.`id`,`u`.`user_image`,`u`.`username`,`u`.`email`,`u`.`active`,`ag`.`id` as `role_id`,`ag`.`name` as `role_name`
        FROM `users` AS `u`
        JOIN `auth_groups_users` AS `agu`
        ON `agu`.`user_id` = `u`.`id`
        JOIN `auth_groups` AS `ag`
        ON `ag`.`id` = `agu`.`group_id`
        WHERE `u`.`id` = $id
    ";
    return $this->db->query($query);
  }
}
