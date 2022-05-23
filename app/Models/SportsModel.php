<?php

namespace App\Models;

use CodeIgniter\Model;

class SportsModel extends Model
{
  protected $table = 'sports';
  protected $allowedFields = ['sport_name', 'slug', 'sport_icon', 'description', 'active'];
  protected $useTimestamps = true;


  public function getAllSport()
  {
    $query = "SELECT `s`.*, COUNT(`a`.`id`) AS 'arena_amount'
    FROM `sports` AS `s`
    JOIN `arena` AS `a`
    ON `s`.`id` = `a`.`sport_id`
    ";
    return $this->db->query($query);
  }
  public function getAllSportAvailable()
  {
    $query = "SELECT `s`.*
    FROM `sports` AS `s`
    JOIN `arena` AS `a`
    ON `s`.`id` = `a`.`sport_id`
    WHERE `s`.`active` = 1
    ";
    return $this->db->query($query);
  }
}
