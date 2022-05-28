<?= $this->extend('templates/dashboard'); ?>

<!-- CONTENT -->
<?= $this->section('content'); ?>
<section class="py-2">
  <div class="flash-data" data-flashdata="<?= session()->getFlashdata('message'); ?>"></div>
  <?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success" role="alert">
      <?= session()->getFlashdata('message'); ?>
    </div>
  <?php endif; ?>

  <!-- DataTales Example -->
  <div class="text-right">
    <a href="/admin/users/main/report" class="btn btn-primary btn-icon-split mb-2" target="_blank">
      <span class="icon text-white-50">
        <i class="fas fa-print"></i>
      </span>
      <span class="text">Print</span>
    </a>
  </div>
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Daftar Admin</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Foto Profile</th>
              <th>Username</th>
              <th>Email</th>
              <th>Group</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>No</th>
              <th>Foto Profile</th>
              <th>Username</th>
              <th>Email</th>
              <th>Group</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php $i = 1; ?>
            <?php foreach ($users as $user) : ?>
              <?php if ($user['role_name'] == 'admin') :; ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><img width="40" src="/img/users/<?= $user['user_image']; ?>" alt="<?= $user['username']; ?> Image"></td>
                  <td><?= $user['username']; ?></td>
                  <td><?= $user['email']; ?></td>
                  <td><?= $user['role_name']; ?></td>
                  <td><?= $user['active'] == 1 ? 'Aktif' : 'Non Aktif'; ?></td>
                  <td class="text-center">
                    <a href="/admin/users/main/detail/<?= $user['id']; ?>" class="btn btn-info btn-sm"><i class="d-lg-none fas fa-book-open"></i><span class="d-none d-lg-inline">Detail</span></a>
                    <a href="/admin/users/main/edit/<?= $user['id']; ?>" class="btn btn-warning btn-sm"><i class="d-lg-none fa fa-pencil-alt"></i><span class="d-none d-lg-inline">Edit</span></a>
                    <form action="/admin/users/main/<?= $user['id']; ?>" method="POST" class="d-inline form-delete">
                      <?= csrf_field(); ?>
                      <input type="hidden" name="_method" value="DELETE">
                      <button type="submit" class="btn btn-danger btn-sm btn-delete"><span class="d-lg-none fa fa-trash"></span><span class="d-none d-lg-inline">Hapus</span></span></button>
                    </form>
                  </td>
                </tr>
              <?php endif; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Daftar User</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Foto Profile</th>
              <th>Username</th>
              <th>Email</th>
              <th>Group</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>No</th>
              <th>Foto Profile</th>
              <th>Username</th>
              <th>Email</th>
              <th>Group</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php $i = 1; ?>
            <?php foreach ($users as $user) : ?>
              <?php if ($user['role_name'] != 'admin') :; ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><img width="40" src="/img/users/<?= $user['user_image']; ?>" alt="<?= $user['username']; ?> Image"></td>
                  <td><?= $user['username']; ?></td>
                  <td><?= $user['email']; ?></td>
                  <td><?= $user['role_name']; ?></td>
                  <td><?= $user['active'] == 1 ? 'Aktif' : 'Non Aktif'; ?></td>
                  <td class="text-center">
                    <a href="/admin/users/main/detail/<?= $user['id']; ?>" class="btn btn-info btn-sm"><i class="d-lg-none fas fa-book-open"></i><span class="d-none d-lg-inline">Detail</span></a>
                    <a href="/admin/users/main/edit/<?= $user['id']; ?>" class="btn btn-warning btn-sm"><i class="d-lg-none fa fa-pencil-alt"></i><span class="d-none d-lg-inline">Edit</span></a>
                    <form action="/admin/users/main/<?= $user['id']; ?>" method="POST" class="d-inline form-delete">
                      <?= csrf_field(); ?>
                      <input type="hidden" name="_method" value="DELETE">
                      <button type="submit" class="btn btn-danger btn-sm btn-delete"><span class="d-lg-none fa fa-trash"></span><span class="d-none d-lg-inline">Hapus</span></span></button>
                    </form>
                  </td>
                </tr>
              <?php endif; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>



</section>
<?= $this->endSection(); ?>
<!-- END CONTENT -->

<?= $this->section('script'); ?>
<script>
  $(document).ready(function() {
    $('#dataTable').DataTable();
  });
</script>
<?= $this->endSection(); ?>