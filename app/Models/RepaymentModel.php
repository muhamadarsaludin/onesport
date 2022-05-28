<?php

namespace App\Models;

use CodeIgniter\Model;

class RepaymentModel extends Model
{
  protected $table = 'repayment';
  protected $allowedFields = ['transaction_id', 'code', 'total_pay','status_code'];
  protected $useTimestamps = true;
}
