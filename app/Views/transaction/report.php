<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title . ' ~ Printed by ' . @my_info()->username ?></title>
  <style>
    * {
      font-family: sans-serif;
    }

    table {
      width: 100%;
    }

    table,
    th,
    tr,
    td {
      /* border: 1px solid black; */
      border-collapse: collapse;
      border-spacing: 0;
      font-size: small;
    }

    th,
    td {
      padding: 5px;
    }

    .text-center {
      text-align: center;
    }

    .text-right {
      text-align: right;
    }

    .flex {
      float: left;
    }

  </style>
</head>

<body>
  <h1 class="text-center"><?= $title ?></h1>
  <h3 class="font-weight-bold text-primary"><?= $transaction['transaction_code']; ?> 
  <?php
        $color = 'danger';
        if($transaction['status_code'] == 200){
          $color = 'success';
        }
        if($transaction['status_code'] == 201){
          $color = 'warning';
        }

        // message
        $message = "Transaksi Gagal!";
        if(!$transaction['dp_method']){
          if($transaction['status_code'] == 200){
            $message = 'Lunas';
          }elseif($transaction['status_code'] == 201){
            $message = 'Menunggu Pembayaran';
          }
        }else{
          if($transaction['status_code'] == 200 && $transaction['repayment']==1){
            $message = 'Lunas';
          }elseif($transaction['status_code'] == 200){
            $message = 'Down Payment';
          }elseif($transaction['status_code'] == 201){
            $message = 'Menunggu Pembayaran';
          }
        }
      ?>
  <span class="badge badge-<?= $color; ?>">
    (<?= $message; ?>)
  </span>
  </h3>
  
  <h5>Tanggal Transaksi : <?= date_format(date_create($transaction['transaction_date']), "d F Y"); ?></h5>    
  <table class="table table-bordered" id="dataTable" cellspacing="0" border="1px">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Venue</th>
        <th>Lapangan</th>
        <th>Tanggal Main</th>
        <th>Jam</th>
        <th>Harga</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; ?>
      <?php foreach ($details as $detail) : ?>
        <tr>
          <td><?= $i++; ?></td>
          <td><?= $detail['venue_name']; ?></td>
          <td><?= $detail['field_name']; ?></td>
          <td><?= date_format(date_create($detail['booking_date']), "d F Y"); ?></td>
          <td><?= date("h:i", strtotime($detail['start_time'])); ?> - <?= date("h:i", strtotime($detail['end_time'])); ?></td>
          <td>Rp<?= number_format($detail['price'], 0, ',', '.'); ?>,-</td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>   
  
  <table>
    <tr>
      <td>
        <p>Total Bayar</p>          
        <h3 class="font-weight-bold text-primary">Rp<?= number_format($transaction['total_pay'], 0, ',', '.'); ?>,-</h3>
      </td>
      <?php if($transaction['status_code'] == 200 || $transaction['status_code'] == 201): ?>
        <?php if($transaction['dp_method'] && !$transaction['repayment']): ?>
      <td>
        <p class="font-weight-bold">Down Payment</p>
        <h5 class="font-weight-bold text-primary">Rp<?= number_format($transaction['total_dp'], 0, ',', '.'); ?>,-</h5>            
      </td>
          <?php if($transaction['dp_status'] && !$transaction['repayment'] && !$transaction['cancel']): ?>
      <td>
        <p class="font-weight-bold">Sisa Bayar</p>
        <h5 class="font-weight-bold text-primary">Rp<?= number_format(($transaction['total_pay']-$transaction['total_dp']), 0, ',', '.'); ?>,-</h5>
      </td>
          <?php endif; ?>
        <?php endif; ?>
      <?php endif; ?>     
    </tr>
  </table>  
</body>

</html>