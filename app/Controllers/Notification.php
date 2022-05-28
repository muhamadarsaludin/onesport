<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\RepaymentModel;

class Notification extends BaseController
{
    /**
     * Instance of the main Request object.
     *
     * @var HTTP\IncomingRequest
     */
    protected $request;
    protected $transactionModel;
    protected $repaymentModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->repaymentModel = new RepaymentModel();
        helper('date');
    }


    public function handling()
    {
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$serverKey = "SB-Mid-server-0CdKKn0ekLgYSuUWp2V7huR5";
        $notif = new \Midtrans\Notification();
        $transactionCode = $notif->order_id;
        $transactionStatus = $notif->transaction_status;
        $statusCode = $notif->status_code;

        $transaction = $this->transactionModel->getWhere(['transaction_code' => $transactionCode])->getRowArray();
        $repayment = $this->repaymentModel->getWhere(['code' => $transactionCode])->getRowArray();

        if($transaction){
            if($transaction['dp_method']){
                if($statusCode==200){
                    $this->transactionModel->save([
                        'id' => $transaction['id'],
                        'transaction_status' => $transactionStatus,
                        'dp_status' => 1,
                        'status_code' => $statusCode
                    ]);
                }else{
                $this->transactionModel->save([
                    'id' => $transaction['id'],
                    'transaction_status' => $transactionStatus,
                    'status_code' => $statusCode
                ]);
            }
            }else{
                $this->transactionModel->save([
                    'id' => $transaction['id'],
                    'transaction_status' => $transactionStatus,
                    'status_code' => $statusCode
                ]);
            }
        }

        if($repayment){
            $transRepay = $this->transactionModel->getWhere(['id'=>$repayment['transaction_id']])->getRowArray();
            $this->repaymentModel->save([
                'id' => $repayment['id'],
                'status_code' => $statusCode
            ]);
            if($statusCode == 200){
                $this->transactionModel->save([
                    'id' => $transRepay['id'],
                    'transaction_status' => $transactionStatus,
                    'repayment' => 1,
                    'status_code' => $statusCode
                ]);
            }
        }
    }



    // public function index()
    // {
    //     $data = [
    //         'menuActive' => false,
    //         'title' => 'My Notification',
    //         'notification' => $this->notificationModel->getWhere(['user_id' => user()->id])->getResultArray(),
    //     ];
    //     //   dd($data);
    //     return view('main/notification', $data);
    // }
    // public function delete($id)
    // {
    //     $this->notificationModel->delete($id);
    //     session()->setFlashdata('message', 'Notification has been successfully deleted');
    //     return redirect()->to('/notification');
    // }
    // public function getItemInUserNotification()
    // {
    //     return $this->notificationModel->getWhere(['user_id' => user()->id])->getResultArray();
    // }

    // public function getJsonItemInUserNotification()
    // {
    //     return json_encode($this->getItemInUserNotification(), JSON_PRETTY_PRINT);
    // }



}
