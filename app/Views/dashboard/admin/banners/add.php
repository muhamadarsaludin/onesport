<?= $this->extend('templates/dashboard'); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>

<!-- Page Heading -->
<section class="py-2">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Tambah Banner</h6>
    </div>
    <div class="card-body">
      <form action="/admin/banners/save" method="post" class="user" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="form-group row">
          <label for="image" class="col-2 col-form-label">Gambar<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-10">
            <div class="img-add w-100 rounded">
              <label for="image">
                <img src="/img/plus-circle.svg" class="main-preview icon-plus" />
              </label>
              <input id="image" name="image" type="file" class="<?= (session('errors.image') ? 'is-invalid' : ''); ?>" onchange="previewImg('image','main-preview')" />
              <small id="emailHelp" class="form-text text-muted text-center">recommended size(1584x513 px).</small>
              <div class="invalid-feedback text-center">
                <?= $validation->getError('image'); ?>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="title" class="col-sm-2 col-form-label">Judul</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user <?= ($validation->hasError('title') ? 'is-invalid' : ''); ?>" id="title" name="title" placeholder="Judul Informasi">
            <div class="invalid-feedback">
              <?= $validation->getError('title'); ?>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="link" class="col-sm-2 col-form-label">Link</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user <?= ($validation->hasError('link') ? 'is-invalid' : ''); ?>" id="link" name="link" placeholder="Link">
            <div class="invalid-feedback">
              <?= $validation->getError('link'); ?>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="active" class="col-sm-2 col-form-label">Status<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <select class="custom-select" id="active" name="active">
              <option selected>Pilih salah satu...</option>
              <option value="1">Aktif</option>
              <option value="0">Non Aktif</option>
            </select>
          </div>
        </div>
        <div class="text-right" width="100%">
          <a href="/admin/banners" class="btn btn-secondary btn-sm">Kembali</a>
          <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</section>
<?= $this->endSection(); ?>