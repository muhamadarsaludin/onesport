<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\GroupsUsersModel;
use App\Models\BannersModel;
use App\Models\SportsModel;
use App\Models\VenueModel;
use App\Models\VenueLevelsModel;
use App\Models\ArenaModel;
use App\Models\ArenaImagesModel;
use App\Models\ArenaFacilitiesModel;
use App\Models\FieldsModel;
use App\Models\FieldImagesModel;
use App\Models\FacilitiesModel;
use App\Models\DayModel;
use App\Models\ScheduleModel;
use App\Models\ScheduleDetailModel;

class Main extends BaseController
{


  protected $usersModel;
  protected $groupsUsersModel;
  protected $bannersModel;
  protected $sportsModel;
  protected $venueModel;
  protected $venueLevelsModel;
  protected $arenaModel;
  protected $arenaImagesModel;
  protected $arenaFacilitiesModel;
  protected $fieldsModel;
  protected $fieldImagesModel;
  protected $facilitiesModel;
  protected $dayModel;
  protected $scheduleModel;
  protected $scheduleDetailModel;




  public function __construct()
  {
    $this->usersModel = new UsersModel();
    $this->groupsUsersModel = new GroupsUsersModel();
    $this->bannersModel = new BannersModel();
    $this->sportsModel = new SportsModel();
    $this->venueModel = new VenueModel();
    $this->venueLevelsModel = new VenueLevelsModel();
    $this->arenaModel = new ArenaModel();
    $this->arenaImagesModel = new ArenaImagesModel();
    $this->arenaFacilitiesModel = new ArenaFacilitiesModel();
    $this->fieldsModel = new FieldsModel();
    $this->fieldImagesModel = new FieldImagesModel();
    $this->facilitiesModel = new FacilitiesModel();
    $this->dayModel = new DayModel();
    $this->scheduleModel = new ScheduleModel();
    $this->scheduleDetailModel = new ScheduleDetailModel();
  }

  public function index()
  {
    $data = [
      'title'  => 'Home | Sportpedia',
      'banners' => $this->bannersModel->getWhere(['venue_id' => null, 'active' => 1])->getResultArray(),
      'sports' => $this->sportsModel->getAllSportAvailable()->getResultArray(),
      'arenas' => $this->arenaModel->getAllArena()->getResultArray(),
    ];
    return view('public/index', $data);
  }


  public function venue($slug)
  {
    $data = [
      'title' => 'Arena | Sportpedia',
      'venue' => $this->venueModel->getVenueBySlug($slug)->getRowArray(),
    ];
    $data['arenas'] = $this->arenaModel->getArenaByVenueSlug($data['venue']['slug'])->getResultArray();
    $data['fields'] = $this->fieldsModel->getFieldsByVenueId($data['venue']['id'])->getResultArray();
    $data['banners'] = $this->bannersModel->getWhere(['venue_id' => $data['venue']['id'], 'active' => 1])->getResultArray();
    // dd($data);
    return view('public/venue', $data);
  }



  public function arena($slug)
  {
    $data = [
      'title' => 'Arena | Sportpedia',
      'arena' => $this->arenaModel->getArenaBySlug($slug)->getRowArray(),
    ];
    $data['fields'] = $this->fieldsModel->getWhere(['arena_id' => $data['arena']['id']])->getResultArray();
    $data['facilities'] = $this->facilitiesModel->getArenaFacilitiesByArenaId($data['arena']['id'])->getResultArray();
    $data['images'] = $this->arenaImagesModel->getWhere(['arena_id' => $data['arena']['id']])->getResultArray();
    // dd($data);
    return view('public/arena', $data);
  }

  public function field($slug)
  {
    $data = [
      'title' => 'Lapangan | Sportpedia',
      'field' => $this->fieldsModel->getWhere(['slug' => $slug])->getRowArray(),
    ];
    $data['images'] = $this->fieldImagesModel->getWhere(['field_id' => $data['field']['id']])->getResultArray();
    $data['schedules'] = $this->scheduleModel->getScheduleByFieldId($data['field']['id'])->getResultArray();
    $data['arena'] = $this->arenaModel->getArenaById($data['field']['arena_id'])->getRowArray();
    $data['venue'] = $this->venueModel->getWhere(['id' => $data['arena']['venue_id']])->getRowArray();
    $data['facilities'] = $this->facilitiesModel->getArenaFacilitiesByArenaId($data['arena']['id'])->getResultArray();
    $data['dateChoose'] = false;

    $dayname = date('D');
    $date = $this->request->getVar('choose-date');
    if ($date) {
      $dayname = date('D', strtotime($date));
      $data['dateChoose'] = $date;
    }

    switch ($dayname) {
      case 'Sun':
        $hari = "Minggu";
        break;
      case 'Mon':
        $hari = "Senin";
        break;
      case 'Tue':
        $hari = "Selasa";
        break;
      case 'Wed':
        $hari = "Rabu";
        break;
      case 'Thu':
        $hari = "Kamis";
        break;
      case 'Fri':
        $hari = "Jumat";
        break;
      case 'Sat':
        $hari = "Sabtu";
        break;
    }

    $data['details'] = $this->scheduleDetailModel->getShceduleDetailByDayAndFieldId($hari, $data['field']['id'])->getResultArray();
    // dd($data);



    return view('public/field', $data);
  }


  public function schedule($id)
  {
    $data = [
      'title' => 'Detail Jadwal | Sportpedia',
      'schedule' => $this->scheduleModel->getWhere(['id' => $id])->getRowArray(),
    ];
    $data['details'] = $this->scheduleDetailModel->getWhere(['schedule_id' => $data['schedule']['id']])->getResultArray();

    dd($data);
    return view('public/field', $data);
  }




  public function venueregister()
  {
    $data = [
      'title' => 'Registrasi Venue'
    ];
    return view('auth/venue_register', $data);
  }

  public function sendvenueregistration()
  {
    if (!$this->validate([
      'venue_name' => 'required|is_unique[venue.venue_name]',
      'description' => 'required',
      'city' => 'required',
      'province' => 'required',
      'address' => 'required',
      'postal_code' => 'required',
      'postal_code' => 'required',
    ])) {
      return redirect()->to('/main/venueregister')->withInput()->with('errors', $this->validator->getErrors());;
    }

    $venue = $this->venueModel->getWhere(['user_id' => user_id()])->getRowArray();
    // dd($venue);
    if ($venue) {
      session()->setFlashdata('message', 'Kamu sudah memiliki venue');
      return redirect()->to('/dashboard');
    }
    $venueName = $this->request->getVar('venue_name');
    $slug = strtolower($venueName . '-' . random_string('numeric', 4));

    $this->venueModel->save([
      'user_id' => user()->id,
      'venue_name' => $venueName,
      'slug' => $slug,
      'description' => $this->request->getVar('description'),
      'city' => $this->request->getVar('city'),
      'province' => $this->request->getVar('province'),
      'postal_code' => $this->request->getVar('postal_code'),
      'address' => $this->request->getVar('address'),
    ]);

    $group = $this->groupsUsersModel->getWhere(['user_id' => user_id()])->getRowArray();

    $this->groupsUsersModel->save([
      'id' => $group['id'],
      'group_id' => 2
    ]);


    session()->setFlashdata('message', 'Venue berhasil dibuat');
    return redirect()->to('/dashboard');
  }


  public function trans()
  {
    return 'ok';
  }
}
