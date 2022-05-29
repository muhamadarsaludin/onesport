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
    $data = [
      'title'  => 'Transaksi',
      'transactions' => $this->transactionModel->getTransactionByUserId(user()->id)->getResultArray(),
    ];
    // dd($data);
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
    
    $transCode = strtoupper('ONE-' . random_string('numeric', 6));

    
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
    if($downPayment == "true"){
      $totalDp = $totalPay*0.25;
      $grossAmount = $totalDp;
      $this->transactionModel->save([
        'id' => $trans['id'],
        'total_pay'=> $totalPay,
        'dp_method' => 1,
        'total_dp' => $totalDp,
      ]);
    }

    $this->transactionModel->save([
      'id' => $trans['id'],
      'total_pay'=> $totalPay,
    ]);

    //Set Your server key
    \Midtrans\Config::$serverKey = "SB-Mid-server-0CdKKn0ekLgYSuUWp2V7huR5";
    // Uncomment for production environment
    \Midtrans\Config::$isProduction = false;
    // Enable sanitization
    \Midtrans\Config::$isSanitized = true;
    // Enable 3D-Secure
    \Midtrans\Config::$is3ds = true;

    $transaction_details = array(
        'order_id' => $transCode,
        'gross_amount' => $grossAmount,
    );
    
    $customer_details = array(
      'first_name'    => user()->username,
      'email'         => user()->email,
    );

    $midtransRequest = array(
      'transaction_details' => $transaction_details,
      'customer_details' => $customer_details,
    );


    $snapToken = \Midtrans\Snap::getSnapToken($midtransRequest);

    $this->transactionModel->save([
      'id' => $trans['id'],
      'snap_token' => $snapToken,
    ]);
    return $snapToken;
  }

  public function repayment()
  {
    $transCode = $this->request->getVar('trans');
    
    $transaction = $this->transactionModel->getWhere(['transaction_code'=> $transCode])->getRowArray();
    
   
    if(!$transaction['repayment']){
      $orderId = 'RPY-'.$transaction['transaction_code'];
      $sisaBayar = $transaction['total_pay'] - $transaction['total_dp'];

     $this->repaymentModel->save([
        'code' => $orderId,
        'transaction_id' => $transaction['id'],
        'total_pay' => $sisaBayar
      ]);
        
      \Midtrans\Config::$serverKey = "SB-Mid-server-0CdKKn0ekLgYSuUWp2V7huR5";
      // Uncomment for production environment
      \Midtrans\Config::$isProduction = false;
      // Enable sanitization
      \Midtrans\Config::$isSanitized = true;
      // Enable 3D-Secure
      \Midtrans\Config::$is3ds = true;
     

      $transaction_details = array(
        'order_id' => $orderId,
        'gross_amount' => $sisaBayar,
    );
    
    $customer_details = array(
      'first_name'    => user()->username,
      'email'         => user()->email,
    );

    $midtransRequest = array(
      'transaction_details' => $transaction_details,
      'customer_details' => $customer_details,
    );


      $snapToken = \Midtrans\Snap::getSnapToken($midtransRequest);
      return $snapToken;
    }
  }

  public function review($transCode)
  {
    $data = [
      'title' => 'Review Transaksi',
      'transaction' => $this->transactionModel->getTransactionByCode($transCode)->getRowArray(),
      'validation' => \Config\Services::validation(),
  ]; 
  // dd($data);
    return view('transaction/review', $data);
  }

  public function savereview($transCode)
  {

    if (!$this->validate([
      'transaction_id' => 'required',
      'user_id' => 'required',
      'field_id' => 'required',
      'venue_id' => 'required',
      'rating' => 'required',
    ])) {
      return redirect()->to('/transaction/review/'.$transCode)->withInput()->with('errors', $this->validator->getErrors());
    }

    $this->ratingModel->save([
      'transaction_id' => $this->request->getVar("transaction_id"),
      'user_id' => $this->request->getVar("user_id"),
      'field_id' => $this->request->getVar("field_id"),
      'venue_id' => $this->request->getVar("venue_id"),
      'rating' => $this->request->getVar("rating"),
      'review' => $this->request->getVar("review"),
    ]);

    session()->setFlashdata('message', 'Terimakasih sudah memberikan ulasan!');
    return redirect()->to('/transaction');
  }



  public function cencel($transCode)
  {
    $transaction = $this->transactionModel->getWhere(['transaction_code' => $transCode])->getRowArray();
    $this->transactionModel->save([
      'id' => $transaction['id'],
      'cancel' => 1,
      'status_code' => null,
      'transaction_status' => 'Canceled'
    ]);
    session()->setFlashdata('message', 'Pesanan berhasil di batalkan !');
    return redirect()->to('/transaction');
  }
}
