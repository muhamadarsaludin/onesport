<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
  protected $table = 'transaction';
  protected $allowedFields = ['user_id', 'transaction_code', 'transaction_date', 'transaction_exp_date', 'total_pay', 'dp_method', 'total_dp', 'snap_token', 'transaction_status', 'status_code'];
  protected $useTimestamps = true;
}
