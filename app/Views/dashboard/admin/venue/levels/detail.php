<?= $this->extend('templates/dashboard'); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>

<!-- Page Heading -->
<section class="py-2">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Detail Level Venue</h6>
    </div>
    <div class="card-body">
      <form action="/admin/venue/levels/save" method="post" class="user">
        <?= csrf_field(); ?>
        <div class="form-group row">
          <label for="level_name" class="col-sm-2 col-form-label">Level Venue<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user <?= (session('errors.level_name') ? 'is-invalid' : ''); ?>" id="level_name" name="level_name" placeholder="Nama Level..." value="<?= $level['level_name']; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="description" class="col-sm-2 col-form-label">Deskripsi</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="description" name="description" rows="4" readonly><?= $level['description']; ?></textarea>
          </div>
        </div>
        <div class="text-right" width="100%">
          <a href="/admin/venue/levels" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</section>
<?= $this->endSection(); ?>