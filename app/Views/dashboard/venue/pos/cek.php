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
  <?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger" role="alert">
      <?= session()->getFlashdata('error'); ?>
    </div>
  <?php endif; ?>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Pengecekan Transaksi</h6>
    </div>
    <div class="card-body">
    
    <form action="/venue/pos/cek_result" method="post" class="user">
      <div div class="form-group row">
        <div class="col-sm-12">
          <input autofocus type="text" class="form-control form-control-user <?= (session('errors.code') ? 'is-invalid' : ''); ?>" id="code" name="code" value="<?= old('code') ? old('code') : ''; ?>" placeholder="Masukan Kode Transaksi">
          <div class="invalid-feedback">
            <?= $validation->getError('code'); ?>
          </div>
        </div>
      </div>

      <div class="text-right" width="100%">
        <button type="submit" class="btn btn-primary btn-sm">Cari Transaksi</button>
      </div>

    </form>

    
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