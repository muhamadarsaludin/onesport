<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\SportsModel;
use App\Models\ArenaModel;

class Sports extends BaseController
{

  protected $sportsModel;
  protected $sportModel;

  public function __construct()
  {
    $this->sportsModel = new SportsModel();
    $this->arenaModel = new ArenaModel();
    helper('text');
  }

  public function index()
  {
    $data = [
      'title'  => 'Olahraga | Sportpedia',
      'active' => 'admin-sports',
      'sports'  => $this->sportsModel->get()->getResultArray(),
    ];
    // dd($data);
    return view('dashboard/admin/sports/index', $data);
  }
  // detail
  public function detail($id)
  {
    $data = [
      'title'  => 'Detail Olahraga | Sportpedia',
      'active' => 'admin-sports',
      'sport' => $this->sportsModel->getWhere(['id' => $id])->getRowArray(),
      // 'arenas' => $this->arenaModel->getArenaBySportId($id),
    ];
    // dd($data);
    return view('dashboard/admin/sports/detail', $data);
  }
  // Add Data
  public function add()
  {
    $data = [
      'title'  => 'Tambah Olahraga | Sportpedia',
      'active' => 'admin-sports',
      'validation' => \Config\Services::validation(),
    ];
    return view('dashboard/admin/sports/add', $data);
  }
  public function save()
  {
    if (!$this->validate([
      'sport_name' => 'required|is_unique[sports.sport_name]',
      'sport_icon' => [
        'rules'  => 'uploaded[sport_icon]|max_size[sport_icon,5024]|ext_in[sport_icon,png,jpg,jpeg,svg]'
      ],
    ])) {
      return redirect()->to('/admin/sports/add')->withInput()->with('errors', $this->validator->getErrors());
    }

    $name = $this->request->getVar('sport_name');
    $icon = $this->request->getFile('sport_icon');
    $iconName = $icon->getRandomName();
    $icon->move('img/sports', $iconName);
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

    $this->sportsModel->save([
      'sport_name' => $name,
      'sport_icon' => $iconName,
      'slug' => $slug,
      'description' => $this->request->getVar('description'),
    ]);
    session()->setFlashdata('message', 'Olahraga baru berhasil ditambahkan!');
    return redirect()->to('/admin/sports');
  }
  // End add data


  // Edit data
  public function edit($id)
  {
    $data = [
      'title'  => 'Edit Olahraga | sportpedia',
      'active' => 'admin-sports',
      'validation' => \Config\Services::validation(),
      'sport'  => $this->sportsModel->getWhere(['id' => $id])->getRowArray(),
    ];
    return view('dashboard/admin/sports/edit', $data);
  }

  public function update($id)
  {
    $sport = $this->sportsModel->getWhere(['id' => $id])->getRowArray();
    $sportName = $this->request->getVar('sport_name');
    if ($sport['sport_name'] == $sportName) {
      $rulesSportName = 'required';
      $slug = $sport['slug'];
    } else {
      $rulesSportName = 'required|is_unique[sports.sport_name]';
      $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $sportName)));
    }

    if (!$this->validate([
      'sport_name' => $rulesSportName,
      'sport_icon' => [
        'rules'  => 'max_size[sport_icon,5024]|ext_in[sport_icon,png,jpg,jpeg,svg]'
      ],
    ])) {
      return redirect()->to('/admin/sports/edit/' . $id)->withInput()->with('errors', $this->validator->getErrors());
    }

    $icon = $this->request->getFile('sport_icon');
    $oldIcon = $sport['sport_icon'];
    if ($icon->getError() == 4) {
      $iconName = $oldIcon;
    } else {
      // pindahkan file
      $iconName = $icon->getRandomName();
      $icon->move('img/sports', $iconName);
      // hapus file lama
      unlink('img/sports/' . $oldIcon);
    }
    $this->sportsModel->save([
      'id'    => $id,
      'sport_icon' => $iconName,
      'sport_name' => $sportName,
      'slug' => $slug,
      'description' => $this->request->getVar('description'),
    ]);
    session()->setFlashdata('message', 'Data olahraga berhasil diubah!');
    return redirect()->to('/admin/sports');
  }

  // End Edit

  public function delete($id)
  {

    $sport = $this->sportsModel->getWhere(['id' => $id])->getRowArray();
    unlink('img/sports/' . $sport['sport_icon']);
    $this->sportsModel->delete($id);
    session()->setFlashdata('message', 'Data olahraga berhasil dihapus!');
    return redirect()->to('/admin/sports');
  }
}
