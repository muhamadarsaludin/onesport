<?php

namespace App\Models;

use CodeIgniter\Model;

class BannersModel extends Model
{
    protected $table = 'banners';
    protected $allowedFields = ['user_id', 'venue_id', 'title', 'image',  'link', 'active'];
    protected $useTimestamps = true;

    public function getAllBanner()
  {
    $query = "SELECT `b`.*, `v`.`venue_name`
    FROM `banners` AS `b`
    LEFT JOIN `venue` AS `v`
    ON `v`.`id` = `b`.`venue_id`
    ";
    return $this->db->query($query);
  }
}
