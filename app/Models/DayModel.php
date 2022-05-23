<?php

namespace App\Models;

use CodeIgniter\Model;

class DayModel extends Model
{
  protected $table = 'day';
  protected $allowedFields = ['day', 'active'];
  protected $useTimestamps = true;
}
