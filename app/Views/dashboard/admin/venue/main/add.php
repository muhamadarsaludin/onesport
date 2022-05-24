<?= $this->extend('templates/dashboard'); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>

<!-- Page Heading -->
<section class="py-2">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Tambah Venue</h6>
    </div>
    <div class="card-body">
      <form action="/admin/venue/main/save" method="post" class="user" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="form-group row">
          <label for="logo" class="col-2 col-form-label">Logo Venue<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-3">
            <div class="img-add w-100">
              <label for="logo">
                <img src="/img/plus-circle.svg" class="main-preview icon-plus" />
              </label>
              <input id="logo" name="logo" type="file" class="<?= (session('errors.logo') ? 'is-invalid' : ''); ?>" onchange="previewImg('logo','main-preview')" />
              <div class="invalid-feedback text-center">
                <?= $validation->getError('logo'); ?>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="venue_name" class="col-sm-2 col-form-label">Nama venue<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user <?= (session('errors.venue_name') ? 'is-invalid' : ''); ?>" id="venue_name" name="venue_name" value="<?= old('venue_name') ? old('venue_name') : ''; ?>" placeholder="Nama Venue">
            <div class="invalid-feedback">
              <?= $validation->getError('venue_name'); ?>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="contact" class="col-sm-2 col-form-label">Kontak venue<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user <?= (session('errors.contact') ? 'is-invalid' : ''); ?>" id="contact" name="contact" value="<?= old('contact') ? old('contact') : ''; ?>" placeholder="Kontak Venue">
            <div class="invalid-feedback">
              <?= $validation->getError('contact'); ?>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="email" class="col-sm-2 col-form-label">Email Venue<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="email" class="form-control form-control-user <?= (session('errors.email') ? 'is-invalid' : ''); ?>" id="email" name="email" value="<?= old('email') ? old('email') : ''; ?>" placeholder="Email Venue">
            <div class="invalid-feedback">
              <?= $validation->getError('email'); ?>
            </div>
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
          <label for="level_id" class="col-sm-2 col-form-label">Level Venue<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <select class="custom-select" id="level_id" name="level_id">
              <option selected>Pilih salah satu...</option>
              <?php foreach ($levels as $level) : ?>
                <option value="<?= $level['id']; ?>"><?= $level['level_name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="form-group row">
          <label for="city" class="col-sm-2 col-form-label <?= (session('errors.city') ? 'is-invalid' : ''); ?>">Kota<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="city" name="city" placeholder="Kota" value="<?= old('city') ? old('city') : ''; ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('city'); ?>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="province" class="col-sm-2 col-form-label <?= (session('errors.province') ? 'is-invalid' : ''); ?>">Provinsi<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="province" name="province" placeholder="Provinsi" value="<?= old('province') ? old('province') : ''; ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('province'); ?>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="postal_code" class="col-sm-2 col-form-label <?= (session('errors.postal_code') ? 'is-invalid' : ''); ?>">Kode POS<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="postal_code" name="postal_code" placeholder="Kode POS" value="<?= old('postal_code') ? old('postal_code') : ''; ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('postal_code'); ?>
            </div>
          </div>
        </div>
        <!-- <div class="form-group row">
          <label for="latitude" class="col-sm-2 col-form-label">Latitude</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="latitude" name="latitude" placeholder="Latitude" value="<?= old('latitude') ? old('latitude') : ''; ?>">
            <div class="invalid-feedback">
              
            </div>
          </div>
        </div> -->
        <!-- <div class="form-group row">
          <label for="longitude" class="col-sm-2 col-form-label">Longitude</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="longitude" name="longitude" placeholder="Longitude" value="<?= old('longitude') ? old('longitude') : ''; ?>">
            <div class="invalid-feedback">
              
            </div>
          </div>
        </div> -->
        <div class="form-group row">
          <label for="address" class="col-sm-2 col-form-label">Alamat<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <textarea class="form-control" name="address" id="address" cols="30" rows="4"><?= old('address') ? old('address') : ''; ?></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="description" class="col-sm-2 col-form-label">Deskripsi<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <textarea class="form-control" name="description" id="description" cols="30" rows="4"><?= old('description') ? old('description') : ''; ?></textarea>
          </div>
        </div>
        <div class="text-right" width="100%">
          <a href="/admin/venue/main" class="btn btn-secondary btn-sm">Kembali</a>
          <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</section>
<?= $this->endSection(); ?>