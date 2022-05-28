<?php

namespace App\Controllers\Admin\Users;

use App\Controllers\BaseController;
use App\Libraries\Pdf;
use App\Models\GroupsModel;
use App\Models\UsersModel;
use App\Models\GroupsUsersModel;

class Main extends BaseController
{
  protected $usersModel;
  protected $groupsModel;
  protected $groupsUsersModel;


  public function __construct()
  {
    $this->groupsModel = new GroupsModel();
    $this->usersModel = new UsersModel();
    $this->groupsUsersModel = new GroupsUsersModel();
  }


  public function index()
  {
    $data = [
      'title'  => 'Daftar User',
      'active' => 'admin-users',
      'users'  => $this->usersModel->getAllUser()->getResultArray()
    ];
    return view('dashboard/admin/users/main/index', $data);
  }


  // detail
  public function detail($id)
  {
    $data = [
      'title'  => 'Detail User',
      'active' => 'admin-users',
      'user' => $this->usersModel->getUserById($id)->getRowArray(),
    ];
    // dd($data);
    return view('dashboard/admin/users/main/detail', $data);
  }

  // Edit data
  public function edit($id)
  {
    $data = [
      'title'  => 'Edit User',
      'active' => 'admin-users',
      'validation' => \Config\Services::validation(),
      'user'  => $this->usersModel->getUserById($id)->getRowArray(),
      'groups' => $this->groupsModel->get()->getResultArray()
    ];
    // dd($data);
    return view('dashboard/admin/users/main/edit', $data);
  }

  public function update($id)
  {
    $user = $this->usersModel->getWhere(['id' => $id])->getRowArray();
    $username = $this->request->getVar('username');
    $email = $this->request->getVar('email');

    if ($user['username'] == $username) {
      $rulesUsername = 'required';
    } else {
      $rulesUsername = 'required|is_unique[users.username]';
    }
    if ($user['email'] == $email) {
      $rulesEmail = 'required|valid_email';
    } else {
      $rulesEmail = 'required|valid_email|is_unique[users.email]';
    }

    if (!$this->validate([
      'username' => $rulesUsername,
      'email' => $rulesEmail,
      'user_image' => [
        'rules'  => 'max_size[user_image,5024]|ext_in[user_image,png,jpg,jpeg,svg]'
      ],
      'active' => 'required',
      'group_id' => 'required',

    ])) {
      return redirect()->to('/admin/users/main/edit/' . $id)->withInput()->with('errors', $this->validator->getErrors());
    }

    $image = $this->request->getFile('user_image');
    $oldImage = $user['user_image'];
    if ($image->getError() == 4) {
      $imageName = $oldImage;
    } else {
      // pindahkan file
      $imageName = $image->getRandomName();
      $image->move('img/users', $imageName);
      // hapus file lama
      if ($oldImage != 'default.png') {
        unlink('img/users/' . $oldImage);
      }
    }
    $this->usersModel->save([
      'id'    => $id,
      'username' => $username,
      'email' => $email,
      'user_image' => $imageName,
      'active' => $this->request->getVar('active'),
      'description' => $this->request->getVar('description'),
    ]);
    $groupUser = $this->groupsUsersModel->getWhere(['user_id' => $id])->getRowArray();
    $this->groupsUsersModel->save([
      'id' => $groupUser['id'],
      'group_id' => $this->request->getVar('group_id')
    ]);

    session()->setFlashdata('message', 'Data user berhasil diubah!');
    return redirect()->to('/admin/users/main');
  }
  // End Edit

  public function delete($id)
  {
    // cari role berdasarkan id
    $this->usersModel->delete($id);
    session()->setFlashdata('message', 'User berhasil dihapus!');
    return redirect()->to('/admin/users/main');
  }

  public function report()
  {
    $pdf = new Pdf();
    $reportedAt = date('YmdS-His');
    $timeReportedAt = strtotime(preg_replace('/(\d+)(\w+)-(\d+)/i', '$1$3', $reportedAt));

    $data = [
      'title' => "Users Report " . date('M', $timeReportedAt) . ", " . date("Y", $timeReportedAt),
      'users' => $this->usersModel->getAllUser()->getResultObject(),
    ];

    $pdf->setPaper('A4', 'landscape');
    $pdf->filename = "users_report_" . $reportedAt;
    $pdf->loadView('dashboard/admin/users/main/report', $data);
  }
}
