<?php

namespace App\Models;

use CodeIgniter\Model;

class VenueLevelsModel extends Model
{
  protected $table = 'venue_levels';
  protected $allowedFields = ['level_name', 'description', 'active'];
  protected $useTimestamps = true;

  public function getAllVenueLevel()
  {
    $query = "SELECT `vl`.*, COUNT(`v`.`id`) AS 'venue_amount'
    FROM `venue_levels` AS `vl`
    LEFT JOIN `venue` AS `v`
    ON `vl`.`id` = `v`.`level_id`
    GROUP BY `vl`.`id`
    ";
    return $this->db->query($query);
  }
}
