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
use PHPUnit\Util\Json;

class Transaction extends BaseController
{

  /**
   * Instance of the main Request object.
   *
   * @var HTTP\IncomingRequest
   */
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
    helper('text');
  }

  public function index()
  {
    $data = [
      'title'  => 'Transaksi',
      'transactions' => $this->transactionModel->getWhere(['user_id' => user_id()])->getResultArray(),
    ];
    return view('transaction/index', $data);
  }


  public function detail($transCode)
  {

    $data = [
      'title'  => 'Detail Transaksi',
      'transaction' => $this->transactionModel->getWhere(['transaction_code' => $transCode])->getRowArray(),
      'details' => $this->transactionDetailModel->getTransactionDetailByTransactionCode($transCode)->getResultArray()
    ];
    return view('transaction/detail', $data);
  }


  public function update()
  {
    $listOrder = $this->request->getVar('listOrder');
    $data = [];
    if ($listOrder) {
      foreach ($listOrder as $order) {
        $dataOrder = $this->scheduleDetailModel->getWhere(['id' => $order])->getRowArray();
        array_push($data, $dataOrder);
      }
    }
    return json_encode($data);
  }


  public function order()
  {
    $listOrder = $this->request->getVar('listOrder');
    $bookingDate = $this->request->getVar('bookingDate');
    $downPayment = $this->request->getVar('dp');
    $totalPay = 0;
    $data = [];

    $transCode = strtoupper('SPD-' . random_string('numeric', 6));

    
    $this->transactionModel->save([
      'user_id' => user_id(),
      'transaction_code' => $transCode,
      'transaction_date' => date('Y-m-d h:i:sa'),
    ]);

    $trans = $this->transactionModel->getWhere(['transaction_code' => $transCode])->getRowArray();
    foreach ($listOrder as $orderId) {
      $scheduleDetail = $this->scheduleDetailModel->getWhere(['id' => $orderId])->getRowArray();
      $totalPay += $scheduleDetail['price'];
      array_push($data, $scheduleDetail);
      if ($scheduleDetail) {
        $this->transactionDetailModel->save([
          'transaction_id' => $trans['id'],
          'booking_date' => $bookingDate,
          'schedule_detail_id' => $scheduleDetail['id'],
          'price' => $scheduleDetail['price'],
        ]);
      }
    }

    
    $grossAmount = $totalPay;
    if($downPayment){
      $totalDp = $totalPay*0.25;
      $grossAmount = $totalDp;
      $this->transactionModel->save([
        'id' => $trans['id'],
        'total_pay'=> $totalPay,
        'dp_method' => 1,
        'total_dp' => $totalDp,
      ]);
    }


    //Set Your server key
    \Midtrans\Config::$serverKey = "SB-Mid-server-0CdKKn0ekLgYSuUWp2V7huR5";
    // Uncomment for production environment
    \Midtrans\Config::$isProduction = false;
    // Enable sanitization
    \Midtrans\Config::$isSanitized = true;
    // Enable 3D-Secure
    \Midtrans\Config::$is3ds = true;
    $params = array(
      'transaction_details' => array(
        'order_id' => $transCode,
        'gross_amount' => $grossAmount,
      )
    );

    $snapToken = \Midtrans\Snap::getSnapToken($params);

    $this->transactionModel->save([
      'id' => $trans['id'],
      'snap_token' => $snapToken,
    ]);
    return $snapToken;
  }

}
