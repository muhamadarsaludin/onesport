<?= $this->extend('templates/dashboard'); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>

<!-- Page Heading -->
<section class="py-2">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Edit Venue</h6>
    </div>
    <div class="card-body">
      <form action="/venue/myvenue/main/update/<?= $venue['id']; ?>" method="post" class="user" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="form-group row">
          <label for="logo" class="col-2 col-form-label">Logo Venue<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-3">
            <div class="img-add w-100">
              <label for="logo">
                <img src="/img/venue/logos/<?= $venue['logo']; ?>" class="main-preview object-fit" />
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
            <input type="text" class="form-control form-control-user <?= (session('errors.venue_name') ? 'is-invalid' : ''); ?>" id="venue_name" name="venue_name" value="<?= old('venue_name') ? old('venue_name') : $venue['venue_name']; ?>" placeholder="Nama Venue">
            <div class="invalid-feedback">
              <?= $validation->getError('venue_name'); ?>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="contact" class="col-sm-2 col-form-label">Kontak venue<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user <?= (session('errors.contact') ? 'is-invalid' : ''); ?>" id="contact" name="contact" value="<?= old('contact') ? old('contact') : $venue['contact']; ?>" placeholder="Kontak Venue">
            <div class="invalid-feedback">
              <?= $validation->getError('contact'); ?>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="city" class="col-sm-2 col-form-label">Kota<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user <?= (session('errors.city') ? 'is-invalid' : ''); ?>" id="city" name="city" placeholder="Kota" value="<?= old('city') ? old('city') : $venue['city']; ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('city'); ?>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="province" class="col-sm-2 col-form-label">Provinsi<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user <?= (session('errors.province') ? 'is-invalid' : ''); ?>" id="province" name="province" placeholder="Provinsi" value="<?= old('province') ? old('province') : $venue['province']; ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('province'); ?>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="postal_code" class="col-sm-2 col-form-label">Kode POS<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user <?= (session('errors.postal_code') ? 'is-invalid' : ''); ?>" id="postal_code" name="postal_code" placeholder="Kode POS" value="<?= old('postal_code') ? old('postal_code') : $venue['postal_code']; ?>">
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
            <textarea class="form-control" name="address" id="address" cols="30" rows="4"><?= old('address') ? old('address') : $venue['address']; ?></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="description" class="col-sm-2 col-form-label">Deskripsi<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <textarea class="form-control" name="description" id="description" cols="30" rows="4"><?= old('description') ? old('description') : $venue['description']; ?></textarea>
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