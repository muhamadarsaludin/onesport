<?php

namespace App\Controllers\Venue\Arena\Field;

use App\Controllers\BaseController;

use App\Libraries\Pdf;
use App\Models\SpecificationsModel;
use App\Models\ArenaModel;
use App\Models\ArenaImagesModel;
use App\Models\ArenaFacilitiesModel;
use App\Models\FieldsModel;
use App\Models\FieldImagesModel;
use App\Models\FieldSpecificationsModel;
use App\Models\FacilitiesModel;
use App\Models\SportsModel;
use App\Models\VenueModel;
use App\Models\VenueLevelsModel;
use App\Models\UsersModel;
use App\Models\GroupsModel;
use App\Models\GroupsUsersModel;
use App\Models\DayModel;
use App\Models\ScheduleModel;
use App\Models\ScheduleDetailModel;


class Main extends BaseController
{
  protected $specificationsModel;
  protected $arenaModel;
  protected $arenaImagesModel;
  protected $arenaFacilitiesModel;
  protected $fieldsModel;
  protected $fieldImagesModel;
  protected $fieldSpecificationsModel;
  protected $facilitiesModel;
  protected $sportsModel;
  protected $venueModel;
  protected $venueLevelsModel;
  protected $usersModel;
  protected $groupsModel;
  protected $groupsUsersModel;
  protected $dayModel;
  protected $scheduleModel;
  protected $scheduleDetailModel;


  public function __construct()
  {
    $this->specificationsModel = new SpecificationsModel();
    $this->arenaModel = new ArenaModel();
    $this->arenaImagesModel = new ArenaImagesModel();
    $this->arenaFacilitiesModel = new ArenaFacilitiesModel();
    $this->fieldsModel = new FieldsModel();
    $this->fieldImagesModel = new FieldImagesModel();
    $this->fieldSpecificationsModel = new FieldSpecificationsModel();
    $this->facilitiesModel = new FacilitiesModel();
    $this->sportsModel = new SportsModel();
    $this->venueModel = new VenueModel();
    $this->venueLevelsModel = new VenueLevelsModel();
    $this->usersModel = new UsersModel();
    $this->groupsModel = new GroupsModel();
    $this->groupsUsersModel = new GroupsUsersModel();
    $this->dayModel = new DayModel();
    $this->scheduleModel = new ScheduleModel();
    $this->scheduleDetailModel = new ScheduleDetailModel();
    helper('text');
  }

  public function add($slug)
  {
    $arena = $this->arenaModel->getArenaBySlug($slug)->getRowArray();
    $data = [
      'title'  => 'Tambah Lapangan',
      'active' => 'venue-arena',
      'arena' => $arena,
      'specs' => $this->specificationsModel->getWhere(['sport_id' => $arena['sport_id']])->getResultArray(),
      'validation' => \Config\Services::validation(),
    ];
    // dd($data);
    return view('dashboard/venue/arena/field/add', $data);
  }

