<?= $this->extend('templates/main'); ?>

<!-- CONTENT -->
<?= $this->section('content'); ?>
<section class="py-2">
  <div class="flash-data" data-flashdata="<?= session()->getFlashdata('message'); ?>"></div>
  <?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success" role="alert">
      <?= session()->getFlashdata('message'); ?>
    </div>
  <?php endif; ?>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Datail Transaksi</h6>
    </div>
    <div class="card-body">

      <h2 class="font-weight-bold text-primary"><?= $transaction['transaction_code']; ?> 
      
      <!-- warna  -->
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
        <?= $message; ?>
      </span>
      
      </h2>
      <div class="row">
        <div class="col-12 col-lg-6 row">
          <div class="col-6">
            <p class="font-weight-bold">Tanggal Transaksi</p>
            <p><?= date_format(date_create($transaction['transaction_date']), "d F Y"); ?></p>
          </div>
          <div class="col-6">
            <p class="font-weight-bold">Metode Pembayaran</p>
            <p><?= $transaction['dp_method']?'Down Payment':'Pembayaran Penuh'; ?></p>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" cellspacing="0">
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
          <tfoot>
            <tr>
              <th>No</th>
              <th>Nama Venue</th>
              <th>Lapangan</th>
              <th>Tanggal Main</th>
              <th>Jam</th>
              <th>Harga</th>
            </tr>
          </tfoot>
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
      </div>
      <div class="row justify-content-end mt-4">
        <div class="col-6">
          <div class="row">
            <div class="col-4">
              <h5 class="font-weight-bold">Total Bayar</h5>
            </div>
            <div class="col-8">
              <h3 class="font-weight-bold text-primary">Rp<?= number_format($transaction['total_pay'], 0, ',', '.'); ?>,-</h3>
            </div>
          </div>
          <?php if($transaction['status_code'] == 200 || $transaction['status_code'] == 201): ?>
          <?php if($transaction['dp_method'] && !$transaction['repayment']): ?>
            <hr>
            <div class="row">
              <div class="col-4">
                <h6 class="font-weight-bold">Down Payment</h6>
              </div>
              <div class="col-8">
                <h5 class="font-weight-bold text-primary">Rp<?= number_format($transaction['total_dp'], 0, ',', '.'); ?>,-</h5>
              </div>
            </div>
            
            <?php if($transaction['dp_status'] && !$transaction['repayment']): ?>
              <hr>
              <div class="row">
                <div class="col-4">
                  <h6 class="font-weight-bold">Sisa Bayar</h6>
                </div>
                <div class="col-8">
                  <h5 class="font-weight-bold text-primary">Rp<?= number_format(($transaction['total_pay']-$transaction['total_dp']), 0, ',', '.'); ?>,-</h5>
                </div>
              </div>
            <?php endif; ?>
          <?php endif; ?>
          <?php endif; ?>
          
        </div>
      </div>
    </div>
  </div>



</section>
<?= $this->endSection(); ?>
<!-- END CONTENT -->

<?= $this->section('script'); ?>
<script>
  $(document).ready(function() {
    $('#dataTable').DataTable();
  });
   
</script>
<?= $this->endSection(); ?>