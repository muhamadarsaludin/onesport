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


class Transaction extends BaseController
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
    helper('text');
  }


  public function index()
  {
    $data = [
      'title'  => 'Data Transaksi',
      'active' => 'venue-transaction',
      'transactions'  => $this->transactionModel->getAllTransaction()->getResultArray(),
    ];
    
    return view('dashboard/venue/transaction/index', $data);
  }
  public function downpayment()
  {
    $data = [
      'title'  => 'Data Downpayment',
      'active' => 'venue-transaction',
      'transactions'  => $this->transactionModel->getAllTransaction()->getResultArray(),
    ];
    
    return view('dashboard/venue/transaction/downpayment', $data);
  }
  public function canceled()
  {
    $data = [
      'title'  => 'Data Pembatalan Transaksi',
      'active' => 'venue-transaction',
      'transactions'  => $this->transactionModel->getAllTransaction()->getResultArray(),
    ];
    
    return view('dashboard/venue/transaction/canceled', $data);
  }
  public function failed()
  {
    $data = [
      'title'  => 'Data Transaksi Gagal',
      'active' => 'venue-transaction',
      'transactions'  => $this->transactionModel->getAllTransaction()->getResultArray(),
    ];
    
    return view('dashboard/venue/transaction/failed', $data);
  }

  public function detail($transCode)
  {

    $data = [
      'title'  => 'Detail Transaksi',
      'transaction' => $this->transactionModel->getWhere(['transaction_code' => $transCode])->getRowArray(),
      'details' => $this->transactionDetailModel->getTransactionDetailByTransactionCode($transCode)->getResultArray()
    ];
    return view('dashboard/venue/transaction/detail', $data);
  }

  public function delete($id)
  {
      $this->transactionModel->delete($id);
      session()->setFlashdata('message', 'Data transaksi berhasil dihapus!');
      return redirect()->to('/venue/transaction');
  }

  public function report_view()
  {
      $data = [
          'title' => 'Laporan Transaksi',
          'active' => 'admin-transaction',
          'date_min' => $this->transactionModel->getMinTransactionDate(venue()->id),
      ];

      return view('dashboard/venue/transaction/report_view', $data);
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
  }


 
}
