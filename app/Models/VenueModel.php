<?php

namespace App\Models;

use CodeIgniter\Model;

class VenueModel extends Model
{
  protected $table = 'venue';
  protected $allowedFields = ['user_id', 'venue_name', 'contact', 'logo', 'slug', 'level_id',  'rating', 'description', 'active', 'city', 'province', 'postal_code', 'address', 'latitude', 'longitude'];
  protected $useTimestamps = true;


  public function getAllVenue()
  { 
    $query = "SELECT `v`.*,`vl`.`level_name`, `u`.`username`
    FROM `venue` AS `v`
    JOIN `venue_levels` AS `vl`
    ON `vl`.`id` = `v`.`level_id`
    JOIN `users` AS `u`
    ON `u`.`id` = `v`.`user_id`
    ";
    return $this->db->query($query);
  }

  public function getVenueBySlug($slug)
  {
    $query = "SELECT `v`.*,`vl`.`level_name`
    FROM `venue` AS `v`
    JOIN `venue_levels` AS `vl`
    ON `vl`.`id` = `v`.`level_id`
    WHERE `v`.`slug` = '$slug'
    ";
    return $this->db->query($query);
  }
}
