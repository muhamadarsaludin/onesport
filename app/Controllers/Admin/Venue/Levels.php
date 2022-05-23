<?php

namespace App\Controllers\Admin\Venue;

use App\Controllers\BaseController;

use App\Models\VenueModel;
use App\Models\VenueLevelsModel;

class Levels extends BaseController
{
  protected $venueModel;
  protected $venueLevelsModel;


  public function __construct()
  {
    $this->venueModel = new VenueModel();
    $this->venueLevelsModel = new VenueLevelsModel();
  }


  public function index()
  {
    $data = [
      'title'  => 'Level Venue | Sportpedia',
      'active' => 'admin-venue',
      'levels'  => $this->venueLevelsModel->get()->getResultArray(),
    ];
    // dd($data);
    return view('dashboard/admin/venue/levels/index', $data);
  }


  // detail
  public function detail($id)
  {
    $data = [
      'title'  => 'Detail Level | Sportpedia',
      'active' => 'admin-venue',
      'level' => $this->venueLevelsModel->getWhere(['id' => $id])->getRowArray(),
    ];
    // dd($data);
    return view('dashboard/admin/venue/levels/detail', $data);
  }

  // Add Data
  public function add()
  {
    $data = [
      'title'  => 'Tambah Level | Sportpedia',
      'active' => 'admin-venue',
      'validation' => \Config\Services::validation(),
    ];
    return view('dashboard/admin/venue/levels/add', $data);
  }
  public function save()
  {
    if (!$this->validate([
      'level_name' => 'required|is_unique[venue_levels.level_name]'
    ])) {
      return redirect()->to('/admin/venue/levels/add')->withInput()->with('errors', $this->validator->getErrors());
    }
    $this->venueLevelsModel->save([
      'level_name' => $this->request->getVar('level_name'),
      'description' => $this->request->getVar('description'),
    ]);
    session()->setFlashdata('message', 'Level baru berhasil ditambahkan!');
    return redirect()->to('/admin/venue/levels');
  }


  // Edit data
  public function edit($id)
  {
    $data = [
      'title'  => 'Edit Level | sportpedia',
      'active' => 'admin-venue',
      'validation' => \Config\Services::validation(),
      'level'  => $this->venueLevelsModel->getWhere(['id' => $id])->getRowArray(),
    ];
    return view('dashboard/admin/venue/levels/edit', $data);
  }

  public function update($id)
  {
    $level = $this->venueLevelsModel->getWhere(['id' => $id])->getRowArray();
    $levelRules = '';
    if ($level['level_name'] != $this->request->getVar('level_name')) {
      $levelRules = '|is_unique[venue_levels.level_name]';
    }
    if (!$this->validate([
      'level_name' => 'required' . $levelRules,
    ])) {
      return redirect()->to('/admin/venue/levels/edit/' . $id)->withInput()->with('errors', $this->validator->getErrors());
    }
    $this->venueLevelsModel->save([
      'id'    => $id,
      'level_name' => $this->request->getVar('level_name'),
      'description' => $this->request->getVar('description'),
    ]);
    session()->setFlashdata('message', 'Level berhasil diubah!');
    return redirect()->to('/admin/venue/levels/');
  }
  // End Edit

  public function delete($id)
  {
    // cari role berdasarkan id
    $this->venueLevelsModel->delete($id);
    session()->setFlashdata('message', 'level berhasil dihapus!');
    return redirect()->to('/admin/venue/levels');
  }
}
