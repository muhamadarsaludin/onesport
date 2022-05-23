<?= $this->extend('templates/dashboard'); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>

<!-- Page Heading -->
<section class="py-2">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Detail Venue</h6>
    </div>
    <div class="card-body">
      <form action="/admin/venues/main/update/<?= $venue['id']; ?>" method="post" class="user" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <div class="form-group row">
          <label for="productImage" class="col-2 col-form-label">Logo venue <sup class="text-danger">*</sup></label>
          <div class="col-3 row justify-content-between">
            <!-- main image -->
            <div class="img-add w-100">
              <label for="logo">
                <img src="/img/venue/logos/<?= $venue['logo']; ?>" class="main-preview object-fit" />
              </label>
              <input id="logo" name="logo" type="file" class="" onchange="previewImg('logo','main-preview')" />
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="venue_name" class="col-sm-2 col-form-label">Nama venue</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="venue_name" name="venue_name" value="<?= $venue['venue_name']; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="active" class="col-sm-2 col-form-label">Status<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <select class="custom-select" id="active" name="active" disabled>
              <option selected>Pilih salah satu...</option>
              <option <?= $venue['active'] == 1 ? 'selected' : ''; ?> value="1">Aktif</option>
              <option <?= $venue['active'] == 0 ? 'selected' : ''; ?> value="0">Non Aktif</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="username" class="col-sm-2 col-form-label">Nama owner</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="username" name="username" value="<?= $owner['username']; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="level_id" class="col-sm-2 col-form-label">Level Venue</label>
          <div class="col-sm-10">
            <select class="custom-select" id="level_id" name="level_id" disabled>
              <option selected>Pilih salah satu...</option>
              <?php foreach ($levels as $level) : ?>
                <option <?= $venue['level_id'] == $level['id'] ? 'selected' : ''; ?> value="<?= $level['id']; ?>"><?= $level['level_name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="rating" class="col-sm-2 col-form-label">Rating</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="rating" name="rating" placeholder="rating venue" value="<?= $venue['rating'] ? $venue['rating'] : 'Belum Ada Rating' ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="city" class="col-sm-2 col-form-label">Kota</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="city" name="city" placeholder="Kota" value="<?= $venue['city'] ? $venue['city'] : 'Kota belum diatur' ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="province" class="col-sm-2 col-form-label">Provinsi</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="province" name="province" placeholder="Provinsi" value="<?= $venue['province'] ? $venue['province'] : 'Provinsi belum diatur' ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="postal_code" class="col-sm-2 col-form-label">Kode POS</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="postal_code" name="postal_code" placeholder="Kode POS" value="<?= $venue['postal_code'] ? $venue['postal_code'] : 'Kode POS belum diatur' ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="latitude" class="col-sm-2 col-form-label">Latitude</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="latitude" name="latitude" placeholder="Latitude" value="<?= $venue['latitude'] ? $venue['latitude'] : 'Latitude belum diatur' ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="longitude" class="col-sm-2 col-form-label">Longitude</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="longitude" name="longitude" placeholder="Longitude" value="<?= $venue['longitude'] ? $venue['longitude'] : 'Latitude belum diatur' ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="address" class="col-sm-2 col-form-label">Kode POS</label>
          <div class="col-sm-10">
            <textarea class="form-control" name="address" id="address" cols="30" rows="4" readonly><?= $venue['address'] ? $venue['address'] : 'Alamat Belum diatur'; ?></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="description" class="col-sm-2 col-form-label">Deskripsi</label>
          <div class="col-sm-10">
            <textarea class="form-control" name="description" id="description" cols="30" rows="4" readonly><?= $venue['description'] ? $venue['description'] : 'Deskripsi Belum diatur'; ?></textarea>
          </div>
        </div>

        <div class="text-right" width="100%">
          <a href="/admin/venue/main" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</section>
<?= $this->endSection(); ?>