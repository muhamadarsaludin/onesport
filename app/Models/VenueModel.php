<?php

namespace App\Models;

use CodeIgniter\Model;

class VenueModel extends Model
{
  protected $table = 'venue';
  protected $allowedFields = ['user_id', 'venue_name', 'logo', 'slug', 'level_id',  'rating', 'description', 'active', 'city', 'province', 'postal_code', 'address', 'latitude', 'logitude'];
  protected $useTimestamps = true;


  public function getVenueBySlug($slug)
  {
    # code...
    $query = "SELECT `v`.*,`vl`.`level_name`
    FROM `venue` AS `v`
    JOIN `venue_levels` AS `vl`
    ON `vl`.`id` = `v`.`level_id`
    WHERE `v`.`slug` = '$slug'
    ";
    return $this->db->query($query);
  }
}
