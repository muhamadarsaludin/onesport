<?= $this->extend('templates/dashboard'); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>

<!-- Page Heading -->
<section class="py-2">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Detail Group</h6>

      <a href="/admin/users/groups/edit/<?= $group['id']; ?>" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-pencil-alt"></i>
        </span>
        <span class="text">Edit Group</span>
      </a>
    </div>
    <div class="card-body">
      <form action="/admin/users/groups/save" method="post" class="user">
        <?= csrf_field(); ?>
        <div class="form-group row">
          <label for="name" class="col-sm-2 col-form-label">Nama Group</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Nama group..." value="<?= old('name') ? old('name') : $group['name']; ?>">

          </div>
        </div>
        <div class="form-group row">
          <label for="description" class="col-sm-2 col-form-label">Deskripsi</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="description" name="description" rows="4"><?= old('description') ? old('description') : $group['description']; ?></textarea>
          </div>
        </div>
        <div class="text-right" width="100%">
          <a href="/admin/users/groups" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</section>
<?= $this->endSection(); ?>