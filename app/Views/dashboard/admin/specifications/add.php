<?= $this->extend('templates/dashboard'); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>

<!-- Page Heading -->
<section class="py-2">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Tambah Spesifikasi</h6>
    </div>
    <div class="card-body">
      <form action="/admin/specifications/save" method="post" class="user" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="form-group row">
          <label for="spec_name" class="col-sm-2 col-form-label">Spesifikasi<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user <?= ($validation->hasError('spec_name') ? 'is-invalid' : ''); ?>" id="spec_name" name="spec_name" placeholder="Nama Spesifikasi">
            <div class="invalid-feedback">
              <?= $validation->getError('spec_name'); ?>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="sport_id" class="col-sm-2 col-form-label">Olahraga<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <select class="custom-select" id="sport_id" name="sport_id">
              <option selected>Pilih salah satu...</option>
              <?php foreach ($sports as $sport) : ?>
                <option value="<?= $sport['id']; ?>"><?= $sport['sport_name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="active" class="col-sm-2 col-form-label">Status<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <select class="custom-select" id="active" name="active">
              <option selected>Pilih salah satu...</option>
              <option value="1">Aktif</option>
              <option value="0">Non Aktif</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="description" class="col-sm-2 col-form-label">Deskripsi</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="description" name="description" placeholder="Deskripsi spesifikasi" rows="4"></textarea>
          </div>
        </div>
        <div class="text-right" width="100%">
          <a href="/admin/specifications" class="btn btn-secondary btn-sm">Kembali</a>
          <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</section>
<?= $this->endSection(); ?>