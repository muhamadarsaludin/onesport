<?= $this->extend('templates/dashboard'); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>

<!-- Page Heading -->
<section class="py-2">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
    </div>
    <div class="card-body">
      <form action="/admin/users/main/update/<?= $user['id']; ?>" method="post" class="user" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="form-group row">
          <label for="user_image" class="col-2 col-form-label">User Image<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-3">
            <div class="img-add rounded" width="100%">
              <label for="user_image">
                <img src="/img/users/<?= $user['user_image']; ?>" class="main-preview object-fit" />
              </label>
              <input id="user_image" name="user_image" type="file" class="<?= (session('errors.user_image') ? 'is-invalid' : ''); ?>" onchange="previewImg('user_image','main-preview')" />
              <div class="invalid-feedback text-center">
                <?= $validation->getError('user_image'); ?>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="email" class="col-sm-2 col-form-label">Alamat Email<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="email" class="form-control form-control-user <?= (session('errors.email') ? 'is-invalid' : ''); ?>" id="email" name="email" placeholder="Alamat email..." value="<?= (old('email')) ? old('email') : $user['email']; ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('email'); ?>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="username" class="col-sm-2 col-form-label">Username<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user <?= (session('errors.username') ? 'is-invalid' : ''); ?>" id="username" name="username" placeholder="Username..." value="<?= (old('username')) ? old('username') : $user['username']; ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('username'); ?>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="group_id" class="col-sm-2 col-form-label">group<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <select class="custom-select" id="group_id" name="group_id">
              <option>Pilih salah satu...</option>
              <?php foreach ($groups as $group) : ?>
                <option <?= $user['role_id']==$group['id']?'selected':''; ?> value="<?= $group['id']; ?>"><?= $group['name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="active" class="col-sm-2 col-form-label">Status<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <select class="custom-select" id="active" name="active">
              <option selected>Pilih salah satu...</option>

              <option <?= $user['active'] == 1 ? 'selected' : ''; ?> value="1">Aktif</option>
              <option <?= $user['active'] == 0 ? 'selected' : ''; ?> value="0">Non Aktif</option>
            </select>
          </div>
        </div>
        <div class="text-right" width="100%">
          <a href="/admin/users/main" class="btn btn-secondary btn-sm">Kembali</a>
          <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        </div>
      </form>
    </div>
  </div>

</section>
<?= $this->endSection(); ?>



<?= $this->extend('templates/dashboard'); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>

<!-- Page Heading -->
<section class="py-5">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h3 class="content-heading mb-0 text-gray-800">Edit User</h3>
  </div>


</section>
<?= $this->endSection(); ?>