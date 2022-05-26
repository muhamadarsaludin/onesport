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

class Main extends BaseController
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

  public function add($fieldSlug)
  {
    $field = $this->fieldsModel->getWhere(['slug' => $fieldSlug])->getRowArray();
    $data = [
      'title'  => 'Tambah Jadwal',
      'active' => 'venue-arena',
      'field' => $field,
      'days' => $this->dayModel->get()->getResultArray(),
      'schedules' => $this->scheduleModel->getScheduleByFieldId($field['id'])->getResultArray(),
      'validation' => \Config\Services::validation(),
    ];
    // dd($data);
    return view('dashboard/venue/arena/field/schedule/add', $data);
  }

  public function save($fieldId)
  {
    $field = $this->fieldsModel->getWhere(['id' => $fieldId])->getRowArray();
    if (!$this->validate([
      'day_id' => 'required',
      'start_time' => 'required',
      'end_time' => 'required',
    ])) {
      return redirect()->to('/venue/arena/field/schedule/main/add/' . $field['slug'])->withInput()->with('errors', $this->validator->getErrors());
    }

    $dayId = $this->request->getVar('day_id');
    $start = $this->request->getVar('start_time');
    $end = $this->request->getVar('end_time');

    $this->scheduleModel->save([
      'day_id' => $dayId,
      'field_id' => $fieldId,
      'start_time' => $start,
      'end_time' => $end
    ]);

    $schedule = $this->scheduleModel->getWhere(['field_id' => $fieldId, 'day_id' => $dayId])->getRowArray();
    // 
    $interval = floor((strtotime($end) - strtotime($start)) / (60 * 60));

    for ($i = 1; $i <= $interval; $i++) {
      $start_time = date('H:i', (strtotime($start) + 60 * 60 * ($i - 1)));
      $end_time = date('H:i', (strtotime($start) + 60 * 60 * $i));
      $this->scheduleDetailModel->save([
        'schedule_id' => $schedule['id'],
        'start_time' => $start_time,
        'end_time' => $end_time,
      ]);
    }

    session()->setFlashdata('message', 'Jadwal berhasil ditambahkan!');
    return redirect()->to('/venue/arena/field/schedule/main/detail/' . $schedule['id']);
  }

  public function detail($scheduleId)
  {
    $data = [
      'title' => 'Detail Jadwal',
      'schedule' => $this->scheduleModel->getScheduleById($scheduleId)->getRowArray(),
      'details' => $this->scheduleDetailModel->getWhere(['schedule_id' => $scheduleId])->getResultArray(),
    ];
    $data['field'] = $this->fieldsModel->getWhere(['id' => $data['schedule']['field_id']])->getRowArray();
    return view('dashboard/venue/arena/field/schedule/detail', $data);
  }

  public function edit($scheduleId)
  {

    $data = [
      'title'  => 'Edit Jadwal',
      'active' => 'venue-arena',
      'days' => $this->dayModel->get()->getResultArray(),
      'myschedule' => $this->scheduleModel->getScheduleById($scheduleId)->getRowArray(),
      'validation' => \Config\Services::validation(),
    ];
    $data['field'] = $this->fieldsModel->getWhere(['id'=>$data['myschedule']['field_id']])->getRowArray();
    $data['schedules'] = $this->scheduleModel->getScheduleByFieldId($data['field']['id'])->getResultArray();
    // dd($data);
    return view('dashboard/venue/arena/field/schedule/edit', $data); 
  }

  public function update($scheduleId)
  {
    if (!$this->validate([
      'day_id' => 'required',
      'start_time' => 'required',
      'end_time' => 'required',
    ])) {
      return redirect()->to('/venue/arena/field/schedule/main/edit/' . $scheduleId)->withInput()->with('errors', $this->validator->getErrors());
    }
    $this->scheduleModel->save([
      'id' => $scheduleId,
      'day_id' => $this->request->getVar('day_id'),
      'start_time' => $this->request->getVar('start_time'),
      'end_time' => $this->request->getVar('end_time'),
    ]);
    session()->setFlashdata('message', 'Jadwal berhasil diedit!');
    return redirect()->to('/venue/arena/field/schedule/main/detail/' . $scheduleId);
  }
  public function delete($scheduleId)
  {
    $schedule = $this->scheduleModel->getWhere(['id'=>$scheduleId])->getRowArray();
    $field = $this->fieldsModel->getWhere(['id'=> $schedule['field_id']])->getRowArray();
    // dd($schedule,$field);
    $this->scheduleModel->delete($scheduleId);
    session()->setFlashdata('message', 'Jadwal berhasil dihapus!');
    return redirect()->to('/venue/arena/field/Main/detail/' . $field['slug']);
  }
}
