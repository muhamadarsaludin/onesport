<?= $this->extend('templates/dashboard'); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>

<!-- Page Heading -->
<section class="py-2">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Edit Fasilitas</h6>
    </div>
    <div class="card-body">
      <form action="/admin/facilities/update/<?= $facility['id']; ?>" method="post" class="user" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="form-group row">
          <label for="facility_name" class="col-sm-2 col-form-label">Nama Fasilitas</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user <?= ($validation->hasError('facility_name') ? 'is-invalid' : ''); ?>" id="facility_name" name="facility_name" placeholder="Nama Facilitas" value="<?= old('facility_name') ? old('facility_name') : $facility['facility_name']; ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('facility_name'); ?>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="icon" class="col-sm-2 col-form-label">Icon</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user <?= ($validation->hasError('icon') ? 'is-invalid' : ''); ?>" id="icon" name="icon" placeholder="Class fontawesome" value="<?= old('icon') ? old('icon') : $facility['icon']; ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('icon'); ?>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="description" class="col-sm-2 col-form-label">Deskripsi</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="description" name="description" placeholder="Deskripsi fasilitas" rows="4"><?= old('description') ? old('description') : $facility['description']; ?></textarea>
          </div>
        </div>
        <div class="text-right" width="100%">
          <a href="/admin/facilities" class="btn btn-secondary btn-sm">Kembali</a>
          <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</section>
<?= $this->endSection(); ?>