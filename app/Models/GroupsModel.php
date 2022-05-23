<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupsModel extends Model
{
  protected $table = 'auth_groups';
  protected $allowedFields = ['name', 'description'];
}
