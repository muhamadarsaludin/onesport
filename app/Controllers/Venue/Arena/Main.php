<?php

namespace App\Controllers\Venue\Arena;

use App\Controllers\BaseController;

use App\Models\ArenaModel;
use App\Models\ArenaImagesModel;
use App\Models\ArenaFacilitiesModel;
use App\Models\FieldsModel;
use App\Models\FacilitiesModel;
use App\Models\SportsModel;
use App\Models\VenueModel;
use App\Models\VenueLevelsModel;
use App\Models\UsersModel;
use App\Models\GroupsModel;
use App\Models\GroupsUsersModel;

class Main extends BaseController
{
  protected $arenaModel;
  protected $arenaImagesModel;
  protected $arenaFacilitiesModel;
  protected $fieldsModel;
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
    $this->fieldsModel = new FieldsModel();
    $this->facilitiesModel = new FacilitiesModel();
    $this->sportsModel = new SportsModel();
    $this->venueModel = new VenueModel();
    $this->venueLevelsModel = new VenueLevelsModel();
    $this->usersModel = new UsersModel();
    $this->groupsModel = new GroupsModel();
    $this->groupsUsersModel = new GroupsUsersModel();
    helper('text');
  }


  public function index()
  {
    $data = [
      'title'  => 'Daftar Arena',
      'active' => 'venue-arena',
      'arenas'  => $this->arenaModel->getArenaByVenueSlug(venue()->slug)->getResultArray(),
    ];
    // dd($data);
    return view('dashboard/venue/arena/main/index', $data);
  }


  // Add Data
  public function add()
  {
    $data = [
      'title'  => 'Tambah Arena',
      'active' => 'venue-arena',
      'sports' => $this->sportsModel->get()->getResultArray(),
      'arenas' => $this->arenaModel->getWhere(['venue_id' => venue()->id])->getResultArray(),
      'validation' => \Config\Services::validation(),
    ];
    // dd($data);
    return view('dashboard/venue/arena/main/add', $data);
  }

  public function save()
  {
    if (!$this->validate([
      'sport_id' => 'required',
      'active' => 'required',
      'arena_image' => [
        'rules'  => 'uploaded[arena_image]|max_size[arena_image,5024]|ext_in[arena_image,png,jpg,jpeg]',
        'errors' => [
          'ext_in' => "Extension must Image",
        ]
      ],
      'image-1' => 'max_size[image-1,5024]|ext_in[image-1,png,jpg,jpeg]',
      'image-2' => 'max_size[image-2,5024]|ext_in[image-2,png,jpg,jpeg]',
      'image-3' => 'max_size[image-3,5024]|ext_in[image-3,png,jpg,jpeg]',
      'image-4' => 'max_size[image-4,5024]|ext_in[image-4,png,jpg,jpeg]',
    ])) {
      return redirect()->to('/venue/arena/main/add')->withInput()->with('errors', $this->validator->getErrors());
    }
    $image = $this->request->getFile('arena_image');
    $imageName = $image->getRandomName();
    $image->move('img/venue/arena/main-images', $imageName);
    $sport = $this->sportsModel->getWhere(['id' => $this->request->getVar('sport_id')])->getRowArray();
    $slug = strtolower($sport['slug'] . '-' . random_string('numeric', 4));
    $this->arenaModel->save([
      'arena_image' => $imageName,
      'slug' => $slug,
      'venue_id' => venue()->id,
      'sport_id' => $this->request->getVar('sport_id'),
      'active' => $this->request->getVar('active'),
      'description' => $this->request->getVar('description'),
    ]);

    $arena = $this->arenaModel->getWhere(['slug' => $slug])->getRowArray();
    $images = [];
    for ($i = 1; $i <= 4; $i++) {
      # code...
      array_push($images, $this->request->getFile('image-' . $i));
    }
    foreach ($images as $image) {
      if (!$image->getError() == 4) {
        // pindahkan file
        $imageName = $image->getRandomName();
        $image->move('img/venue/arena/other-images', $imageName);
        $this->arenaImagesModel->save([
          'arena_id' => $arena['id'],
          'image' => $imageName
        ]);
      }
    }
    session()->setFlashdata('message', 'Arena ' . $sport['sport_name'] . ' berhasil ditambahkan!');
    return redirect()->to('/venue/arena/main/detail/' . $arena['slug']);
  }

  // Detail Arena
  public function detail($slug)
  {
    $data = [
      'title' => 'Detail Arena',
      'arena' => $this->arenaModel->getArenaBySlug($slug)->getRowArray(),
    ];
    $data['fields'] = $this->fieldsModel->getWhere(['arena_id' => $data['arena']['id']])->getResultArray();
    $data['facilities'] = $this->facilitiesModel->getArenaFacilitiesByArenaId($data['arena']['id'])->getResultArray();
    $data['images'] = $this->arenaImagesModel->getWhere(['arena_id' => $data['arena']['id']])->getResultArray();
    // dd($data);
    return view('dashboard/venue/arena/main/detail', $data);
  }

  public function delete($id)
  {
    $arena = $this->arenaModel->getWhere(['id' => $id])->getRowArray();
    $images = $this->arenaImagesModel->getWhere(['arena_id' => $arena['id']])->getResultArray();
    if ($arena['arena_image'] != 'default.png') {
      unlink('img/venue/arena/main-images/' . $arena['arena_image']);
    }

    foreach ($images as $image) {
      if ($image['image'] != 'default.png') {
        unlink('img/venue/arena/other-images/' . $image['image']);
      }
      $this->arenaImagesModel->delete($image['id']);
    }

    $this->arenaModel->delete($id);
    session()->setFlashdata('message', 'Arena berhasil dihapus!');
    return redirect()->to('/venue/arena/main');
  }
}
