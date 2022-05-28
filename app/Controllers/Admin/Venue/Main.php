<?php

namespace App\Controllers\Admin\Venue;

use App\Controllers\BaseController;
use App\Libraries\Pdf;
use App\Models\VenueModel;
use App\Models\VenueLevelsModel;
use App\Models\UsersModel;
use App\Models\GroupsModel;
use App\Models\GroupsUsersModel;

class Main extends BaseController
{
  protected $venueModel;
  protected $venueLevelsModel;
  protected $usersModel;
  protected $groupsModel;
  protected $groupsUsersModel;


  public function __construct()
  {
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
      'title'  => 'Daftar Venue',
      'active' => 'admin-venue',
      'venues'  => $this->venueModel->getAllVenue()->getResultArray(),
    ];
    // dd($data);
    return view('dashboard/admin/venue/main/index', $data);
  }


  // detail
  public function detail($id)
  {
    $data = [
      'title'  => 'Detail Venue',
      'active' => 'admin-venue',
      'venue' => $this->venueModel->getWhere(['id' => $id])->getRowArray(),
      'levels' => $this->venueLevelsModel->get()->getResultArray(),
    ];
    $data['owner'] = $this->usersModel->getWhere(['id' => $data['venue']['user_id']])->getRowArray();
    // dd($data);
    return view('dashboard/admin/venue/main/detail', $data);
  }

  // Add Data
  public function add()
  {
    $data = [
      'title'  => 'Tambah Venue',
      'active' => 'admin-venue',
      'validation' => \Config\Services::validation(),
      'levels' => $this->venueLevelsModel->get()->getResultArray()
    ];
    return view('dashboard/admin/venue/main/add', $data);
  }
  public function save()
  {
    if (!$this->validate([
      'venue_name' => 'required|is_unique[venue.venue_name]',
      'email' => 'required|valid_email',
      'contact' => 'required',
      'level_id' => 'required',
      'city' => 'required',
      'province' => 'required',
      'postal_code' => 'required',
      'address' => 'required',
      'description' => 'required',
      'logo' => [
        'rules'  => 'uploaded[logo]|max_size[logo,5024]|ext_in[logo,png,jpg,jpeg,svg]',
        'errors' => [
          'ext_in' => "Extension must Image",
        ]
      ],
    ])) {
      return redirect()->to('/admin/venue/main/add')->withInput()->with('errors', $this->validator->getErrors());
    }
    $user = $this->usersModel->getWhere(['email' => $this->request->getVar('email')])->getRowArray();
    $venueName = $this->request->getVar('venue_name');
    $slug = strtolower(url_title($venueName, '-') . '-' . random_string('numeric', 4));
    $logo = $this->request->getFile('logo');
    $logoName = $logo->getRandomName();
    $logo->move('img/venue/logos', $logoName);

    $this->venueModel->save([
      'venue_name' => $venueName,
      'user_id' => $user['id'],
      'slug' => $slug,
      'level_id' => $this->request->getVar('level_id'),
      'logo' => $logoName,
      'city' => $this->request->getVar('city'),
      'province' => $this->request->getVar('province'),
      'postal_code' => $this->request->getVar('postal_code'),
      'address' => $this->request->getVar('address'),
      'description' => $this->request->getVar('description'),
    ]);

    // Change role user to venue
    $venueGroup = $this->groupsModel->getWhere(['name' => 'venue'])->getRowArray();
    $myGroup = $this->groupsUsersModel->getWhere(['user_id' => $user['id']])->getRowArray();
    $this->groupsUsersModel->save([
      'id' => $myGroup['id'],
      'group_id' => $venueGroup['id'],
    ]);

    session()->setFlashdata('message', 'Venue baru berhasil ditambahkan!');
    return redirect()->to('/admin/venue/main');
  }


  // Edit data
  public function edit($id)
  {
    $data = [
      'title'  => 'Edit Venue',
      'active' => 'admin-venue',
      'validation' => \Config\Services::validation(),
      'levels' => $this->venueLevelsModel->get()->getResultArray(),
      'venue' => $this->venueModel->getWhere(['id' => $id])->getRowArray(),
    ];
    $data['owner'] = $this->usersModel->getWhere(['id' => $data['venue']['user_id']])->getRowArray();
    // dd($data);
    return view('dashboard/admin/venue/main/edit', $data);
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
      'email' => 'required|valid_email',
      'level_id' => 'required',
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


    $user = $this->usersModel->getWhere(['email' => $this->request->getVar('email')])->getRowArray();
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
      'user_id' => $user['id'],
      'slug' => $slug,
      'level_id' => $this->request->getVar('level_id'),
      'logo' => $logoName,
      'city' => $this->request->getVar('city'),
      'province' => $this->request->getVar('province'),
      'postal_code' => $this->request->getVar('postal_code'),
      'address' => $this->request->getVar('address'),
      'description' => $this->request->getVar('description'),
    ]);
    session()->setFlashdata('message', 'Venue berhasil diubah!');
    return redirect()->to('/admin/venue/main');
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

  public function report()
  {
    $pdf = new Pdf();
    $reportedAt = date('YmdS-His');
    $timeReportedAt = strtotime(preg_replace('/(\d+)(\w+)-(\d+)/i', '$1$3', $reportedAt));

    $data = [
      'title' => "Venue Report " . date('M', $timeReportedAt) . ", " . date("Y", $timeReportedAt),
      'venue' => $this->venueModel->getAllVenue()->getResultObject(),
    ];

    $pdf->setPaper('A4', 'landscape');
    $pdf->filename = "venue_report_" . $reportedAt;
    $pdf->loadView('dashboard/admin/venue/main/report', $data);
  }
}
