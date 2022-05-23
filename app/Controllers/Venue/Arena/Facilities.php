<?php

namespace App\Controllers\Venue\Arena;

use App\Controllers\BaseController;

use App\Models\ArenaModel;
use App\Models\ArenaImagesModel;
use App\Models\ArenaFacilitiesModel;
use App\Models\FacilitiesModel;
use App\Models\SportsModel;
use App\Models\VenueModel;
use App\Models\VenueLevelsModel;
use App\Models\UsersModel;
use App\Models\GroupsModel;
use App\Models\GroupsUsersModel;

class Facilities extends BaseController
{
  protected $arenaModel;
  protected $arenaImagesModel;
  protected $arenaFacilitiesModel;
  protected $facilitiesModel;
  protected $sportsModel;
  protected $venueModel;
  protected $venueLevelsModel;
  protected $usersModel;
  protected $groupsModel;
  protected $groupsUsersModel;


  public function __construct()
  {
    $this->arenaModel = new ArenaModel();
    $this->arenaImagesModel = new ArenaImagesModel();
    $this->arenaFacilitiesModel = new ArenaFacilitiesModel();
    $this->facilitiesModel = new FacilitiesModel();
    $this->sportsModel = new SportsModel();
    $this->venueModel = new VenueModel();
    $this->venueLevelsModel = new VenueLevelsModel();
    $this->usersModel = new UsersModel();
    $this->groupsModel = new GroupsModel();
    $this->groupsUsersModel = new GroupsUsersModel();
    helper('text');
  }

  public function addFacility()
  {
    $data = [
      'facility_id' => $this->request->getVar('facilityId'),
      'arena_id' => $this->request->getVar('arenaId')
    ];

    $facility = $this->facilitiesModel->getWhere(['id' => $data['facility_id']])->getRowArray();



    $arenaFacility = $this->arenaFacilitiesModel->getWhere($data)->getRowArray();
    if ($arenaFacility) {
      $this->arenaFacilitiesModel->delete($arenaFacility['id']);
      session()->setFlashdata('facility-message', 'Fasilitas ' . $facility['facility_name'] . ' berhasil dihapus!');
    } else {
      $this->arenaFacilitiesModel->save($data);
      session()->setFlashdata('facility-message', 'Fasilitas ' . $facility['facility_name'] . ' berhasil ditambahkan!');
    }
  }
}
