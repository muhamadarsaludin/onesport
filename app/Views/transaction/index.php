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
              <th>Total Bayar</th>
              <th>Tanggal Transaksi</th>
              <th>Tanggla Kadaluarsa</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>No</th>
              <th>Kode Transaksi</th>
              <th>Total Bayar</th>
              <th>Tanggal Transaksi</th>
              <th>Tanggla Kadaluarsa</th>
              <th>Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php $i = 1; ?>
            <?php foreach ($transactions as $transaction) : ?>
              <tr>
                <td><?= $i++; ?></td>
                <td><?= $transaction['transaction_code']; ?></td>
                <td><?= $transaction['total_pay']; ?></td>
                <td><?= $transaction['transaction_date']; ?></td>
                <td><?= $transaction['transaction_exp_date']; ?></td>
                <td class="text-center">
                  <a href="/transaction/detail/<?= $transaction['transaction_code']; ?>" class="btn btn-info btn-sm"><i class="d-lg-none fa fa-pencil-alt"></i><span class="d-none d-lg-inline">Detail Transaksi</span></a>
                  <a href="" class="btn btn-warning btn-sm"><i class="d-lg-none fa fa-pencil-alt"></i><span class="d-none d-lg-inline">Bayar Sekarang</span></a>
                </td>
              </tr>
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