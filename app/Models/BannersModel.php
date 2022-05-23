<?php

namespace App\Models;

use CodeIgniter\Model;

class BannersModel extends Model
{
    protected $table = 'banners';
    protected $allowedFields = ['user_id', 'venue_id', 'title', 'image',  'link', 'active'];
    protected $useTimestamps = true;
}
