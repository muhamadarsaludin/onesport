<?php

namespace App\Controllers\Venue\Myvenue\Banners;

use App\Controllers\BaseController;

use App\Models\ArenaModel;
use App\Models\ArenaImagesModel;
use App\Models\ArenaFacilitiesModel;
use App\Models\BannersModel;
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
  protected $bannersModel;
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
    $this->bannersModel = new BannersModel();
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
      'title'  => 'My Venue | Sportpedia',
      'active' => 'venue-myvenue',
      'banners'  => $this->bannersModel->getWhere(['venue_id' => venue()->id, 'active' => 1])->getResultArray(),
    ];
    // dd($data);
    return view('dashboard/venue/myvenue/banners/index', $data);
  }


  public function detail($id)
  {
    $data = [
      'title'  => 'Detail Banner Venue| Sportpedia',
      'active' => 'venue-myvenue',
      'banner' => $this->bannersModel->getWhere(['id' => $id])->getRowArray(),
    ];
    // dd($data);
    return view('dashboard/venue/myvenue/banners/detail', $data);
  }
  // Add Data

  public function add()
  {
    $data = [
      'title'  => 'Tambah Banner Venue | Sportpedia',
      'active' => 'venue-myvenue',
      'validation' => \Config\Services::validation(),
    ];
    return view('dashboard/venue/myvenue/banners/add', $data);
  }


  public function save()
  {
    if (!$this->validate([
      'image' => [
        'rules'  => 'uploaded[image]|max_size[image,5024]|ext_in[image,png,jpg,jpeg,svg]',
        'errors' => [
          'ext_in' => "Extension must Image",
        ]
      ],
    ])) {
      return redirect()->to('/admin/banners/add')->withInput()->with('errors', $this->validator->getErrors());;
    }

    $image = $this->request->getFile('image');
    $imageName = $image->getRandomName();
    $image->move('img/banners', $imageName);
    $this->bannersModel->save([
      'image' => $imageName,
      'user_id' => user()->id,
      'title' => $this->request->getVar('title'),
      'link' => $this->request->getVar('link'),
    ]);
    session()->setFlashdata('message', 'Banner baru berhasil ditambahkan!');
    return redirect()->to('/admin/banners');
  }
  // End add data


  // Edit data
  public function edit($id)
  {
    $data = [
      'title'  => 'Edit Banner | sportpedia',
      'active' => 'venue-myvenue',
      'validation' => \Config\Services::validation(),
      'banner'  => $this->bannersModel->getWhere(['id' => $id])->getRowArray(),
    ];
    return view('dashboard/venue/myvenue/banners/edit', $data);
  }

  public function update($id)
  {
    if (!$this->validate([
      'image' => [
        'rules'  => 'max_size[image,5024]|ext_in[image,png,jpg,jpeg,svg]',
        'errors' => [
          'ext_in' => "Extension must Image",
        ]
      ],
    ])) {
      return redirect()->to('/admin/banners/edit/' . $id)->withInput()->with('errors', $this->validator->getErrors());;
    }

    $image = $this->request->getFile('image');
    $oldImage = $this->request->getVar('old-image');
    if ($image->getError() == 4) {
      $imageName = $oldImage;
    } else {
      // pindahkan file
      $imageName = $image->getRandomName();
      $image->move('img/banners', $imageName);
      // hapus file lama
      unlink('img/banners/' . $oldImage);
    }

    $this->bannersModel->save([
      'id'    => $id,
      'image' => $imageName,
      'user_id' => user()->id,
      'link' => $this->request->getVar('link'),
      'title' => $this->request->getVar('title'),
    ]);
    session()->setFlashdata('message', 'Banner berhasil diubah!');
    return redirect()->to('/admin/banners');
  }

  // End Edit

  public function delete($id)
  {
    // cari role berdasarkan id
    $banner = $this->bannersModel->getWhere(['id' => $id])->getRowArray();

    unlink('img/banners/' . $banner['image']);
    $this->bannersModel->delete($id);
    session()->setFlashdata('message', 'Banner berhasil dihapus!');
    return redirect()->to('/admin/banners');
  }
}
