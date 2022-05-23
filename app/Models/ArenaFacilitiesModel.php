<?php

namespace App\Models;

use CodeIgniter\Model;

class ArenaFacilitiesModel extends Model
{
  protected $table = 'arena_facilities';
  protected $allowedFields = ['arena_id', 'facility_id'];
  protected $useTimestamps = true;
}
