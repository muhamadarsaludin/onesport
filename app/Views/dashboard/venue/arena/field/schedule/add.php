<?= $this->extend('templates/dashboard'); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>

<!-- Page Heading -->
<section class="py-2">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Tambah Jadwal</h6>
    </div>
    <div class="card-body">
      <form action="/venue/arena/field/schedule/main/save/<?= $field['id']; ?>" method="post" class="user" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <div class="form-group row">
          <label for="day_id" class="col-sm-2 col-form-label">Hari<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <select class="custom-select" id="day_id" name="day_id">
              <option selected>Pilih salah satu...</option>
                  <?php foreach ($days as $day) :; ?>
                    <?php 
                      $served = false;
                      foreach ($schedules as $schedule) {
                        if ($day['id']==$schedule['day_id']) {
                          $served = true;
                        }
                      }
                    ?>
                    <?php if(!$served):; ?>
                    <option value="<?= $day['id']; ?>"><?= $day['day']; ?></option>
                    <?php endif; ?>
                  <?php endforeach; ?>
            </select>
          </div>
        </div>


        <div class="form-group row">
          <label for="start_time" class="col-sm-2 col-form-label">Jam Operasional<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-5">
            <input type="time" class="form-control form-control-user <?= (session('errors.start_time') ? 'is-invalid' : ''); ?>" id="start_time" name="start_time" placeholder="Buka Pukul">
            <div class="invalid-feedback">
              <?= $validation->getError('start_time'); ?>
            </div>
          </div>
          <div class="col-sm-5">
            <input type="time" class="form-control form-control-user <?= (session('errors.end_time') ? 'is-invalid' : ''); ?>" id="end_time" name="end_time" placeholder="Tutup Pukul">
            <div class="invalid-feedback">
              <?= $validation->getError('end_time'); ?>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="price" class="col-sm-2 col-form-label">Harga Sewa<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="number" class="form-control form-control-user <?= (session('errors.price') ? 'is-invalid' : ''); ?>" id="price" name="price" value="<?= old('price') ? old('price') : ''; ?>" placeholder="Harga sewa default">
            <div class="invalid-feedback">
              <?= $validation->getError('price'); ?>
            </div>
          </div>
        </div>

        <div class="text-right" width="100%">
          <a href="/venue/arena/field/Main/detail/<?= $field['slug']; ?>" class="btn btn-secondary btn-sm">Kembali</a>
          <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</section>
<?= $this->endSection(); ?>