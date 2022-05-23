<?php

namespace App\Models;

use CodeIgniter\Model;

class SpecificationsModel extends Model
{
  protected $table = 'specifications';
  protected $allowedFields = ['sport_id', 'spec_name', 'description', 'active'];
  protected $useTimestamps = true;


  public function getAllSpec()
  {
    $query = "SELECT `sp`.*, `s`.`sport_name`
    FROM `specifications` AS `sp`
    JOIN `sports` AS `s`
    ON `s`.`id` = `sp`.`sport_id`
    ";
    return $this->db->query($query);
  }

}
