<?php

namespace App\Models;

use CodeIgniter\Model;

class RatingModel extends Model
{
  protected $table = 'rating';
  protected $allowedFields = ['transaction_id', 'user_id', 'field_id','venue_id','rating','review'];
  protected $useTimestamps = true;
}
