<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\FacilitiesModel;
use App\Models\VenueModel;

class Facilities extends BaseController
{
  protected $facilitiesModel;
  protected $venueModel;

  public function __construct()
  {
    $this->facilitiesModel = new FacilitiesModel();
    $this->venueModel = new VenueModel();
  }

  public function index()
  {
    $data = [
      'title'  => 'Fasilitas',
      'active' => 'admin-facilities',
      'facilities'  => $this->facilitiesModel->get()->getResultArray()
    ];
    return view('dashboard/admin/facilities/index', $data);
  }

  // detail
  public function detail($id)
  {
    $data = [
      'title'  => 'Detail Fasilitas',
      'active' => 'admin-facilities',
      'facility' => $this->facilitiesModel->getWhere(['id' => $id])->getRowArray(),
    ];
    // dd($data);
    return view('dashboard/admin/facilities/detail', $data);
  }



  // Add Data
  public function add()
  {
    $data = [
      'title'  => 'Tambah Fasilitas',
      'active' => 'admin-facilities',
      'validation' => \Config\Services::validation(),
    ];
    return view('dashboard/admin/facilities/add', $data);
  }


  public function save()
  {
    if (!$this->validate([
      'facility_name' => 'required|is_unique[facilities.facility_name]',
      'icon' => 'required',
      'active' => 'required'
    ])) {
      return redirect()->to('/admin/facilities/add')->withInput()->with('errors', $this->validator->getErrors());
    }
    $this->facilitiesModel->save([
      'facility_name' => $this->request->getVar('facility_name'),
      'icon' => $this->request->getVar('icon'),
      'active' => $this->request->getVar('active'),
      'description' => $this->request->getVar('description'),
    ]);
    session()->setFlashdata('message', 'Fasilitas baru berhasil ditambahkan!');
    return redirect()->to('/admin/facilities');
  }
  // End add data


  // Edit data
  public function edit($id)
  {
    $data = [
      'title'  => 'Edit Fasilitas',
      'active' => 'admin-facilities',
      'validation' => \Config\Services::validation(),
      'facility'  => $this->facilitiesModel->getWhere(['id' => $id])->getRowArray(),
    ];
    return view('dashboard/admin/facilities/edit', $data);
  }

  public function update($id)
  {
    $oldVacility = $this->facilitiesModel->getWhere(['id' => $id])->getRowArray();
    $vacility = $this->request->getVar('facility_name');
    ($oldVacility['facility_name'] != $vacility) ? $rules = "|is_unique[facilities.facility_name]" : $rules = '';
    if (!$this->validate([
      'facility_name' => 'required' . $rules,
      'icon' => 'required',
      'active' => 'required',
    ])) {
      return redirect()->to('/admin/facilities/edit/' . $id)->withInput()->with('errors', $this->validator->getErrors());
    }
    $this->facilitiesModel->save([
      'id'    => $id,
      'facility_name' => $this->request->getVar('facility_name'),
      'icon' => $this->request->getVar('icon'),
      'active' => $this->request->getVar('active'),
      'description' => $this->request->getVar('description'),
    ]);
    session()->setFlashdata('message', 'Data fasilitas berhasil diubah!');
    return redirect()->to('/admin/facilities/');
  }

  // End Edit

  public function delete($id)
  {
    // cari role berdasarkan id
    $this->facilitiesModel->delete($id);
    session()->setFlashdata('message', 'Data fasilitas berhasil dihapus!');
    return redirect()->to('/admin/facilities');
  }
}
