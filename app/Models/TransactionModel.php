<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
  protected $table = 'transaction';
  protected $allowedFields = ['user_id', 'transaction_code', 'transaction_date', 'transaction_exp_date', 'total_pay', 'use_ticket', 'dp_method', 'total_dp', 'dp_status', 'repayment', 'snap_token', 'cancel', 'transaction_status', 'status_code'];
  protected $useTimestamps = true;

  public function getAllTransaction()
  {
    $query = "SELECT `t`.*,`f`.`id` AS `field_id`,`f`.`field_name`,`f`.`field_image`,`v`.`id` AS `venue_id`,`v`.`venue_name`
    FROM `transaction` AS `t`
    JOIN `transaction_detail` AS `td`
    ON `t`.`id` = `td`.`transaction_id`
    JOIN `schedule_detail` AS `sd`
    ON `sd`.`id` = `td`.`schedule_detail_id`
    JOIN `schedule` AS `s`
    ON `s`.`id` = `sd`.`schedule_id`
    JOIN `fields` AS `f`
    ON `f`.`id` = `s`.`field_id`
    JOIN `arena` AS `a`
    ON `a`.`id` = `f`.`arena_id`
    JOIN `venue` AS `v`
    ON `v`.`id` = `a`.`venue_id`
    ";
    return $this->db->query($query);
  }
  public function getTransactionByVenueId($id)
  {
    $query = "SELECT `t`.*,`f`.`id` AS `field_id`,`f`.`field_name`,`f`.`field_image`,`v`.`id` AS `venue_id`,`v`.`venue_name`
    FROM `transaction` AS `t`
    JOIN `transaction_detail` AS `td`
    ON `t`.`id` = `td`.`transaction_id`
    JOIN `schedule_detail` AS `sd`
    ON `sd`.`id` = `td`.`schedule_detail_id`
    JOIN `schedule` AS `s`
    ON `s`.`id` = `sd`.`schedule_id`
    JOIN `fields` AS `f`
    ON `f`.`id` = `s`.`field_id`
    JOIN `arena` AS `a`
    ON `a`.`id` = `f`.`arena_id`
    JOIN `venue` AS `v`
    ON `v`.`id` = `a`.`venue_id`
    WHERE `v`.`id` = $id
    ";
    return $this->db->query($query);
  }


  public function getTransactionByUserId($userId)
  {
    $query = "SELECT `t`.*, IF(`r`.`id`, 1,0) AS 'reviewed', `td`.`booking_date`
    FROM `transaction` AS `t`
    JOIN `transaction_detail` AS `td`
    ON `t`.`id` = `td`.`transaction_id`
    JOIN `users` AS `u`
    ON `u`.`id` = `t`.`user_id`
    JOIN `rating` AS `r`
    ON `t`.`id` = `r`.`transaction_id`
    WHERE `u`.`id` = $userId 
    ";
    return $this->db->query($query);
  }
  public function getTransactionByCode($transCode)
  {
    $query = "SELECT `t`.*,`f`.`id` AS `field_id`,`f`.`field_name`,`f`.`field_image`,`v`.`id` AS `venue_id`,`v`.`venue_name`
    FROM `transaction` AS `t`
    JOIN `transaction_detail` AS `td`
    ON `t`.`id` = `td`.`transaction_id`
    JOIN `schedule_detail` AS `sd`
    ON `sd`.`id` = `td`.`schedule_detail_id`
    JOIN `schedule` AS `s`
    ON `s`.`id` = `sd`.`schedule_id`
    JOIN `fields` AS `f`
    ON `f`.`id` = `s`.`field_id`
    JOIN `arena` AS `a`
    ON `a`.`id` = `f`.`arena_id`
    JOIN `venue` AS `v`
    ON `v`.`id` = `a`.`venue_id`
    WHERE `t`.`transaction_code` = '$transCode' 
    ";
    return $this->db->query($query);
  }

  public function getTheLatestTransaction($userId){
    $query = "SELECT `t`.*
    FROM `transaction` AS `t`
    WHERE `t`.`user_id` = $userId AND `t`.`use_ticket` = 0
    ORDER BY `created_at` DESC
    LIMIT 5
    ";
    return $this->db->query($query);
  }
}
