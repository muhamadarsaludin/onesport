<?= $this->extend('templates/dashboard'); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>

<!-- Page Heading -->
<section class="py-2">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Edit Olahraga</h6>
    </div>
    <div class="card-body">
      <form action="/admin/sports/update/<?= $sport['id']; ?>" method="post" class="user" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="form-group row">
          <label for="sport_icon" class="col-2 col-form-label">Icon Olahraga<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-3">
            <div class="img-add rounded" width="100%">
              <label for="sport_icon">
                <img src="/img/sports/<?= $sport['sport_icon']; ?>" class="main-preview object-fit" />
              </label>
              <input id="sport_icon" name="sport_icon" type="file" class="<?= (session('errors.sport_icon') ? 'is-invalid' : ''); ?>" onchange="previewImg('sport_icon','main-preview')" />
              <div class="invalid-feedback text-center">
                <?= $validation->getError('sport_icon'); ?>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="sport_name" class="col-sm-2 col-form-label">Nama Olahraga<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user <?= (session('errors.sport_name') ? 'is-invalid' : ''); ?>" id="sport_name" name="sport_name" placeholder="Nama olahraga..." value="<?= (old('sport_name')) ? old('sport_name') : $sport['sport_name']; ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('sport_name'); ?>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="description" class="col-sm-2 col-form-label">Deskripsi</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="description" name="description" placeholder="Deskripsi olahraga" rows="4"><?= (old('description')) ? old('description') : $sport['description']; ?></textarea>
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
          <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        </div>
      </form>
    </div>
  </div>




</section>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
  $(document).ready(function() {
    $('#dataUsers').DataTable();
  });
</script>
<?= $this->endSection(); ?>