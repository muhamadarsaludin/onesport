<?= $this->extend('templates/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid content-frame mb-3">
    <?= form_open('', ['method' => 'POST']) ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="start-date">Start date</label>
                <div class='input-group date' id='start-date'>
                    <input id="start-date" type='text' name="start_date" value="<?= (@$_POST['start_date']) ? $_POST['start_date'] : ''; ?>" class="form-control" />
                    <div class="input-group-append input-group-addon">
                        <span class="input-group-text bg-primary text-white fa fa-calendar-alt"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="end-date">End date</label>
                <div class='input-group date' id='end-date'>
                    <input id="end-date" type='text' name="end_date" value="<?= (@$_POST['end_date']) ? $_POST['end_date'] : ''; ?>" class="form-control" />
                    <div class="input-group-append input-group-addon">
                        <span class="input-group-text bg-primary text-white fa fa-calendar-alt"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <button type="submit" name="preview-data" class="btn btn-primary"><span class="fas fa-eye mr-1"></span> Preview</button>
        </div>
    </div>
    <?= form_close(); ?>
</div>

<?php

use App\Models\TransactionModel;

$TransactionModel = new TransactionModel();
?>

<?php if (isset($_POST['preview-data'])) : ?>
    <?php
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $total = 0;


    
    $transactions = $TransactionModel->getTransactionBetweenDate($start_date, $end_date)->getResultArray();
    ?>
    <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
      <a href="/admin/transaction/report_pdf/<?= date('Y-m-d', strtotime($_POST['start_date'])); ?>/<?= date('Y-m-d', strtotime($_POST['end_date'])); ?>" class="btn btn-primary btn-icon-split" target="_blank">
        <span class="icon text-white-50">
          <i class="fas fa-print"></i>
        </span>
        <span class="text">Export to PDF</span>
      </a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode Transaksi</th>
              <th>Nama Venue</th>
              <th>Nama Lapangan</th>
              <th>Total Bayar</th>
              <th>Tanggal Transaksi</th>
              <th>Status</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>No</th>
              <th>Kode Transaksi</th>
              <th>Nama Venue</th>
              <th>Nama Lapangan</th>
              <th>Total Bayar</th>
              <th>Tanggal Transaksi</th>
              <th>Status</th>
            </tr>
          </tfoot>
          <tbody>
            <?php $i = 1; ?>
            <?php foreach ($transactions as $transaction) : ?>
              <tr>
                <td><?= $i++; ?></td>
                <td><?= $transaction['transaction_code']; ?></td>
                <td><?= $transaction['venue_name']; ?></td>
                <td><?= $transaction['field_name']; ?></td>
                <td>Rp<?= number_format($transaction['total_pay'], 0, ',', '.'); ?></td>
                <td><?= $transaction['transaction_date']; ?></td>
                <td><?= $transaction['transaction_status']?$transaction['transaction_status']:'Transaksi Gagal'; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>




<?php endif; ?>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $('.date').datetimepicker({
        format: 'L',
        useCurrent: false,
    });

    $(document).ready(function() {
        $('#dataTable').DataTable();
    });

    $('#start-date').data("DateTimePicker").minDate('<?= $date_min ?>');
    $('#end-date').data("DateTimePicker").minDate('<?= $date_min ?>');
</script>
<?= $this->endSection(); ?>