  public function save($arenaSlug)
  {
    $rules =[
      'arena_id' => 'required',
      'field_name' => 'required',
      'field_image' => [
        'rules'  => 'uploaded[field_image]|max_size[field_image,5024]|ext_in[field_image,png,jpg,jpeg]',
        'errors' => [
          'ext_in' => "Extension must Image",
        ]
      ],
      'image-1' => 'max_size[image-1,5024]|ext_in[image-1,png,jpg,jpeg]',
      'image-2' => 'max_size[image-2,5024]|ext_in[image-2,png,jpg,jpeg]',
      'image-3' => 'max_size[image-3,5024]|ext_in[image-3,png,jpg,jpeg]',
      'image-4' => 'max_size[image-4,5024]|ext_in[image-4,png,jpg,jpeg]',
    ];

    $arena = $this->arenaModel->getArenaBySlug($arenaSlug)->getRowArray();
    $specs = $this->specificationsModel->getWhere(['sport_id' => $arena['sport_id']])->getResultArray();
    foreach ($specs as $spec) {
      $rules['spec-'.$spec['id']] = 'required';
    }
    

    if (!$this->validate($rules)) {
      return redirect()->to('/venue/arena/field/main/add/' . $this->request->getVar('arena_slug'))->withInput()->with('errors', $this->validator->getErrors());
    }

    $image = $this->request->getFile('field_image');
    $imageName = $image->getRandomName();
    $image->move('img/venue/arena/fields/main-images', $imageName);
    $fieldName = $this->request->getVar('field_name');
    $slug = strtolower(url_title($fieldName, '-') . '-' . random_string('numeric', 4));

    $this->fieldsModel->save([
      'arena_id' => $this->request->getVar('arena_id'),
      'field_name' => $fieldName,
      'field_image' => $imageName,
      'slug' => $slug,
      'description' => $this->request->getVar('description'),
    ]);
    $field = $this->fieldsModel->getWhere(['slug' => $slug])->getRowArray();

    // SPESIFIKASI
    foreach ($specs as $spec) {
      $this->fieldSpecificationsModel->save([
        'field_id' => $field['id'],
        'spec_id' => $spec['id'],
        'value' => $this->request->getVar('spec-'.$spec['id'])
      ]);
    }

    $images = [];
    for ($i = 1; $i <= 4; $i++) {
      # code...
      array_push($images, $this->request->getFile('image-' . $i));
    }
    foreach ($images as $image) {
      if (!$image->getError() == 4) {
        // pindahkan file
        $imageName = $image->getRandomName();
        $image->move('img/venue/arena/fields/other-images', $imageName);
        $this->fieldImagesModel->save([
          'field_id' => $field['id'],
          'image' => $imageName
        ]);
      }
    }
    session()->setFlashdata('message', 'Lapangan berhasil ditambahkan!');
    return redirect()->to('/venue/arena/main/detail/' .  $this->request->getVar('arena_slug'));
  }

  // Detail Lapangan
  public function detail($slug)
  {
    $data = [
      'title' => 'Detail Lapangan',
      'field' => $this->fieldsModel->getWhere(['slug' => $slug])->getRowArray(),
      'days'  => $this->dayModel->get()->getResultArray(),
    ];
    $data['specs'] = $this->fieldSpecificationsModel->getSpecByFieldId($data['field']['id'])->getResultArray();
    $data['images'] = $this->fieldImagesModel->getWhere(['field_id' => $data['field']['id']])->getResultArray();
    $data['schedules'] = $this->scheduleModel->getScheduleByFieldId($data['field']['id'])->getResultArray(); 

    // dd($data);
    return view('dashboard/venue/arena/field/detail', $data);
  }


  // EDIT
  public function edit($slug)
  {
    $data = [
      'title'  => 'Edit Lapangan',
      'active' => 'venue-arena',
      'field' => $this->fieldsModel->getwhere(['slug'=> $slug])->getRowArray(),
      'validation' => \Config\Services::validation(),
    ];
    $data['images']=$this->fieldImagesModel->getWhere(['field_id'=>$data['field']['id']])->getResultArray();
    $data['specs']=$this->fieldSpecificationsModel->getSpecByFieldId($data['field']['id'])->getResultArray();
    $data['arena']=$this->arenaModel->getWhere(['id'=>$data['field']['arena_id']])->getRowArray();
    // dd($data);
    return view('dashboard/venue/arena/field/edit', $data);
  }


