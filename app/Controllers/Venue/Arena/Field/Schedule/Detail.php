<?php

namespace App\Controllers\Venue\Arena\Field\Schedule;

use App\Controllers\BaseController;

use App\Models\SpecificationsModel;
use App\Models\ArenaModel;
use App\Models\ArenaImagesModel;
use App\Models\ArenaFacilitiesModel;
use App\Models\FieldsModel;
use App\Models\FieldImagesModel;
use App\Models\FieldSpecificationsModel;
use App\Models\FacilitiesModel;
use App\Models\SportsModel;
use App\Models\VenueModel;
use App\Models\VenueLevelsModel;
use App\Models\UsersModel;
use App\Models\GroupsModel;
use App\Models\GroupsUsersModel;
use App\Models\DayModel;
use App\Models\ScheduleModel;
use App\Models\ScheduleDetailModel;
use ArrayObject;

class Detail extends BaseController
{
  protected $specificationsModel;
  protected $arenaModel;
  protected $arenaImagesModel;
  protected $arenaFacilitiesModel;
  protected $fieldsModel;
  protected $fieldImagesModel;
  protected $fieldSpecificationsModel;
  protected $facilitiesModel;
  protected $sportsModel;
  protected $venueModel;
  protected $venueLevelsModel;
  protected $usersModel;
  protected $groupsModel;
  protected $groupsUsersModel;
  protected $dayModel;
  protected $scheduleModel;
  protected $scheduleDetailModel;


  public function __construct()
  {
    $this->specificationsModel = new SpecificationsModel();
    $this->arenaModel = new ArenaModel();
    $this->arenaImagesModel = new ArenaImagesModel();
    $this->arenaFacilitiesModel = new ArenaFacilitiesModel();
    $this->fieldsModel = new FieldsModel();
    $this->fieldImagesModel = new FieldImagesModel();
    $this->fieldspecificationsModel = new FieldSpecificationsModel();
    $this->facilitiesModel = new FacilitiesModel();
    $this->sportsModel = new SportsModel();
    $this->venueModel = new VenueModel();
    $this->venueLevelsModel = new VenueLevelsModel();
    $this->usersModel = new UsersModel();
    $this->groupsModel = new GroupsModel();
    $this->groupsUsersModel = new GroupsUsersModel();
    $this->dayModel = new DayModel();
    $this->scheduleModel = new ScheduleModel();
    $this->scheduleDetailModel = new ScheduleDetailModel();
    helper('text');
  }

  public function edit($detailId)
  {
    $detailSchedule = $this->scheduleDetailModel->getWhere(['id' => $detailId])->getRowArray();
    $data = [
      'title'  => 'Edit Detail Schedule | Sportpedia',
      'active' => 'venue-arena',
      'detail' => $detailSchedule,
      'validation' => \Config\Services::validation(),
    ];
    $data['schedule'] = $this->scheduleModel->getWhere(['id' => $data['detail']['schedule_id']])->getRowArray();
    // dd($data);
    return view('dashboard/venue/arena/field/schedule/detail/edit', $data);
  }

  public function update($detailId)
  {

    $detail = $this->scheduleDetailModel->getWhere(['id' => $detailId])->getRowArray();

    if (!$this->validate([
      'start_time' => 'required',
      'end_time' => 'required',
      'price' => 'required',
    ])) {
      return redirect()->to('/venue/arena/field/schedule/detail/edit/' . $detailId)->withInput()->with('errors', $this->validator->getErrors());
    }

    $this->scheduleDetailModel->save([
      'id' => $detailId,
      'start_time' => $this->request->getVar('start_time'),
      'end_time' => $this->request->getVar('end_time'),
      'price' => $this->request->getVar('price'),
    ]);

    session()->setFlashdata('message', 'Detail schedule berhasil diubah!');
    return redirect()->to('/venue/arena/field/schedule/main/detail/' . $detail['schedule_id']);
  }
}
