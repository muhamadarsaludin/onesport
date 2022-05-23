<?php

namespace App\Models;

use CodeIgniter\Model;

class FieldSpecificationsModel extends Model
{
  protected $table = 'field_specifications';
  protected $allowedFields = ['field_id', 'spec_id', 'value'];
  protected $useTimestamps = true;
}
