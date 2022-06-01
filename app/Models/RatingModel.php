<?php

namespace App\Models;

use CodeIgniter\Model;

class RatingModel extends Model
{
  protected $table = 'rating';
  protected $allowedFields = ['transaction_id', 'user_id', 'field_id','venue_id','rating','review'];
  protected $useTimestamps = true;


  public function getRatingVenue()
  {
    $query = "SELECT AVG (`r`.`rating`) AS `rating_value`, COUNT(`v`.`id`) AS `amount_rating`, `v`.`id` AS `venue_id`
      FROM `rating` AS `r`
      JOIN `venue` AS `v`
      ON `v`.`id` = `r`.`venue_id`
      GROUP BY `v`.`id`
      ";
      return $this->db->query($query);
  }
  public function getRatingField()
  {
    $query = "SELECT AVG (`r`.`rating`) AS `rating_value`, COUNT(`f`.`id`) AS `amount_rating`, `f`.`id` AS `field_id`
      FROM `rating` AS `r`
      JOIN `fields` AS `f`
      ON `f`.`id` = `r`.`field_id`
      GROUP BY `f`.`id`
      ";
      return $this->db->query($query);
  }
  public function getRatingByFieldId($fieldId)
  {
    $query = "SELECT AVG (`r`.`rating`) AS `rating_value`, COUNT(`f`.`id`) AS `amount_rating`, `f`.`id` AS `field_id`
      FROM `rating` AS `r`
      JOIN `fields` AS `f`
      ON `f`.`id` = `r`.`field_id`
      WHERE `f`.`id` = $fieldId
      GROUP BY `f`.`id`
      ";
      return $this->db->query($query);
  }
  public function getListRatingByFieldId($fieldId)
  {
    $query = "SELECT `r`.*,`u`.`username`,`u`.`user_image`
      FROM `rating` AS `r`
      JOIN `fields` AS `f`
      ON `f`.`id` = `r`.`field_id`
      JOIN `users` AS `u`
      ON `u`.`id` = `r`.`user_id`
      WHERE `f`.`id` = $fieldId
      ";
      return $this->db->query($query);
  }
}
