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
      <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
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
              <th>Down Payment</th>
              <th>Tanggal Transaksi</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>No</th>
              <th>Kode Transaksi</th>
              <th>Nama Venue</th>
              <th>Nama Lapangan</th>
              <th>Total Bayar</th>
              <th>Down Payment</th>
              <th>Tanggal Transaksi</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php $i = 1; ?>
            <?php foreach ($transactions as $transaction) : ?>
            <?php if(!$transaction['use_ticket'] && !$transaction['cancel']):?>

              <tr>
                <td><?= $i++; ?></td>
                <td><?= $transaction['transaction_code']; ?></td>
                <td><?= $transaction['venue_name']; ?></td>
                <td><?= $transaction['field_name']; ?></td>
                <td>Rp<?= number_format($transaction['total_pay'], 0, ',', '.'); ?></td>
                <td>Rp<?= number_format($transaction['total_dp'], 0, ',', '.'); ?></td>
                <td><?= $transaction['transaction_date']; ?></td>
                <td><?= $transaction['transaction_status']; ?></td>
                <td class="text-center">
                  <a href="/transaction/detail/<?= $transaction['transaction_code']; ?>" class="btn btn-info btn-sm"><i class="d-lg-none fas fa-book-open"></i><span class="d-none d-lg-inline">Detail Transaksi</span></a>
                  <?php 
                  $playDate =date_create($transaction['booking_date']);
                  $todayDate = date_create(date("Y-m-d")); 
                  $diff=date_diff($todayDate,$playDate);
                  $selisih = (int) $diff->format("%R%a");  
                  ?>
                  <?php if($selisih > 1): ?>
                    <!-- harus bentuk form -->
                    <form action="/transaction/cencel/<?= $transaction['transaction_code']; ?>" method="POST" class="d-inline form-delete">
                      <?= csrf_field(); ?>
                      <input type="hidden" name="_method" value="DELETE">
                      <button type="submit" class="btn btn-danger btn-sm btn-cancel"><span class="d-none d-lg-inline">Batalkan Pesanan!</span></button>
                    </form>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endif; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode Transaksi</th>
              <th>Total Bayar</th>
              <th>Tanggal Transaksi</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>No</th>
              <th>Kode Transaksi</th>
              <th>Total Bayar</th>
              <th>Tanggal Transaksi</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php $i = 1; ?>
            <?php foreach ($transactions as $transaction) : ?>
            <?php if($transaction['use_ticket'] || $transaction['cancel']):?>
              <tr>
                <td><?= $i++; ?></td>
                <td><?= $transaction['transaction_code']; ?></td>
                <td><?= $transaction['total_pay']; ?></td>
                <td><?= $transaction['transaction_date']; ?></td>
                <td><?= $transaction['transaction_status']; ?></td>
                <td class="text-center">
                  <a href="/transaction/detail/<?= $transaction['transaction_code']; ?>" class="btn btn-info btn-sm"><i class="d-lg-none fa fa-pencil-alt"></i><span class="d-none d-lg-inline">Detail Transaksi</span></a>
                  <?php if(!$transaction['reviewed'] && $transaction['status_code'] == 200): ?>
                  <a href="/transaction/review/<?= $transaction['transaction_code']; ?>" class="btn btn-warning btn-sm"><i class="d-lg-none fa fa-pencil-alt"></i><span class="d-none d-lg-inline">Beri Penilaian</span></a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endif; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
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