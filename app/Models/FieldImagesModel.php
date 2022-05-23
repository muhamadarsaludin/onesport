<?php

namespace App\Models;

use CodeIgniter\Model;

class FieldImagesModel extends Model
{
  protected $table = 'field_images';
  protected $allowedFields = ['field_id', 'image'];
  protected $useTimestamps = true;
}
