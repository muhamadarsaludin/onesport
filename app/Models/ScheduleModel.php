<?php

namespace App\Models;

use CodeIgniter\Model;

class ScheduleModel extends Model
{
  protected $table = 'schedule';
  protected $allowedFields = ['day_id', 'field_id', 'start_time', 'end_time', 'active'];
  protected $useTimestamps = true;


  public function getAllSchedule()
  {
    $query = "SELECT  `s`.*,`d`.`day`, `d`.`id` as `dayID`, IF(`s`.`day_id`, 1 ,0 ) as `served`
    FROM `schedule` AS `s`
    RIGHT JOIN `day` AS `d`
    ON `s`.`day_id` = `d`.`id`
    UNION
    SELECT  `s`.*,`d`.`day`, `d`.`id` as `dayID`,IF(`s`.`day_id`, 1 ,0 ) as `served`
    FROM `schedule` AS `s`
    LEFT JOIN `day` AS `d`
    ON `s`.`day_id` = `d`.`id`
    ";
    return $this->db->query($query);
  }
  public function getScheduleByFieldId($fieldId)
  {
    $query = "SELECT  `s`.*,`d`.`day`, `d`.`id` as `dayID`
    FROM `schedule` AS `s`
    RIGHT JOIN `day` AS `d`
    ON `s`.`day_id` = `d`.`id`
    WHERE `s`.`field_id` = $fieldId
    ";
    return $this->db->query($query);
  }
  public function getScheduleById($scheduleId)
  {
    $query = "SELECT  `s`.*,`d`.`day`, `d`.`id` as `dayID`
    FROM `schedule` AS `s`
    RIGHT JOIN `day` AS `d`
    ON `s`.`day_id` = `d`.`id`
    WHERE `s`.`id` = $scheduleId
    ";
    return $this->db->query($query);
  }
  // public function getScheduleByFieldId($fieldId)
  // {
  //   $query = "SELECT  `s`.*,`d`.`day`, `d`.`id` as `dayID`, IF(`s`.`day_id`, 1 ,0 ) as `served`
  //   FROM `schedule` AS `s`
  //   RIGHT JOIN `day` AS `d`
  //   ON `s`.`day_id` = `d`.`id`
  //   UNION
  //   SELECT  `s`.*,`d`.`day`, `d`.`id` as `dayID`,IF(`s`.`day_id`, 1 ,0 ) as `served`
  //   FROM `schedule` AS `s`
  //   LEFT JOIN `day` AS `d`
  //   ON `s`.`day_id` = `d`.`id`
  //   WHERE `s`.`field_id` = $fieldId
  //   ";
  //   return $this->db->query($query);
  // }
}