  public function update($fieldSlug)
  {

    $rules =[
      'field_name' => 'required',
      'field_image' => [
        'rules'  => 'max_size[field_image,5024]|ext_in[field_image,png,jpg,jpeg]',
        'errors' => [
          'ext_in' => "Extension must Image",
        ]
      ],
      'image-1' => 'max_size[image-1,5024]|ext_in[image-1,png,jpg,jpeg]',
      'image-2' => 'max_size[image-2,5024]|ext_in[image-2,png,jpg,jpeg]',
      'image-3' => 'max_size[image-3,5024]|ext_in[image-3,png,jpg,jpeg]',
      'image-4' => 'max_size[image-4,5024]|ext_in[image-4,png,jpg,jpeg]',
    ];
    $field =  $this->fieldsModel->getwhere(['slug'=> $fieldSlug])->getRowArray();
    $arena = $this->arenaModel->getWhere(['id'=>$this->request->getVar('arena_id')])->getRowArray();
    $specs = $this->fieldSpecificationsModel->getSpecByFieldId($field['id'])->getResultArray();
    foreach ($specs as $spec) {
      $rules['spec-'.$spec['spec_id']] = 'required';
    }
    
    // dd($rules,$specs);
    if (!$this->validate($rules)) {
      return redirect()->to('/venue/arena/field/main/edit/' . $fieldSlug)->withInput()->with('errors', $this->validator->getErrors());
    }


   

    $fieldImage = $this->request->getFile('field_image');
    if ($fieldImage->getError() != 4) {
      unlink('img/venue/arena/fields/main-images/' . $field['field_image']);
      $field['field_image'] = $fieldImage->getRandomName();
      $fieldImage->move('img/venue/arena/fields/main-images', $field['field_image']);
    }

    if ($field['field_name'] != $this->request->getVar('field_name')) {
      $slug = strtolower(url_title($this->request->getVar('field_name'), '-') . '-' . random_string('numeric', 4));
      $field['field_name'] = $this->request->getVar('field_name');
      $field['slug'] = $slug;
    }
    if ($field['description'] != $this->request->getVar('description')) {
      $field['description'] = $this->request->getVar('description');
    }
    
    // simpan perubahan data field
    $this->fieldsModel->save($field);

    
     // IMAGES
     $oldImages = $this->fieldImagesModel->getWhere(['field_id'==$field['id']])->getResultArray();
     $images = [];
     for ($i = 1; $i <= 4; $i++) {
       array_push($images, $this->request->getFile('image-' . $i));
     }
 
     for($i=0; $i < count($oldImages); $i++){
       if (!$images[$i]->getError() == 4) {
         // gambar di ganti
         // dapat nama gambar baru
         $imageName = $images[$i]->getRandomName();
         // upload gambar baru
         $images[$i]->move('img/venue/arena/fields/other-images', $imageName);
         // hapus image lama
         unlink('img/venue/arena/fields/other-images/' . $oldImages[$i]['image']);
         // simpan data image baru
         $this->fieldImagesModel->save([
           'id' => $oldImages[$i]['id'],
           'image' => $imageName
         ]);
       }
     }
 
     // Gambar tambahan
     for($i=count($oldImages); $i < 4; $i++){
       if (!$images[$i]->getError() == 4) {
             $imageName = $images[$i]->getRandomName();
             $images[$i]->move('img/venue/arena/fields/other-images', $imageName);
             $this->fieldImagesModel->save([
               'field_id' => $field['id'],
               'image' => $imageName
             ]);
           }
     }


    // SPESIFIKASI
    foreach ($specs as $spec) {
      $this->fieldSpecificationsModel->save([
        'id' => $spec['id'],
        'value' => $this->request->getVar('spec-'.$spec['spec_id'])
      ]);  
    }
    session()->setFlashdata('message', 'Data Lapangan berhasil diedit!');
    return redirect()->to('/venue/arena/main/detail/'.$arena['slug']);
  }




  public function delete($id)
  {
    $field = $this->fieldsModel->getWhere(['id'=> $id ])->getRowArray();
    $arena = $this->arenaModel->getWhere(['id'=>$field['arena_id']])->getRowArray();
    $fieldImages = $this->fieldImagesModel->getWhere(['field_id'=>$id])->getResultArray();
    $fieldSpecs = $this->fieldSpecificationsModel->getWhere(['field_id'=>$id])->getResultArray();

    unlink('img/venue/arena/fields/main-images/' . $field['field_image']);
    $this->fieldsModel->delete($id);
    
    foreach ($fieldSpecs as $spec) {
      $this->fieldSpecificationsModel->delete($spec['id']);
    }
    
    // remove gambar
    foreach ($fieldImages as $image) {
      if ($image['image'] != 'default.png') {
        unlink('img/venue/arena/fields/other-images/' . $image['image']);
      }
      $this->fieldImagesModel->delete($image['id']);
    }
    session()->setFlashdata('message', 'Lapangan berhasil dihapus!');
    return redirect()->to('/venue/arena/main/detail/'.$arena['slug']);
  }


  public function report()
  {
    $pdf = new Pdf();
    $reportedAt = date('YmdS-His');
    $timeReportedAt = strtotime(preg_replace('/(\d+)(\w+)-(\d+)/i', '$1$3', $reportedAt));

    $data = [
      'title' => "Fields Report " . venue()->venue_name ." ". date('M', $timeReportedAt) . ", " . date("Y", $timeReportedAt),
      'fields' => $this->fieldsModel->getFieldsByVenueid(venue()->id)->getResultArray(),
    ];

    $pdf->setPaper('A4', 'landscape');
    $pdf->filename = "fields_report_" . $reportedAt;
    $pdf->loadView('dashboard/venue/arena/field/report', $data);
    exit();
  }

}
