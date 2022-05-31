<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
  protected $table = 'transaction';
  protected $allowedFields = ['user_id', 'transaction_code', 'transaction_date', 'transaction_exp_date', 'total_pay', 'use_ticket', 'dp_method', 'total_dp', 'dp_status', 'repayment', 'snap_token', 'cancel', 'transaction_status', 'status_code'];
  protected $useTimestamps = true;

  
  public function getMinTransactionDate($venueId = false)
  {
      $query = "SELECT min(`transaction_date`) as `min_date`
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
      ON `v`.`id` = `a`.`venue_id`";

      if ($venueId) {
          $query .= "WHERE `v`.`id` = " . $venueId;
      }

      $result = $this->db->query($query)->getRow();
      return date('m/d/Y', strtotime($result->min_date));
  }




  public function earningsFullPayment($venueId=false)
  {
   
    if(!$venueId){
      $query = "SELECT SUM(`t`.`total_pay`) AS `sum_pay`
      FROM `transaction` AS `t`
      WHERE `t`.`status_code` = 200 AND `t`.`dp_method` = 0 AND `t`.`cancel` = 0";
    }else{
      $query = "SELECT SUM(`t`.`total_pay`) AS `sum_pay`
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
      WHERE `t`.`status_code` = 200 AND `t`.`dp_method` = 0 AND `t`.`cancel` = 0 AND `v`.`id` = $venueId
      ";
    }


    return $this->db->query($query);
  }

  public function earningsRepayment($venueId=false)
  {  
    if(!$venueId){
      $query = "SELECT SUM(`t`.`total_pay`) AS `sum_repay`
      FROM `transaction` AS `t`
      WHERE `t`.`status_code` = 200 AND `t`.`repayment` = 1 AND `t`.`cancel` = 0";
    }else{
      $query = "SELECT SUM(`t`.`total_pay`) AS `sum_repay`
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
      WHERE `t`.`status_code` = 200 AND `t`.`repayment` = 1 AND `t`.`cancel` = 0 AND `v`.`id` = $venueId
      ";
    }
    return $this->db->query($query);
  }

  public function earningsDP($venueId=false)
  {  
    if(!$venueId){
      $query = "SELECT SUM(`t`.`total_dp`) AS `sum_dp`
      FROM `transaction` AS `t`
      WHERE `t`.`dp_status` = 1 AND `t`.`repayment` = 0 AND `t`.`cancel` = 0
    ";
    }else{
      $query = "SELECT SUM(`t`.`total_dp`) AS `sum_dp`
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
      WHERE `t`.`dp_status` = 1 AND `t`.`repayment` = 0 AND `t`.`cancel` = 0 AND `v`.`id` = $venueId
    ";
    }
    return $this->db->query($query);
  }

  public function getTransactionBetweenDate($start_date, $end_date, $venueId=false)
  {
    $start_date = date('Y-m-d', strtotime($start_date));
    $end_date = date('Y-m-d', strtotime($end_date));

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
    WHERE 
    ";
    if($venueId){
      $query .= "`v`.`id` = $venueId AND ";
    }
    $query .= "`t`.`transaction_date` BETWEEN '$start_date' AND '$end_date'";
    return $this->db->query($query);
  }
  public function getAllTransaction()
  {
    $query = "SELECT `t`.*,`f`.`id` AS `field_id`,`f`.`field_name`,`f`.`field_image`,`v`.`id` AS `venue_id`,`v`.`venue_name`
    FROM `transaction` AS `t`
    LEFT JOIN `transaction_detail` AS `td`
    ON `t`.`id` = `td`.`transaction_id`
    LEFT JOIN `schedule_detail` AS `sd`
    ON `sd`.`id` = `td`.`schedule_detail_id`
    LEFT JOIN `schedule` AS `s`
    ON `s`.`id` = `sd`.`schedule_id`
    LEFT JOIN `fields` AS `f`
    ON `f`.`id` = `s`.`field_id`
    LEFT JOIN `arena` AS `a`
    ON `a`.`id` = `f`.`arena_id`
    LEFT JOIN `venue` AS `v`
    ON `v`.`id` = `a`.`venue_id`
    GROUP BY `t`.`id`
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
    $query = "SELECT `t`.*, IF(`r`.`id`, 1,0) AS 'reviewed', `td`.`booking_date`,`v`.`venue_name`,`f`.`field_name`
    FROM `transaction` AS `t`
    JOIN `transaction_detail` AS `td`
    ON `t`.`id` = `td`.`transaction_id`
    JOIN `users` AS `u`
    ON `u`.`id` = `t`.`user_id`
    LEFT JOIN `rating` AS `r`
    ON `t`.`id` = `r`.`transaction_id`
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
    WHERE `u`.`id` = $userId 
    GROUP BY `t`.`id`
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


  // COUNT
  public function getCountTransactionSuccess($venueId = false)
  {
    if($venueId){
      $query = "SELECT `t`.* 
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
      WHERE `t`.`status_code` = 200 AND `t`.`cancel` = 0 AND `v`.`id` = $venueId
      ";
      return $this->db->query($query);
    }
    // ADMIN
    $query = "SELECT `t`.* 
    FROM `transaction` AS `t`
    WHERE `t`.`status_code` = 200 AND `t`.`cancel` = 0
    ";
    return $this->db->query($query);
  }

  public function getCountTransactionPending($venueId = false)
  {
    if($venueId){
      $query = "SELECT `t`.* 
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
      WHERE `t`.`status_code` = 201 AND `v`.`id` = $venueId
      ";
      return $this->db->query($query);
    }
    $query = "SELECT `t`.* 
    FROM `transaction` AS `t`
    WHERE `t`.`status_code` = 201
    ";
    return $this->db->query($query);
  }
  public function getCountTransactionDP($venueId = false)
  {
    if($venueId){
      $query = "SELECT `t`.* 
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
      WHERE `t`.`dp_status` = 1 AND `t`.`cancel` = 0 AND `v`.`id` = $venueId
      ";
      return $this->db->query($query);
    }
    $query = "SELECT `t`.* 
    FROM `transaction` AS `t`
    WHERE `t`.`dp_status` = 1 AND `t`.`cancel` = 0
    ";
    return $this->db->query($query);
  }

  public function getCountTransactionCancel($venueId = false)
  {
    if($venueId){
      $query = "SELECT `t`.* 
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
      WHERE `t`.`status_code` = 200 AND `t`.`cancel` = 1  AND `v`.`id` = $venueId
      ";
      return $this->db->query($query);
    }
    $query = "SELECT `t`.* 
    FROM `transaction` AS `t`
    WHERE `t`.`cancel` = 1
    ";
    return $this->db->query($query);
  }
  public function getCountTransactionFailed($venueId = false)
  {
    if($venueId){
      $query = "SELECT `t`.* 
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
      WHERE `t`.`status_code` != 200 AND `t`.`status_code` != 201  AND `v`.`id` = $venueId
      ";
      return $this->db->query($query);
    }

    $query = "SELECT `t`.* 
    FROM `transaction` AS `t`
    WHERE `t`.`status_code` != 200 AND `t`.`status_code` != 201
    ";
    return $this->db->query($query);
  }

  // COUNT Venue
  
}
