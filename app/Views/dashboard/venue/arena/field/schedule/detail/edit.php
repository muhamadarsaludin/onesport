<?= $this->extend('templates/dashboard'); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>

<!-- Page Heading -->
<section class="py-2">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Edit Detail Schedule</h6>
    </div>
    <div class="card-body">
      <form action="/venue/arena/field/schedule/detail/update/<?= $detail['id']; ?>" method="post" class="user" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="form-group row">
          <label for="start_time" class="col-sm-2 col-form-label">Durasi<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-5">
            <input type="time" class="form-control form-control-user <?= (session('errors.start_time') ? 'is-invalid' : ''); ?>" id="start_time" name="start_time" placeholder="Waktu Mulai" value="<?= (old('start_time') ? old('start_time') : $detail['start_time']); ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('start_time'); ?>
            </div>
          </div>
          <div class="col-sm-5">
            <input type="time" class="form-control form-control-user <?= (session('errors.end_time') ? 'is-invalid' : ''); ?>" id="end_time" name="end_time" placeholder="Waktu Selesai" value="<?= (old('end_time') ? old('end_time') : $detail['end_time']); ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('end_time'); ?>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="price" class="col-sm-2 col-form-label">Harga<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="number" class="form-control form-control-user <?= (session('errors.price') ? 'is-invalid' : ''); ?>" id="price" name="price" placeholder="Harga" value="<?= (old('price') ? old('price') : $detail['price']); ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('price'); ?>
            </div>
          </div>
        </div>


        <div class="text-right" width="100%">
          <a href="/venue/arena/field/schedule/main/detail/<?= $schedule['id']; ?>" class="btn btn-secondary btn-sm">Kembali</a>
          <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</section>
<?= $this->endSection(); ?>