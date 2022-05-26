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
    $query = "SELECT `f`.*,`a`.`id` AS 'arena_id'
    FROM `facilities` AS `f`
    LEFT JOIN `arena_facilities` AS `af`
    ON `f`.`id` = `af`.`facility_id`
    RIGHT JOIN `arena` as `a`
    ON `a`.`id` = `af`.`arena_id`
    GROUP BY `f`.`id`
    ";
    return $this->db->query($query);
  }
}
