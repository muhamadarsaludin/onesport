<?php

namespace App\Models;

use CodeIgniter\Model;

class ArenaImagesModel extends Model
{
  protected $table = 'arena_images';
  protected $allowedFields = ['arena_id', 'image'];
  protected $useTimestamps = true;
}
