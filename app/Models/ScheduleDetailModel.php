<?php

namespace App\Models;

use CodeIgniter\Model;

class ScheduleDetailModel extends Model
{
  protected $table = 'schedule_detail';
  protected $allowedFields = ['schedule_id', 'start_time', 'end_time', 'active', 'price'];
  protected $useTimestamps = true;

  public function getAllShceduleDetail()
  {
    $query = "SELECT  `sd`.*
    FROM `schedule_detail` AS `sd`
    JOIN `schedule` AS `s`
    ON `s`.`id` = `sd`.`schedule_id`
    JOIN `day` AS `d`
    ON `d`.`id` = `s`.`day_id`
    JOIN `fields` AS `f`
    ON `f`.`id` = `s`.`field_id`
    ";
    return $this->db->query($query);
  }

  
  public function getShceduleDetailByDayAndFieldId($day, $fieldId)
  {

    $query = "SELECT  `sd`.*, IF(`td`.`schedule_detail_id`,1,0) as booked
    FROM `schedule_detail` AS `sd`
    JOIN `schedule` AS `s`
    ON `s`.`id` = `sd`.`schedule_id`
    JOIN `day` AS `d`
    ON `d`.`id` = `s`.`day_id`
    JOIN `fields` AS `f`
    ON `f`.`id` = `s`.`field_id`
    LEFT JOIN `transaction_detail` AS `td`
    ON `sd`.`id` = `td`.`schedule_detail_id`
    WHERE `f`.`id` = $fieldId 
    AND `d`.`day` = '$day'
    ";
    return $this->db->query($query);
  }

  public function getPricesVenue()
  {
    $query = "SELECT MIN(`sd`.`price`) AS `start_from`, `v`.`id` AS `venue_id`
    FROM `schedule_detail` AS `sd`
    JOIN `schedule` AS `s`
    ON `s`.`id` = `sd`.`schedule_id`
    JOIN `fields` AS `f`
    ON `f`.`id` = `s`.`field_id`
    JOIN `arena` AS `a`
    ON `f`.`arena_id` = `a`.`id`
    JOIN `venue` AS `v`
    ON `a`.`venue_id` = `v`.`id`
    GROUP BY `v`.`id`

    ";
    return $this->db->query($query);
  }
  public function getPricesField()
  {
    $query = "SELECT MIN(`sd`.`price`) AS `start_from`, `f`.`id` AS `field_id`
    FROM `schedule_detail` AS `sd`
    JOIN `schedule` AS `s`
    ON `s`.`id` = `sd`.`schedule_id`
    JOIN `fields` AS `f`
    ON `f`.`id` = `s`.`field_id`
    GROUP BY `f`.`id`

    ";
    return $this->db->query($query);
  }
  public function getPricesByFieldId($fieldId)
  {
    $query = "SELECT MIN(`sd`.`price`) AS `start_from`, `f`.`id` AS `field_id`
    FROM `schedule_detail` AS `sd`
    JOIN `schedule` AS `s`
    ON `s`.`id` = `sd`.`schedule_id`
    JOIN `fields` AS `f`
    ON `f`.`id` = `s`.`field_id`
    WHERE `f`.`id` = $fieldId
    GROUP BY `f`.`id`

    ";
    return $this->db->query($query);
  }
}
