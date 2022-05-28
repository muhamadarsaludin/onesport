<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Pdf;
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

class Arena extends BaseController
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
      'title'  => 'Arena Olahraga',
      'active' => 'admin-arena',
      'arenas'  => $this->arenaModel->getAllArena()->getResultArray(),
    ];
    // dd($data);
    return view('dashboard/admin/arena/index', $data);
  }


  // Add Data
  public function add()
  {
    $data = [
      'title'  => 'Tambah Arena',
      'active' => 'admin-arena',
      'sports' => $this->sportsModel->get()->getResultArray(),
      'validation' => \Config\Services::validation(),
    ];
    // dd($data);
    return view('dashboard/admin/arena/add', $data);
  }

  public function save()
  {
    if (!$this->validate([
      'venue_slug' => 'required',
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


    $venue = $this->venueModel->getVenueBySlug($this->request->getVar('venue_slug'))->getRowArray();


    $this->arenaModel->save([
      'arena_image' => $imageName,
      'slug' => $slug,
      'venue_id' => $venue['id'],
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
    session()->setFlashdata('message', 'Arena ' . $sport['sport_name'] . ' venue ' . $venue['venue_name'] . ' berhasil ditambahkan!');
    return redirect()->to('/admin/arena/index/');
  }

  // Detail Arena
  public function detail($slug)
  {
    $data = [
      'title'  => 'Detail Arena',
      'active' => 'admin-arena',
      'sports' => $this->sportsModel->get()->getResultArray(),
      'arena'  => $this->arenaModel->getArenaBySlug($slug)->getRowArray(),
      'validation' => \Config\Services::validation(),
    ];
    $data['fields'] = $this->fieldsModel->getWhere(['arena_id' => $data['arena']['id']])->getResultArray();
    $data['facilities'] = $this->facilitiesModel->getArenaFacilitiesByArenaId($data['arena']['id'])->getResultArray();
    $data['images'] = $this->arenaImagesModel->getWhere(['arena_id' => $data['arena']['id']])->getResultArray();
    // dd($data);
    return view('dashboard/admin/arena/detail', $data);
  }

  // EDIT
  public function edit($slug)
  {
    $data = [
      'title'  => 'Edit Arena',
      'active' => 'admin-arena',
      'sports' => $this->sportsModel->get()->getResultArray(),
      'arena'  => $this->arenaModel->getArenaBySlug($slug)->getRowArray(),
      'validation' => \Config\Services::validation(),
    ];
    $data['images'] = $this->arenaImagesModel->getWhere(['arena_id' => $data['arena']['id']])->getResultArray();
    // dd($data);
    return view('dashboard/admin/arena/edit', $data);
  }


  public function update($id)
  {
    if (!$this->validate([
      'venue_slug' => 'required',
      'sport_id' => 'required',
      'active' => 'required',
      'arena_image' => [
        'rules'  => 'max_size[arena_image,5024]|ext_in[arena_image,png,jpg,jpeg]',
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

    $arena = $this->arenaModel->getWhere(['id' => $id])->getRowArray();
    $images =  $this->arenaImagesModel->getWhere(['arena_id' => $arena['id']])->getResultArray();
    $arenaImage = $this->request->getFile('arena_image');
    if ($arenaImage->getError() != 4) {
      unlink('img/venue/arena/main-images/' . $arena['arena_image']);
      $arena['arena_image'] = $arenaImage->getRandomName();
      $arenaImage->move('img/venue/arena/main-images', $arena['arena_image']);
    }
    if ($arena['sport_id'] != $this->request->getVar('sport_id')) {
      $sport = $this->sportsModel->getWhere(['id' => $this->request->getVar('sport_id')])->getRowArray();
      $arena['sport_id'] = $sport['id'];
      $arena['slug'] = strtolower($sport['slug'] . '-' . random_string('numeric', 4));
    }
    if ($arena['active'] != $this->request->getVar('active')) {
      $arena['active'] = $this->request->getVar('active');
    }
    if ($arena['description'] != $this->request->getVar('description')) {
      $arena['description'] = $this->request->getVar('description');
    }

    $oldVenue = $this->venueModel->getWhere(['id' => $arena['venue_id']])->getRowArray();
    $venue = $this->venueModel->getVenueBySlug($this->request->getVar('venue_slug'))->getRowArray();
    if ($oldVenue['id'] != $venue['id']) {
      $arena['venue_id'] = $venue['id'];
    }
    // simpan data arena
    $this->arenaModel->save($arena);


    // IMAGES
    $oldImages = $this->arenaImagesModel->getWhere(['arena_id' == $id])->getResultArray();

    $images = [];
    for ($i = 1; $i <= 4; $i++) {
      array_push($images, $this->request->getFile('image-' . $i));
    }

    for ($i = 0; $i < count($oldImages); $i++) {
      if (!$images[$i]->getError() == 4) {
        // gambar di ganti
        // dapat nama gambar baru
        $imageName = $images[$i]->getRandomName();
        // upload gambar baru
        $images[$i]->move('img/venue/arena/other-images', $imageName);
        // hapus image lama
        unlink('img/venue/arena/other-images/' . $oldImages[$i]['image']);
        // simpan data image baru
        $this->arenaImagesModel->save([
          'id' => $oldImages[$i]['id'],
          'image' => $imageName
        ]);
      }
    }

    // Gambar tambahan
    for ($i = count($oldImages); $i < 4; $i++) {
      if (!$images[$i]->getError() == 4) {
        $imageName = $images[$i]->getRandomName();
        $images[$i]->move('img/venue/arena/other-images', $imageName);
        $this->arenaImagesModel->save([
          'arena_id' => $id,
          'image' => $imageName
        ]);
      }
    }
    session()->setFlashdata('message', 'Data Arena berhasil diedit!');
    return redirect()->to('/admin/arena/index/');
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
    return redirect()->to('/admin/arena');
  }

  public function report()
  {
    $pdf = new Pdf();
    $reportedAt = date('YmdS-His');
    $timeReportedAt = strtotime(preg_replace('/(\d+)(\w+)-(\d+)/i', '$1$3', $reportedAt));

    $data = [
      'title' => "Arena Report " . date('M', $timeReportedAt) . ", " . date("Y", $timeReportedAt),
      'arena' => $this->arenaModel->getAllArena()->getResultObject(),
    ];

    $pdf->setPaper('A4', 'landscape');
    $pdf->filename = "arena_report_" . $reportedAt;
    $pdf->loadView('dashboard/admin/arena/report', $data);
  }
}
