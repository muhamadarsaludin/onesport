<?php

namespace App\Models;

use CodeIgniter\Model;

class FieldSpecificationsModel extends Model
{
  protected $table = 'field_specifications';
  protected $allowedFields = ['field_id', 'spec_id', 'value'];
  protected $useTimestamps = true;

  public function getSpecByFieldId($fieldId)
  {
    $query = "SELECT `fs`.*, `s`.`spec_name`
    FROM `field_specifications` AS `fs`
    JOIN `fields` as `f`
    ON `f`.`id` = `fs`.`field_id`
    JOIN `specifications` AS `s`
    ON `s`.`id` = `fs`.`spec_id`
    WHERE `f`.`id` = $fieldId
    ";
    return $this->db->query($query);
  }
}
