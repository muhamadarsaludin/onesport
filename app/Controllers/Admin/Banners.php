<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\BannersModel;
use App\Models\VenueModel;

class Banners extends BaseController
{
  protected $BannersModel;
  protected $venueModel;

  public function __construct()
  {
    $this->bannersModel = new BannersModel();
    $this->venueModel = new VenueModel();
  }

  public function index()
  {
    $data = [
      'title'  => 'Banner Informasi',
      'active' => 'admin-banners',
      'banners'  => $this->bannersModel->getAllBanner()->getResultArray()
    ];
    // dd($data);
    return view('dashboard/admin/banners/index', $data);
  }

  // detail
  public function detail($id)
  {
    $data = [
      'title'  => 'Detail Banner',
      'active' => 'admin-banner',
      'banner' => $this->bannersModel->getWhere(['id' => $id])->getRowArray(),
    ];
    // dd($data);
    return view('dashboard/admin/banners/detail', $data);
  }
  // Add Data

  public function add()
  {
    $data = [
      'title'  => 'Buat Informasi',
      'active' => 'admin-banner',
      'validation' => \Config\Services::validation(),
    ];
    return view('dashboard/admin/banners/add', $data);
  }


  public function save()
  {
    if (!$this->validate([
      'image' => [
        'rules'  => 'uploaded[image]|max_size[image,5024]|ext_in[image,png,jpg,jpeg,svg]',
        'active' => 'required',
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
      'active' => $this->request->getVar('active'),
    ]);
    session()->setFlashdata('message', 'Banner baru berhasil ditambahkan!');
    return redirect()->to('/admin/banners');
  }
  // End add data


  // Edit data
  public function edit($id)
  {
    $data = [
      'title'  => 'Edit Banner',
      'active' => 'admin-banner',
      'validation' => \Config\Services::validation(),
      'banner'  => $this->bannersModel->getWhere(['id' => $id])->getRowArray(),
    ];
    return view('dashboard/admin/banners/edit', $data);
  }

  public function update($id)
  {
    if (!$this->validate([
      'image' => [
        'rules'  => 'max_size[image,5024]|ext_in[image,png,jpg,jpeg,svg]',
        'active' => 'required',
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
      'active' => $this->request->getVar('active'),
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
