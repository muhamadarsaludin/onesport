<?= $this->extend('templates/dashboard'); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>

<!-- Page Heading -->
<section class="py-2">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Edit Banner</h6>
    </div>
    <div class="card-body">
      <form action="/venue/myvenue/banners/main/update/<?= $banner['id']; ?>" method="post" class="user" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <div class="form-group row">
          <label for="image" class="col-2 col-form-label">Gambar</label>
          <div class="col-10 row justify-content-between">
            <!-- main image -->
            <div class="img-add w-100">
              <label for="image">
                <img src="/img/banners/<?= $banner['image']; ?>" class="main-preview object-fit" />
              </label>
              <input id="image" name="image" type="file" class="<?= (session('errors.image') ? 'is-invalid' : ''); ?>" onchange="previewImg('image','main-preview')" />
              <input type="hidden" name="old-image" value="<?= $banner['image']; ?>">
              <div class="invalid-feedback text-center">
                <?= $validation->getError('image'); ?>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="title" class="col-sm-2 col-form-label">Judul</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user <?= ($validation->hasError('title') ? 'is-invalid' : ''); ?>" id="title" name="title" value="<?= old('title') ? old('title') : $banner['title']; ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('title'); ?>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="link" class="col-sm-2 col-form-label">Link</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user <?= ($validation->hasError('link') ? 'is-invalid' : ''); ?>" id="link" name="link" value="<?= old('link') ? old('link') : $banner['link']; ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('link'); ?>
            </div>
          </div>
        </div>
        <div class="text-right" width="100%">
          <a href="/admin/sports" class="btn btn-secondary btn-sm">Kembali</a>
          <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</section>
<?= $this->endSection(); ?>