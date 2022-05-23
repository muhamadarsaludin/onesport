<?php

namespace App\Models;

use CodeIgniter\Model;

class VenueLevelsModel extends Model
{
  protected $table = 'venue_levels';
  protected $allowedFields = ['level_name', 'description', 'active'];
  protected $useTimestamps = true;
}
