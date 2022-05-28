<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionDetailModel extends Model
{
  protected $table = 'transaction_detail';
  protected $allowedFields = ['transaction_id', 'booking_date', 'schedule_detail_id', 'price'];
  protected $useTimestamps = true;


  public function getTransactionDetailByTransactionCode($code)
  {
    $query = "SELECT `td`.*,`t`.`transaction_code`,`sd`.`start_time`,`sd`.`end_time`,`f`.`slug`,`f`.`field_name`,`f`.`field_image`,`v`.`venue_name`
        FROM `transaction_detail` AS `td`
        JOIN `transaction` AS `t`
        ON `td`.`transaction_id` = `t`.`id`
        JOIN `schedule_detail` AS `sd`
        ON `td`.`schedule_detail_id` = `sd`.`id`
        JOIN `schedule` AS `s`
        ON `sd`.`schedule_id` = `s`.`id`
        JOIN `fields` AS `f`
        ON `s`.`field_id` = `f`.`id`
        JOIN `arena` AS `a`
        ON `f`.`arena_id` = `a`.`id`
        JOIN `venue` AS `v`
        ON `a`.`venue_id` = `v`.`id`
        WHERE `t`.`transaction_code` = '$code'
    ";
    return $this->db->query($query);
  }
  public function getTransactionDetailByDate($date)
  {
    $query = "SELECT `td`.*,`t`.`transaction_code`,`sd`.`start_time`,`sd`.`end_time`,`f`.`slug`,`f`.`field_name`,`f`.`field_image`,`v`.`venue_name`
        FROM `transaction_detail` AS `td`
        JOIN `transaction` AS `t`
        ON `td`.`transaction_id` = `t`.`id`
        JOIN `schedule_detail` AS `sd`
        ON `td`.`schedule_detail_id` = `sd`.`id`
        JOIN `schedule` AS `s`
        ON `sd`.`schedule_id` = `s`.`id`
        JOIN `fields` AS `f`
        ON `s`.`field_id` = `f`.`id`
        JOIN `arena` AS `a`
        ON `f`.`arena_id` = `a`.`id`
        JOIN `venue` AS `v`
        ON `a`.`venue_id` = `v`.`id`
        WHERE `td`.`booking_date` = '$date' 
        AND `t`.`status_code` = 200 OR `t`.`status_code` = 201
    ";
    return $this->db->query($query);
  }
}
