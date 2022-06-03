<?php

namespace App\Controllers\Venue;

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
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\NotificationModel;


class Pos extends BaseController
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
  protected $transactionModel;
  protected $transactionDetailModel;
  protected $notificationModel;


  public function __construct()
  {
    $this->specificationsModel = new SpecificationsModel();
    $this->arenaModel = new ArenaModel();
    $this->arenaImagesModel = new ArenaImagesModel();
    $this->arenaFacilitiesModel = new ArenaFacilitiesModel();
    $this->fieldsModel = new FieldsModel();
    $this->fieldImagesModel = new FieldImagesModel();
    $this->fieldspecificationsModel = new FieldSpecificationsModel();
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
    $this->transactionModel = new TransactionModel();
    $this->transactionDetailModel = new TransactionDetailModel();
    $this->notificationModel = new NotificationModel();
    helper('text');
  }


  public function cek_transaction()
  {
    $data = [
      'title'  => 'Pengecekan Transaksi',
      'active' => 'venue-pos',
      'validation' => \Config\Services::validation(),
    ];
    
    return view('dashboard/venue/pos/cek', $data);
  }
  public function cek_result()
  {
    if (!$this->validate([
      'code' => 'required',
    ])) {
      return redirect()->to('/venue/pos/cek_transaction')->withInput()->with('errors', $this->validator->getErrors());;
    }
    
    $transCode = $this->request->getVar('code');
    $cekTransVenue = $this->transactionModel->cekTransVenue($transCode, venue()->id)->getRowArray();
    
    if(!$cekTransVenue){
      session()->setFlashdata('error', 'Transaksi tidak ditemukan!');
      return redirect()->to('/venue/pos/cek_transaction');
    }
    $data = [
      'title'  => 'Pengecekan Transaksi',
      'active' => 'venue-pos',
      'transaction' => $this->transactionModel->getWhere(['transaction_code' => $transCode])->getRowArray(),
      'details' => $this->transactionDetailModel->getTransactionDetailByTransactionCode($transCode)->getResultArray(),
    ];
    
    return view('dashboard/venue/pos/cek_result', $data);
  }

  public function use_ticket($transCode)
  {
    $transaction = $this->transactionModel->getWhere(['transaction_code'=>$transCode])->getRowArray();
    $this->transactionModel->save([
      'id' => $transaction['id'],
      'use_ticket' => 1
    ]);

    $this->notificationModel->save([
      'user_id' => $transaction['user_id'],
      'message' => "Tiket transaksi ".$transCode." berhasil digunakan selamat berolahraga!",
      'link'    => "/transaction/detail/".$transCode
    ]);
    session()->setFlashdata('message', 'Tiket transaksi berhasil digunakan!');
    return redirect()->to('/venue/pos/cek_transaction');
  }

  public function report_pdf($start_date, $end_date)
  {

    $pdf = new Pdf();
    $reportedAt = date('YmdS-His');
    $timeReportedAt = strtotime(preg_replace('/(\d+)(\w+)-(\d+)/i', '$1$3', $reportedAt));

    $data = [
      'title' => "Laporan Transaksi " . venue()->venue_name ."<br>". $start_date . " - " . $end_date,
      'transactions' => $this->transactionModel->getTransactionBetweenDate($start_date, $end_date)->getResultArray(),
    ];

    $pdf->setPaper('A4', 'landscape');
    $pdf->filename = "transaction_report_". venue()->slug ."_". $reportedAt;
    $pdf->loadView('dashboard/admin/transaction/report', $data);
    exit();
  }
}
