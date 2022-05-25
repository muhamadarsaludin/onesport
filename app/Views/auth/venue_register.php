<?= $this->extend('templates/auth'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid overflow-hidden px-0">
  <div class="row" style="min-height: 100vh;">
    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
    <div class="col-lg-7 py-4">
      <div class="row justify-content-center align-items-center h-100">
        <div class="col">
          <div class="px-5">
            <div class="text-center">
              <a href="/">
                <img src="/img/logos/logo.svg" alt="Onesport Logo" class="mb-4" width="130">
              </a>
            </div>
            <?php if (session()->getFlashdata('message')) : ?>
              <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('message'); ?>
              </div>
            <?php endif; ?>

            <form action="/main/sendvenueregistration" method="post" class="user">
              <div class="form-group">
                <label for="venue_name" class="small ">Nama Venue</label>
                <input type="text" class="form-control form-control-user <?php if (session('errors.venue_name')) : ?>is-invalid<?php endif ?>" id="venue_name" name="venue_name" placeholder="Nama Venue" value="<?= old('venue_name') ?>">
                <div class="invalid-feedback">
                  <?= session('errors.venue_name'); ?>
                </div>
              </div>

              <div class="form-group">
                <label for="description" class="small ">Deskripsi</label>
                <textarea type="text" class="form-control <?php if (session('errors.description')) : ?>is-invalid<?php endif ?>" id="description" name="description" cols="30" rows="3"><?= old('description') ? old('description') : ''; ?></textarea>
                <div class="invalid-feedback">
                  <?= session('errors.description'); ?>
                </div>
              </div>

              <div class="form-group">
                <label for="city" class="small ">Kota</label>
                <input type="text" class="form-control form-control-user <?php if (session('errors.city')) : ?>is-invalid<?php endif ?>" id="city" name="city" placeholder="Tasikmalaya" value="<?= old('city') ?>">
                <div class="invalid-feedback">
                  <?= session('errors.city'); ?>
                </div>
              </div>

              <div class="form-group">
                <label for="province" class="small ">Provinsi</label>
                <input type="text" class="form-control form-control-user <?php if (session('errors.province')) : ?>is-invalid<?php endif ?>" id="province" name="province" placeholder="Jawa Barat" value="<?= old('province') ?>">
                <div class="invalid-feedback">
                  <?= session('errors.province'); ?>
                </div>
              </div>

              <div class="form-group">
                <label for="postal_code" class="small ">Kode Pos</label>
                <input type="text" class="form-control form-control-user <?php if (session('errors.postal_code')) : ?>is-invalid<?php endif ?>" id="postal_code" name="postal_code" placeholder="Kode Pos" value="<?= old('postal_code') ?>">
                <div class="invalid-feedback">
                  <?= session('errors.postal_code'); ?>
                </div>
              </div>

              <div class="form-group">
                <label for="address" class="small ">Alamat</label>
                <textarea type="text" class="form-control <?php if (session('errors.address')) : ?>is-invalid<?php endif ?>" id="address" name="address" cols="30" rows="3"><?= old('address') ? old('address') : ''; ?></textarea>
                <div class="invalid-feedback">
                  <?= session('errors.address'); ?>
                </div>
              </div>


              <button type="submit" class="btn btn-primary btn-user btn-block">
                Register
              </button>
              <hr>
              <p class="small text-center"><a class="text-wild-watermelon" href="<?= route_to('/') ?>">
                  Back to home!</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>