<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\RepaymentModel;
use App\Models\UsersModel;
use App\Models\NotificationModel;

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
    protected $usersModel;
    protected $notificationModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->repaymentModel = new RepaymentModel();
        $this->usersModel = new UsersModel();
        $this->notificationModel = new NotificationModel();
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
                    // Kirim Notifikasi 
                    $user = $this->usersModel->getWhere(['id'=>$transaction['user_id']])->getRowArray();
                    $this->notificationModel->save([
                        'user_id' => $user['id'],
                        'message' => "Yeay...Pembayaran Transaksi ".$transaction['transaction_code'].' kamu berhasil! Minone tunggu kamu di lapangan ya :)',
                        'link'    => "/transaction/detail/".$transaction['transaction_code']
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
               
                $user = $this->usersModel->getWhere(['id'=>$transRepay['user_id']])->getRowArray();
                $this->notificationModel->save([
                    'user_id' => $user['id'],
                    'message' => "Yeay...Pelunasan Transaksi ".$transaction['transaction_code'].' kamu berhasil!, Minone tunggu kamu di lapangan ya :)',
                    'link'    => "/transaction/detail/".$transaction['transaction_code']
                ]);
            }
        }
    }



    public function index()
    {
        $data = [
            'title' => 'My Notification',
            'notification' => $this->notificationModel->getWhere(['user_id' => user()->id])->getResultArray(),
        ];
        //   dd($data);
        return view('notification/index', $data);
    }
    public function delete($id)
    {
        $this->notificationModel->delete($id);
        session()->setFlashdata('message', 'Notifikasi berhasil dihapus!');
        return redirect()->to('/notification');
    }

    // public function getItemInUserNotification()
    // {
    //     return $this->notificationModel->getWhere(['user_id' => user()->id])->getResultArray();
    // }

    // public function getJsonItemInUserNotification()
    // {
    //     return json_encode($this->getItemInUserNotification(), JSON_PRETTY_PRINT);
    // }



}
