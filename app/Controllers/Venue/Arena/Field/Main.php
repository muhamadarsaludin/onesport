<?php

namespace App\Controllers\Venue\Arena\Field;

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

  public function add($slug)
  {
    $arena = $this->arenaModel->getArenaBySlug($slug)->getRowArray();
    $data = [
      'title'  => 'Tambah Lapangan',
      'active' => 'venue-arena',
      'arena' => $arena,
      'specs' => $this->specificationsModel->getWhere(['sport_id' => $arena['sport_id']])->getResultArray(),
      'validation' => \Config\Services::validation(),
    ];
    // dd($data);
    return view('dashboard/venue/arena/field/add', $data);
  }

  public function save()
  {
    if (!$this->validate([
      'arena_id' => 'required',
      'field_name' => 'required',
      'field_image' => [
        'rules'  => 'uploaded[field_image]|max_size[field_image,5024]|ext_in[field_image,png,jpg,jpeg]',
        'errors' => [
          'ext_in' => "Extension must Image",
        ]
      ],
      'image-1' => 'max_size[image-1,5024]|ext_in[image-1,png,jpg,jpeg]',
      'image-2' => 'max_size[image-2,5024]|ext_in[image-2,png,jpg,jpeg]',
      'image-3' => 'max_size[image-3,5024]|ext_in[image-3,png,jpg,jpeg]',
      'image-4' => 'max_size[image-4,5024]|ext_in[image-4,png,jpg,jpeg]',
    ])) {
      return redirect()->to('/venue/arena/field/main/add/' . $this->request->getVar('arena_slug'))->withInput()->with('errors', $this->validator->getErrors());
    }

    $image = $this->request->getFile('field_image');
    $imageName = $image->getRandomName();
    $image->move('img/venue/arena/fields/main-images', $imageName);
    $fieldName = $this->request->getVar('field_name');
    $slug = strtolower(url_title($fieldName, '-') . '-' . random_string('numeric', 4));

    $this->fieldsModel->save([
      'arena_id' => $this->request->getVar('arena_id'),
      'field_name' => $fieldName,
      'field_image' => $imageName,
      'slug' => $slug,
      'description' => $this->request->getVar('description'),
    ]);

    $field = $this->fieldsModel->getWhere(['slug' => $slug])->getRowArray();

    $images = [];
    for ($i = 1; $i <= 4; $i++) {
      # code...
      array_push($images, $this->request->getFile('image-' . $i));
    }
    foreach ($images as $image) {
      if (!$image->getError() == 4) {
        // pindahkan file
        $imageName = $image->getRandomName();
        $image->move('img/venue/arena/fields/other-images', $imageName);
        $this->fieldImagesModel->save([
          'field_id' => $field['id'],
          'image' => $imageName
        ]);
      }
    }

    session()->setFlashdata('message', 'Lapangan berhasil ditambahkan!');
    return redirect()->to('/venue/arena/main/detail/' .  $this->request->getVar('arena_slug'));
  }

  // Detail Lapangan
  public function detail($slug)
  {
    $data = [
      'title' => 'Detail Lapangan',
      'field' => $this->fieldsModel->getWhere(['slug' => $slug])->getRowArray(),
      'days'  => $this->dayModel->get()->getResultArray(),
    ];
    $data['images'] = $this->fieldImagesModel->getWhere(['field_id' => $data['field']['id']])->getResultArray();

    $data['schedules'] = $this->scheduleModel->getScheduleByFieldId($data['field']['id'])->getResultArray();
    return view('dashboard/venue/arena/field/detail', $data);
  }
}
