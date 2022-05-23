<?php

namespace App\Controllers\Admin\Users;

use App\Controllers\BaseController;
use App\Models\GroupsModel;
use App\Models\UsersModel;
use App\Models\GroupsUsersModel;

class Main extends BaseController
{
  protected $roleModel;


  public function __construct()
  {
    $this->groupsModel = new GroupsModel();
    $this->usersModel = new UsersModel();
    $this->groupsUsersModel = new GroupsUsersModel();
  }


  public function index()
  {
    $data = [
      'title'  => 'Daftar User | Sportpedia',
      'active' => 'admin-users',
      'users'  => $this->usersModel->get()->getResultArray()
    ];
    // dd($data);
    return view('dashboard/admin/users/main/index', $data);
  }


  // detail
  public function detail($id)
  {
    $data = [
      'title'  => 'Detail User | Sportpedia',
      'active' => 'admin-users',
      'user' => $this->usersModel->getWhere(['id' => $id])->getRowArray(),
    ];
    // dd($data);
    return view('dashboard/admin/users/main/detail', $data);
  }

  // Add Data
  public function add()
  {
    $data = [
      'title'  => 'Tambah User | Sportpedia',
      'active' => 'admin-users',
      'validation' => \Config\Services::validation(),
      'roles' => $this->rolesModel->get()->getResultArray()
    ];
    return view('dashboard/admin/users/main/add', $data);
  }
  public function save()
  {
    if (!$this->validate([
      'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
      'email'    => 'required|valid_email|is_unique[users.email]',
      'password'     => 'required|strong_password',
      'pass_confirm' => 'required|matches[password]',
    ])) {
      return redirect()->to('/admin/users/main/add')->withInput()->with('errors', $this->validator->getErrors());
    }
    $this->usersModel->save([
      'username' => $this->request->getVar('username'),
      'email' => $this->request->getVar('email'),
      'password_hash' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
      'active' => 1
    ]);
    $user = $this->usersModel->getWhere(['email' => $this->request->getVar('email')])->getRowArray();
    $this->groupsUsersModel->save([
      'group_id' => $this->request->getVar('role-id'),
      'user_id' => $user['id'],
    ]);

    session()->setFlashdata('message', 'User baru berhasil ditambahkan!');
    return redirect()->to('/admin/users/main');
  }


  // Edit data
  public function edit($id)
  {
    $data = [
      'title'  => 'Edit User | Sportpedia',
      'active' => 'admin-users',
      'validation' => \Config\Services::validation(),
      'user'  => $this->usersModel->getWhere(['id' => $id])->getRowArray(),
      'groups' => $this->groupsModel->get()->getResultArray()
    ];
    // dd($data);
    return view('dashboard/admin/users/main/edit', $data);
  }

  public function update($id)
  {

    // session()->setFlashdata('message', 'Data user berhasil diubah!');
    // return redirect()->to('/admin/users/main');
  }
  // End Edit

  public function delete($id)
  {
    // cari role berdasarkan id
    $this->usersModel->delete($id);
    session()->setFlashdata('message', 'User berhasil dihapus!');
    return redirect()->to('/admin/users/main');
  }
}
