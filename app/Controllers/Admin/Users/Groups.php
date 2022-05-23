<?php

namespace App\Controllers\Admin\Users;

use App\Controllers\BaseController;
use App\Models\GroupsModel;
use App\Models\UsersModel;

class Groups
extends BaseController
{
  protected $roleModel;


  public function __construct()
  {
    $this->groupsModel = new GroupsModel();
  }


  public function index()
  {
    $data = [
      'title'  => 'Group User | Sportpedia',
      'active' => 'admin-users',
      'groups'  => $this->groupsModel->get()->getResultArray()
    ];
    // dd($data);
    return view('dashboard/admin/users/groups/index', $data);
  }


  // detail
  public function detail($id)
  {
    $data = [
      'title'  => 'Detail Group | Sportpedia',
      'active' => 'admin-users',
      'group' => $this->groupsModel->getWhere(['id' => $id])->getRowArray(),
    ];
    // dd($data);
    return view('dashboard/admin/users/groups/detail', $data);
  }

  // Add Data
  public function add()
  {
    $data = [
      'title'  => 'Tambah groups | Sportpedia',
      'active' => 'admin-users',
      'validation' => \Config\Services::validation(),
    ];
    return view('dashboard/admin/users/groups/add', $data);
  }
  public function save()
  {
    if (!$this->validate([
      'name' => 'required|is_unique[auth_groups.name]'
    ])) {
      return redirect()->to('/admin/users/groups/add')->withInput()->with('errors', $this->validator->getErrors());
    }
    $this->groupsModel->save([
      'name' => $this->request->getVar('name'),
      'description' => $this->request->getVar('description'),
    ]);
    session()->setFlashdata('message', 'Group baru berhasil ditambahkan!');
    return redirect()->to('/admin/users/groups');
  }


  // Edit data
  public function edit($id)
  {
    $data = [
      'title'  => 'Edit Group | Sportpedia',
      'active' => 'admin-users',
      'validation' => \Config\Services::validation(),
      'group'  => $this->groupsModel->getWhere(['id' => $id])->getRowArray(),
    ];
    return view('dashboard/admin/users/groups/edit', $data);
  }

  public function update($id)
  {
    $group = $this->groupsModel->getWhere(['id' => $id])->getRowArray();
    $rulesName = "";
    if ($group['name'] != $this->request->getVar('name')) {
      $rulesName = "|is_unique[auth_groups.name]";
    }
    if (!$this->validate([
      'name' => 'required' . $rulesName,
    ])) {
      return redirect()->to('/admin/users/groups/edit/' . $id)->withInput()->with('errors', $this->validator->getErrors());
    }
    $this->groupsModel->save([
      'id'    => $id,
      'name' => $this->request->getVar('name'),
      'description' => $this->request->getVar('description'),
    ]);
    session()->setFlashdata('message', 'Group berhasil diubah!');
    return redirect()->to('/admin/users/groups');
  }
  // End Edit

  public function delete($id)
  {
    // cari role berdasarkan id
    $this->groupsModel->delete($id);
    session()->setFlashdata('message', 'Group berhasil dihapus!');
    return redirect()->to('/admin/users/groups');
  }
}
