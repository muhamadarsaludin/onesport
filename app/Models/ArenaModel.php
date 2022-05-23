<?php

namespace App\Models;

use CodeIgniter\Model;

class ArenaModel extends Model
{
  protected $table = 'arena';
  protected $allowedFields = ['venue_id', 'sport_id', 'arena_name', 'slug', 'arena_image', 'rating', 'description', 'active'];
  protected $useTimestamps = true;


  public function getAllArena()
  {
    $query = "SELECT `a`.*,`s`.`sport_name`,`v`.`venue_name`,`v`.`logo`,`v`.`city`,`v`.`province`,`v`.`postal_code`,`v`.`address`,`vl`.`level_name`
    FROM `arena` AS `a`
    JOIN `sports` AS `s`
    ON `a`.`sport_id` = `s`.`id`
    JOIN `venue` AS `v`
    ON `v`.`id` = `a`.`venue_id`
    JOIN `venue_levels` AS `vl`
    ON `vl`.`id` = `v`.`level_id`
    ";
    return $this->db->query($query);
  }



  public function getArenaBySlug($slug)
  {
    $query = "SELECT `a`.*,`s`.`sport_name`,`v`.`slug` as `venue_slug`,`v`.`venue_name`,`v`.`logo`,`v`.`city`,`v`.`province`,`v`.`postal_code`,`v`.`address`,`vl`.`level_name`
    FROM `arena` AS `a`
    JOIN `sports` AS `s`
    ON `a`.`sport_id` = `s`.`id`
    JOIN `venue` AS `v`
    ON `v`.`id` = `a`.`venue_id`
    JOIN `venue_levels` AS `vl`
    ON `vl`.`id` = `v`.`level_id`
    WHERE `a`.`slug` = '$slug'
    ";
    return $this->db->query($query);
  }
  public function getArenaById($id)
  {
    $query = "SELECT `a`.*,`s`.`sport_name`,`v`.`slug` as `venue_slug`,`v`.`venue_name`,`v`.`logo`,`v`.`city`,`v`.`province`,`v`.`postal_code`,`v`.`address`,`vl`.`level_name`
    FROM `arena` AS `a`
    JOIN `sports` AS `s`
    ON `a`.`sport_id` = `s`.`id`
    JOIN `venue` AS `v`
    ON `v`.`id` = `a`.`venue_id`
    JOIN `venue_levels` AS `vl`
    ON `vl`.`id` = `v`.`level_id`
    WHERE `a`.`id` = $id
    ";
    return $this->db->query($query);
  }

  public function getArenaByVenueSlug($venueSlug)
  {
    $query = "SELECT `a`.*,`s`.`sport_name`,`v`.`slug` as `venue_slug`,`v`.`venue_name`,`v`.`logo`,`v`.`city`,`v`.`province`,`v`.`postal_code`,`v`.`address`,`vl`.`level_name`
    FROM `arena` AS `a`
    JOIN `sports` AS `s`
    ON `a`.`sport_id` = `s`.`id`
    JOIN `venue` AS `v`
    ON `v`.`id` = `a`.`venue_id`
    JOIN `venue_levels` AS `vl`
    ON `vl`.`id` = `v`.`level_id`
    WHERE `v`.`slug` = '$venueSlug'
    ";
    return $this->db->query($query);
  }


  public function getArenaBySportId($id)
  {
    $query = "SELECT `a`.*,`s`.`sport_name`,`v`.`slug` as `venue_slug`,`v`.`venue_name`,`v`.`logo`,`v`.`city`,`v`.`province`,`v`.`postal_code`,`v`.`address`,`vl`.`level_name`
    FROM `arena` AS `a`
    JOIN `sports` AS `s`
    ON `a`.`sport_id` = `s`.`id`
    JOIN `venue` AS `v`
    ON `v`.`id` = `a`.`venue_id`
    JOIN `venue_levels` AS `vl`
    ON `vl`.`id` = `v`.`level_id`
    WHERE `s`.`id` = $id
    ";
    return $this->db->query($query);
  }
}
