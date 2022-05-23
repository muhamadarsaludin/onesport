<?= $this->extend('templates/dashboard'); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>

<!-- Page Heading -->
<section class="py-2">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Detail User</h6>

      <a href="/admin/users/main/edit/<?= $user['id']; ?>" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-pencil-alt"></i>
        </span>
        <span class="text">Edit User</span>
      </a>
    </div>
    <div class="card-body">
      <form action="/admin/users/main/update/<?= $user['id']; ?>" method="post" class="user mt-4">
        <?= csrf_field(); ?>
        <div class="form-group row">
          <label for="username" class="col-sm-2 col-form-label">Username</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" value="<?= (old('username')) ? old('username') : $user['username']; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="email" class="col-sm-2 col-form-label">Alamat Email</label>
          <div class="col-sm-10">
            <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Alamat email" value="<?= (old('email')) ? old('email') : $user['email']; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="group_id" class="col-sm-2 col-form-label">Group User</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="group_id" name="group_id" placeholder="Role User" value="<?= $user['role_name'] ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="active" class="col-sm-2 col-form-label">Status</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="active" name="active" placeholder="Status" value="<?= (old('active')) ? old('active') : ($user['active'] ? 'Active' : 'Non Aktif'); ?>" readonly>
          </div>
        </div>

        <div class="text-right" width="100%">
          <a href="/admin/users/main" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</section>
<?= $this->endSection(); ?>