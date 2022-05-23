<?= $this->extend('templates/dashboard'); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>
<section class="py-2">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Detail Olahraga</h6>

      <a href="/admin/sports/edit/<?= $sport['id']; ?>" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-pencil-alt"></i>
        </span>
        <span class="text">Edit Olahraga</span>
      </a>
    </div>
    <div class="card-body">
      <form action="/admin/sports/save" method="post" class="user" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="form-group row">
          <label for="sport_icon" class="col-2 col-form-label">Icon Olahraga<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-3">
            <div class="img-add rounded" width="100%">
              <label for="sport_icon">
                <img src="/img/sports/<?= $sport['sport_icon']; ?>" class="main-preview object-fit" />
              </label>
              <input id="sport_icon" name="sport_icon" type="file" class="" onchange="previewImg('sport_icon','main-preview')" />
              <div class="invalid-feedback text-center">
              </div>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="sport_name" class="col-sm-2 col-form-label">Nama Olahraga<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="sport_name" name="sport_name" placeholder="Nama olahraga..." value="<?= $sport['sport_name']; ?>" readonly>
            <div class="invalid-feedback">
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="description" class="col-sm-2 col-form-label">Deskripsi</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="description" name="description" placeholder="Deskripsi olahraga" rows="4" readonly><?= $sport['description']; ?></textarea>
          </div>
        </div>
        <!-- <div class="form-group">
          <div class="custom-control custom-checkbox small">
            <input type="checkbox" class="custom-control-input" id="active" name="active" checked>
            <label class="custom-control-label" for="active">Active?</label>
          </div>
        </div> -->
        <div class="text-right" width="100%">
          <a href="/admin/sports" class="btn btn-secondary btn-sm">Kembali</a>
          <!-- <button type="submit" class="btn btn-primary btn-sm">Save</button> -->
        </div>
      </form>
    </div>
  </div>
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Daftar Arena <?= $sport['sport_name']; ?></h6>

      <!-- <a href="/admin/sports/edit" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-pencil-alt"></i>
        </span>
        <span class="text">Edit Olahraga</span>
      </a> -->
    </div>
    <div class="card-body">
      <div class="container-fluid table-responsive">
        <table class="table table-bordered" id="dataTable" cellspacing="0">
          <table class="table table-bordered td-align-middle" id="dataVendors" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Arena</th>
                <th>Name Venue</th>
                <th>Status</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>Kode Arena</th>
                <th>Name Venue</th>
                <th>Status</th>
              </tr>
            </tfoot>
            <tbody>
            <?php $i=1; ?>
            <?php foreach($arenas as $arena): ;?>
              <tr>
                <td><?= $i++; ?></td>
                <td><?= $arena['slug']; ?></td>
                <td><?= $arena['venue_name']; ?></td>
                <td><?= $arena['active']==1?'Aktif':'Non Aktif'; ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
      </div>
    </div>
  </div>




</section>



<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
  $(document).ready(function() {
    $('#dataTable').DataTable();
  });
</script>
<?= $this->endSection(); ?>