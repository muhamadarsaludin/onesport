<?= $this->extend('templates/dashboard'); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>
<section class="py-2">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Detail Spesifikasi</h6>

      <a href="/admin/specifications/edit/<?= $spec['id']; ?>" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-pencil-alt"></i>
        </span>
        <span class="text">Edit Spesifikasi</span>
      </a>
    </div>
    <div class="card-body">
      <form action="/admin/specifications/save" method="post" class="user" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="form-group row">
          <label for="spec_name" class="col-sm-2 col-form-label">Spesifikasi<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="spec_name" name="spec_name" placeholder="Nama olahraga..." value="<?= $spec['spec_name']; ?>" readonly>
            <div class="invalid-feedback">
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="sport_id" class="col-sm-2 col-form-label">Olahraga<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <select class="custom-select" id="sport_id" name="sport_id" disabled>
              <option selected>Pilih salah satu...</option>
              <?php foreach ($sports as $sport) : ?>
                <option <?= $sport['id'] == $spec['sport_id'] ? 'selected' : ''; ?> value="<?= $sport['id']; ?>"><?= $sport['sport_name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="form-group row">
          <label for="description" class="col-sm-2 col-form-label">Deskripsi</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="description" name="description" placeholder="Deskripsi spesifikasi" rows="4" readonly><?= old('description') ? old('description') : $spec['description']; ?></textarea>
          </div>
        </div>
        <div class="text-right" width="100%">
          <a href="/admin/specifications" class="btn btn-secondary btn-sm">Kembali</a>
          <!-- <button type="submit" class="btn btn-primary btn-sm">Save</button> -->
        </div>
      </form>
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