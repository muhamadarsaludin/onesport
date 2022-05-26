<?php

namespace App\Controllers\Venue\MyVenue;

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
    $this->arenaModel = new ArenaModel();
    $this->arenaImagesModel = new ArenaImagesModel();
    $this->arenaFacilitiesModel = new ArenaFacilitiesModel();
    $this->bannersModel = new BannersModel();
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
      'title' => 'Arena',
      'active' => 'venue-myvenue',
      'banners' => $this->bannersModel->getWhere(['venue_id' => venue()->id, 'active' => 1])->getResultArray(),
      'venue' => $this->venueModel->getVenueBySlug(venue()->slug)->getRowArray(),
    ];
    // dd($data);
    return view('dashboard/venue/myvenue/index', $data);
  }

  // Edit data
  public function edit()
  {
    $data = [
      'title'  => 'Edit Venue',
      'active' => 'venue-myvenue',
      'validation' => \Config\Services::validation(),
      'venue' => $this->venueModel->getWhere(['id' => venue()->id])->getRowArray(),
    ];
    
    return view('dashboard/venue/myvenue/edit', $data);
  }
  public function update($id)
  {
    $venue = $this->venueModel->getWhere(['id' => $id])->getRowArray();
    $rulesVenueName = 'required';
    $slug = $venue['slug'];

    if ($venue['venue_name'] != $this->request->getVar('venue_name')) {
      $rulesVenueName = 'required|is_unique[venue.venue_name]';
      $slug = strtolower(url_title($this->request->getVar('venue_name'), '-') . '-' . random_string('numeric', 4));
    }

    if (!$this->validate([
      'venue_name' => $rulesVenueName,
      'city' => 'required',
      'province' => 'required',
      'postal_code' => 'required',
      'address' => 'required',
      'description' => 'required',
      'logo' => [
        'rules'  => 'max_size[logo,5024]|ext_in[logo,png,jpg,jpeg,svg]',
        'errors' => [
          'ext_in' => "Extension must Image",
        ]
      ],
    ])) {
      return redirect()->to('/admin/venue/main/edit/' . $id)->withInput()->with('errors', $this->validator->getErrors());
    }

    $logo = $this->request->getFile('logo');
    if ($logo->getError() == 4) {
      $logoName = $venue['logo'];
    } else {
      // pindahkan file
      $logoName = $logo->getRandomName();
      $logo->move('img/venue/logos', $logoName);
      // hapus file lama
      if ($venue['logo'] != 'default.png') {
        unlink('img/venue/logos/' . $venue['logo']);
      }
    }
    $this->venueModel->save([
      'id' => $id,
      'venue_name' => $this->request->getVar('venue_name'),
      'contact' => $this->request->getVar('contact'),
      'slug' => $slug,
      'logo' => $logoName,
      'city' => $this->request->getVar('city'),
      'province' => $this->request->getVar('province'),
      'postal_code' => $this->request->getVar('postal_code'),
      'address' => $this->request->getVar('address'),
      'description' => $this->request->getVar('description'),
    ]);
    session()->setFlashdata('message', 'Venue berhasil diubah!');
    return redirect()->to('/venue/myvenue/main');
  }
  // End Edit

  public function delete($id)
  {
    // cari role berdasarkan id
    $venue = $this->venueModel->getWhere(['id' => $id])->getRowArray();
    if ($venue['logo'] != 'default.png') {
      unlink('img/venue/logos/' . $venue['logo']);
    }

    // Change role from owner to user
    $venueGroup = $this->groupsModel->getWhere(['name' => 'user'])->getRowArray();
    $myGroup = $this->groupsUsersModel->getWhere(['user_id' => $venue['user_id']])->getRowArray();
    $this->groupsUsersModel->save([
      'id' => $myGroup['id'],
      'group_id' => $venueGroup['id'],
    ]);

    $this->venueModel->delete($id);
    session()->setFlashdata('message', 'venue berhasil dihapus!');
    return redirect()->to('/admin/venue/main');
  }
}
