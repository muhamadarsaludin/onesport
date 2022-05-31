<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\GroupsUsersModel;
use App\Models\BannersModel;
use App\Models\SportsModel;
use App\Models\VenueModel;
use App\Models\VenueLevelsModel;
use App\Models\ArenaModel;
use App\Models\ArenaImagesModel;
use App\Models\ArenaFacilitiesModel;
use App\Models\FieldsModel;
use App\Models\FieldImagesModel;
use App\Models\FacilitiesModel;
use App\Models\DayModel;
use App\Models\ScheduleModel;
use App\Models\ScheduleDetailModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\RepaymentModel;
use App\Models\RatingModel;

class Dashboard extends BaseController
{
  protected $usersModel;
  protected $groupsUsersModel;
  protected $bannersModel;
  protected $sportsModel;
  protected $venueModel;
  protected $venueLevelsModel;
  protected $arenaModel;
  protected $arenaImagesModel;
  protected $arenaFacilitiesModel;
  protected $fieldsModel;
  protected $fieldImagesModel;
  protected $facilitiesModel;
  protected $dayModel;
  protected $scheduleModel;
  protected $scheduleDetailModel;
  protected $transactionModel;
  protected $transactionDetailModel;
  protected $repaymentModel;
  protected $ratingModel;


  public function __construct()
  {
    $this->usersModel = new UsersModel();
    $this->groupsUsersModel = new GroupsUsersModel();
    $this->bannersModel = new BannersModel();
    $this->sportsModel = new SportsModel();
    $this->venueModel = new VenueModel();
    $this->venueLevelsModel = new VenueLevelsModel();
    $this->arenaModel = new ArenaModel();
    $this->arenaImagesModel = new ArenaImagesModel();
    $this->arenaFacilitiesModel = new ArenaFacilitiesModel();
    $this->fieldsModel = new FieldsModel();
    $this->fieldImagesModel = new FieldImagesModel();
    $this->facilitiesModel = new FacilitiesModel();
    $this->dayModel = new DayModel();
    $this->scheduleModel = new ScheduleModel();
    $this->scheduleDetailModel = new ScheduleDetailModel();
    $this->transactionModel = new TransactionModel();
    $this->transactionDetailModel = new TransactionDetailModel();
    $this->repaymentModel = new RepaymentModel();
    $this->ratingModel = new RatingModel();
    helper('text');
  }

  public function index()
  {
    if(logged_in()){
      if(venue()){
        $data = [
          'title'  => 'Dashboard',
          'banners' => $this->bannersModel->get()->getResultArray(),
          'total_arena' => count($this->arenaModel->getWhere(['venue_id'=>venue()->id])->getResultArray()),
          'total_lapangan' => count($this->fieldsModel->getFieldsByVenueid(venue()->id)->getResultArray()),
          'total_transaksi' => count($this->transactionModel-> getTransactionByVenueId(venue()->id)->getResultArray()),
          'total_trans_success' => $this->transactionModel->getCountTransactionSuccess(venue()->id)->getResultArray(),
          'total_trans_pending' => $this->transactionModel->getCountTransactionPending(venue()->id)->getResultArray(),
          'total_trans_dp' => $this->transactionModel->getCountTransactionDP(venue()->id)->getResultArray(),
          'total_trans_cancel' => $this->transactionModel->getCountTransactionCancel(venue()->id)->getResultArray(),
          'total_trans_failed' => $this->transactionModel->getCountTransactionFailed(venue()->id)->getResultArray(),
        ];
        $earningsFullPayment = $this->transactionModel->earningsFullPayment(venue()->id)->getRowArray();
        $earningsRepayment = $this->transactionModel->earningsRepayment(venue()->id)->getRowArray();
        $earningsDP = $this->transactionModel->earningsDP()->getRowArray(venue()->id);
        $data['total_earnings'] = $earningsFullPayment['sum_pay'] + $earningsRepayment['sum_repay'] + $earningsDP['sum_dp'];
      }else{
        $data = [
          'title'  => 'Dashboard',
          'banners' => $this->bannersModel->getWhere(['venue_id' => null, 'active' => 1])->getResultArray(),
          'total_user' => $this->usersModel->countAll(),
          'total_venue' => $this->venueModel->countAll(),
          'total_arena' => $this->arenaModel->countAll(),
          'total_lapangan' => $this->fieldsModel->countAll(),
          'total_transaksi' => $this->transactionModel->countAll(),
          'total_trans_success' => $this->transactionModel->getCountTransactionSuccess()->getResultArray(),
          'total_trans_pending' => $this->transactionModel->getCountTransactionPending()->getResultArray(),
          'total_trans_dp' => $this->transactionModel->getCountTransactionDP()->getResultArray(),
          'total_trans_cancel' => $this->transactionModel->getCountTransactionCancel()->getResultArray(),
          'total_trans_failed' => $this->transactionModel->getCountTransactionFailed()->getResultArray()
        ];
        $earningsFullPayment = $this->transactionModel->earningsFullPayment()->getRowArray();
        $earningsRepayment = $this->transactionModel->earningsRepayment()->getRowArray();
        $earningsDP = $this->transactionModel->earningsDP()->getRowArray();
        $data['total_earnings'] = $earningsFullPayment['sum_pay'] + $earningsRepayment['sum_repay'] + $earningsDP['sum_dp'];
      }
      
      return view('dashboard/index', $data);
    }
  }
}
