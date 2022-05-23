<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\SportsModel;
use App\Models\SpecificationsModel;
use App\Models\ArenaModel;

class Specifications extends BaseController
{

  protected $sportsModel;
  protected $specificationsModel;
  protected $arenaModel;

  public function __construct()
  {
    $this->sportsModel = new SportsModel();
    $this->specificationsModel = new SpecificationsModel();
    $this->arenaModel = new ArenaModel();
    helper('text');
  }

  public function index()
  {
    $data = [
      'title'  => 'Spesifikasi ',
      'active' => 'admin-specifications',
      'specifications'  => $this->specificationsModel->get()->getResultArray(),
    ];
    // dd($data);
    return view('dashboard/admin/specifications/index', $data);
  }
  // detail
  public function detail($id)
  {
    $data = [
      'title'  => 'Detail Spesifikasi',
      'active' => 'admin-specifications',
      'spec' => $this->specificationsModel->getWhere(['id' => $id])->getRowArray(),
      'sports' => $this->sportsModel->get()->getResultArray()
    ];

    return view('dashboard/admin/specifications/detail', $data);
  }
  // Add Data
  public function add()
  {
    $data = [
      'title'  => 'Tambah Spesifikasi',
      'active' => 'admin-specifications',
      'sports' => $this->sportsModel->get()->getResultArray(),
      'validation' => \Config\Services::validation(),
    ];
    return view('dashboard/admin/specifications/add', $data);
  }
  public function save()
  {
    if (!$this->validate([
      'spec_name' => 'required',
      'sport_id' => 'required',
    ])) {
      return redirect()->to('/admin/specifications/add')->withInput()->with('errors', $this->validator->getErrors());
    }
    $this->specificationsModel->save([
      'spec_name' => $this->request->getVar('spec_name'),
      'sport_id' => $this->request->getVar('sport_id'),
      'description' => $this->request->getVar('description'),
    ]);
    session()->setFlashdata('message', 'Spesifikasi baru berhasil ditambahkan!');
    return redirect()->to('/admin/specifications');
  }
  // End add data

  // Edit data
  public function edit($id)
  {
    $data = [
      'title'  => 'Edit Spesifikasi',
      'active' => 'admin-specifications',
      'validation' => \Config\Services::validation(),
      'spec' => $this->specificationsModel->getWhere(['id' => $id])->getRowArray(),
      'sports' => $this->sportsModel->get()->getResultArray()
    ];
    return view('dashboard/admin/specifications/edit', $data);
  }

  public function update($id)
  {
    if (!$this->validate([
      'spec_name' => 'required',
      'sport_id' => 'required',
    ])) {
      return redirect()->to('/admin/specifications/edit/' . $id)->withInput()->with('errors', $this->validator->getErrors());
    }

    $this->specificationsModel->save([
      'id'    => $id,
      'spec_name' => $this->request->getVar('spec_name'),
      'sport_id' => $this->request->getVar('sport_id'),
      'description' => $this->request->getVar('description'),
    ]);
    session()->setFlashdata('message', 'Spesifikasi berhasil diubah!');
    return redirect()->to('/admin/specifications');
  }

  // End Edit

  public function delete($id)
  {
    $sport = $this->specificationsModel->getWhere(['id' => $id])->getRowArray();
    $this->specificationsModel->delete($id);
    session()->setFlashdata('message', 'Spesifikasi berhasil dihapus!');
    return redirect()->to('/admin/specifications');
  }
}
