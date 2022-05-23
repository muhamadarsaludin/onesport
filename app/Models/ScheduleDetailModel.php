<?php

namespace App\Models;

use CodeIgniter\Model;

class ScheduleDetailModel extends Model
{
  protected $table = 'schedule_detail';
  protected $allowedFields = ['schedule_id', 'start_time', 'end_time', 'active', 'price'];
  protected $useTimestamps = true;

  public function getShceduleDetailByDayAndFieldId($day, $fieldId)
  {

    $query = "SELECT  `sd`.*
    FROM `schedule_detail` AS `sd`
    JOIN `schedule` AS `s`
    ON `s`.`id` = `sd`.`schedule_id`
    JOIN `day` AS `d`
    ON `d`.`id` = `s`.`day_id`
    JOIN `fields` AS `f`
    ON `f`.`id` = `s`.`field_id`
    WHERE `f`.`id` = $fieldId 
    AND `d`.`day` = '$day'
    ";
    return $this->db->query($query);
  }
}
