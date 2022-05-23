<?php

namespace App\Models;

use CodeIgniter\Model;

class FacilitiesModel extends Model
{
  protected $table = 'facilities';
  protected $allowedFields = ['facility_name', 'icon', 'description', 'active'];
  protected $useTimestamps = true;

  public function getArenaFacilitiesByArenaId($id)
  {
    $query = "SELECT `f`.*, IF(`af`.`id`, 1 ,0 ) as `served`
    FROM `facilities` AS `f`
    LEFT JOIN `arena_facilities` AS `af`
    ON `f`.`id` = `af`.`facility_id`
    LEFT JOIN `arena` as `a`
    ON `a`.`id` = `af`.`arena_id`
    WHERE `a`.`id` = $id OR `a`.`id` IS NULL
    ";
    return $this->db->query($query);
  }
}
