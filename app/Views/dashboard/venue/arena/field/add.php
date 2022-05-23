<?= $this->extend('templates/dashboard'); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>

<!-- Page Heading -->
<section class="py-2">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Tambah Lapangan <?= $arena['sport_name']; ?></h6>
    </div>
    <div class="card-body">
      <form action="/venue/arena/field/main/save" method="post" class="user" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <!-- Image Arena -->
        <div class="form-group row">
          <label for="main-image" class="col-2 col-form-label">Gambar Lapang</label>
          <div class="col-10">
            <div class="row">
              <!-- main image -->
              <div class="col-12">
                <div class="img-add w-100">
                  <label for="field_image">
                    <img src="/img/plus-circle.svg" class="main-preview icon-plus" />
                  </label>
                  <input id="field_image" name="field_image" type="file" class="<?= (session('errors.field_image') ? 'is-invalid' : ''); ?>" onchange="previewImg('field_image','main-preview')" />
                  <div class="invalid-feedback text-center">
                    <?= $validation->getError('field_image'); ?>
                  </div>
                </div>
                <p class="text-center">Gambar Utama<sup class="text-danger font-weight-bold">*</sup></p>
              </div>

            </div>
            <div class="row">
              <?php for ($i = 1; $i <= 4; $i++) : ?>
                <div class="col-6 col-lg-3 text-center">
                  <div class="img-add img-add-short">
                    <label for="image-<?= $i; ?>">
                      <img src="/img/plus-circle.svg" class="image-preview-<?= $i; ?> icon-plus" />
                    </label>
                    <input id="image-<?= $i; ?>" name="image-<?= $i; ?>" type="file" class="<?= (session('errors.image-<?=$i;?>') ? 'is-invalid' : ''); ?>" onchange="previewImg('image-<?= $i; ?>','image-preview-<?= $i; ?>')" />
                    <div class="invalid-feedback text-center">
                      <?= $validation->getError("image-" . $i); ?>
                    </div>
                  </div>
                  <p class="">Gambar <?= $i; ?></p>
                </div>
              <?php endfor; ?>
            </div>
          </div>
        </div>

        <input type="hidden" class="form-control form-control-user" id="arena_id" name="arena_id" value="<?= $arena['id']; ?>">
        <input type="hidden" class="form-control form-control-user" id="arena_slug" name="arena_slug" value="<?= $arena['slug']; ?>">

        <div class="form-group row">
          <label for="field_name" class="col-sm-2 col-form-label">Nama Lapangan</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user <?= (session('errors.field_name') ? 'is-invalid' : ''); ?>" id="field_name" name="field_name" value="<?= old('field_name') ? old('field_name') : ''; ?>" placeholder="Nama Lapangan">
            <div class="invalid-feedback">
              <?= $validation->getError('field_name'); ?>
            </div>
          </div>
        </div>
        <!-- 
        <?php foreach ($specs as $spec) : ?>
          <div class="form-group row">
            <label for="spec-<?= $spec['id']; ?>" class="col-sm-2 col-form-label"><?= $spec['spec_name']; ?></label>
            <div class="col-sm-10">
              <input type="text" class="form-control form-control-user <?= (session('errors.spec-' . $spec['id']) ? 'is-invalid' : ''); ?>" id="spec-<?= $spec['id']; ?>" name="spec-<?= $spec['id']; ?>" value="<?= old('spec-' . $spec['id']) ? old('spec-' . $spec['id']) : ''; ?>" placeholder="Nilai spesifikasi">
              <div class="invalid-feedback">
                <?= $validation->getError('spec-' . $spec['id']); ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?> -->



        <div class="form-group row">
          <label for="description" class="col-sm-2 col-form-label">Deskripsi</label>
          <div class="col-sm-10">
            <textarea class="form-control" name="description" id="description" cols="30" rows="4"><?= old('description') ? old('description') : ''; ?></textarea>
          </div>
        </div>
        <div class="text-right" width="100%">
          <a href="/venue/arena/main/detail/<?= $arena['slug']; ?>" class="btn btn-secondary btn-sm">Kembali</a>
          <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</section>
<?= $this->endSection(); ?>