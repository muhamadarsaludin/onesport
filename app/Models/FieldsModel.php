<?php

namespace App\Models;

use CodeIgniter\Model;

class FieldsModel extends Model
{
  protected $table = 'fields';
  protected $allowedFields = ['arena_id', 'field_name', 'slug', 'field_image', 'rating', 'amount_order', 'description', 'active'];
  protected $useTimestamps = true;


  public function getFields()
  {
    $query = "SELECT `f`.*, `v`.venue_name
    FROM `fields` AS `f`
    JOIN `arena` AS `a`
    ON `a`.`id` = `f`.`arena_id`
    JOIN `venue` AS `v`
    ON `v`.`id` = `a`.`venue_id`";
    return $this->db->query($query);
  }

  public function getFieldsByVenueid($venueId)
  {
    $query = "SELECT `f`.*
    FROM `fields` AS `f`
    JOIN `arena` AS `a`
    ON `a`.`id` = `f`.`arena_id`
    JOIN `venue` AS `v`
    ON `v`.`id` = `a`.`venue_id`
    WHERE `v`.`id` = $venueId
    ";
    return $this->db->query($query);
  }
}
