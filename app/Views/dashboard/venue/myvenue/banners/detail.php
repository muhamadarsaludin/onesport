<?= $this->extend('templates/dashboard'); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>
<section class="py-2">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Detail Banner</h6>

      <a href="/venue/myvenue/banners/main/edit/<?= $banner['id']; ?>" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-pencil-alt"></i>
        </span>
        <span class="text">Edit Banner</span>
      </a>
    </div>
    <div class="card-body">
      <form action="/admin/banner/update/<?= $banner['id']; ?>" method="post" class="user mt-4">
        <?= csrf_field(); ?>

        <div class="form-group row">
          <label for="image" class="col-2 col-form-label">Gambar</label>
          <div class="col-10 row justify-content-between">
            <!-- main image -->
            <div class="img-add w-100">
              <label for="image">
                <img src="/img/banners/<?= $banner['image']; ?>" class="main-preview object-fit" />
              </label>
              <input id="image" name="image" type="file" class="" onchange="previewImg('image','main-preview')" />
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="title" class="col-sm-2 col-form-label">Judul</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="title" name="title" placeholder="" value="<?= (old('title')) ? old('title') : $banner['title']; ?>" readonly>
          </div>
        </div>

        <div class="form-group row">
          <label for="link" class="col-sm-2 col-form-label">Link</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user" id="link" name="link" placeholder="" value="<?= (old('link')) ? old('link') : $banner['link']; ?>" readonly>
          </div>
        </div>

        <div class="form-group row">
          <label for="active" class="col-sm-2 col-form-label">Status<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <select class="custom-select" id="active" name="active" disabled>
              <option selected>Pilih salah satu...</option>
              <option <?= $banner['active'] == 1 ? 'selected' : ''; ?> value="1">Aktif</option>
              <option <?= $banner['active'] == 0 ? 'selected' : ''; ?> value="0">Non Aktif</option>
            </select>
          </div>
        </div>
        <div class="text-right" width="100%">
          <a href="/venue/myvenue/banners/main/" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</section>



<?= $this->endSection(); ?>