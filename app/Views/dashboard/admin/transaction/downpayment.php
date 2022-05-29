<?= $this->extend('templates/dashboard'); ?>

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
      <h6 class="m-0 font-weight-bold text-primary">Data Down Payment</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
            <?php if($transaction['dp_method'] && !$transaction['repayment'] ) : ?>
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
                  <a href="/admin/transaction/detail/<?= $transaction['transaction_code']; ?>" class="btn btn-info btn-sm"><i class="d-lg-none fas fa-book-open"></i><span class="d-none d-lg-inline">Detail</span></a>
                  <!-- <a href="/admin/transaction/edit/<?= $transaction['transaction_code']; ?>" class="btn btn-warning btn-sm"><i class="d-lg-none fa fa-pencil-alt"></i><span class="d-none d-lg-inline">Edit</span></a> -->
                  <form action="/admin/transaction/<?= $transaction['id']; ?>" method="POST" class="d-inline form-delete">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger btn-sm btn-delete"><span class="d-lg-none fa fa-trash"></span><span class="d-none d-lg-inline">Hapus</span></span></button>
                  </form>
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