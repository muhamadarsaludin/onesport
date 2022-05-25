<?= $this->extend('templates/dashboard'); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>

<!-- Page Heading -->
<section class="py-2">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Edit Arena</h6>
    </div>
    <div class="card-body">
      <form action="/admin/arena/update/<?= $arena['id']; ?>" method="post" class="user" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="form-group row">
          <label for="venue_slug" class="col-sm-2 col-form-label">Kode Venue<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user <?= (session('errors.venue_slug') ? 'is-invalid' : ''); ?>" id="venue_slug" name="venue_slug" value="<?= old('venue_slug') ? old('venue_slug') : $arena['venue_slug']; ?>" placeholder="Kode Venue">
            <div class="invalid-feedback">
              <?= $validation->getError('venue_slug'); ?>
            </div>
          </div>
        </div>
        <!-- Image Arena -->
        <div class="form-group row">
          <label for="main-image" class="col-2 col-form-label">Gambar Arena<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-10">
            <div class="row">
              <!-- main image -->
              <div class="col-12">
                <div class="img-add w-100">
                  <label for="arena_image">
                    <img src="/img/venue/arena/main-images/<?= $arena['arena_image']; ?>"  class="main-preview object-fit" />
                  </label>
                  <small class="form-text text-muted text-center">recommended image size (1584x513 px).</small>
                  <input type="hidden" name="old-arena-image" value="<?= $arena['arena_image']; ?>">
                  <input id="arena_image" name="arena_image" type="file" class="<?= (session('errors.arena_image') ? 'is-invalid' : ''); ?>" onchange="previewImg('arena_image','main-preview')" />
                  <div class="invalid-feedback text-center">
                    <?= $validation->getError('arena_image'); ?>
                  </div>
                </div>
                <p class="text-center">Gambar Utama<sup class="text-danger font-weight-bold">*</sup></p>
              </div>
            </div>

            <div class="row">
              <?php $i=1; ?>
              <?php foreach($images as $image): ;?>
              <div class="col-6 col-lg-3 text-center">
                  <div class="img-add img-add-short">
                    <label for="image-<?= $i; ?>">
                      <img src="/img/venue/arena/other-images/<?= $image['image']; ?>"  class="image-preview-<?= $i; ?> object-fit" />
                    </label>
                    <input id="image-<?= $i; ?>" name="image-<?= $i; ?>" type="file" class="<?= (session('errors.image-<?=$i;?>') ? 'is-invalid' : ''); ?>" onchange="previewImg('image-<?= $i; ?>','image-preview-<?= $i; ?>')" />
                    <div class="invalid-feedback text-center">
                      <?= $validation->getError("image-" . $i); ?>
                    </div>
                  </div>
                  <p class="">Gambar <?= $i; ?></p>
                </div>
                <?php $i++; ?>
              <?php endforeach; ?>
              <?php for ($j = $i; $j <= 4; $j++) : ?>
                <div class="col-6 col-lg-3 text-center">
                  <div class="img-add img-add-short">
                    <label for="image-<?= $j; ?>">
                      <img src="/img/plus-circle.svg" class="image-preview-<?= $j; ?> icon-plus" />
                    </label>
                    <input id="image-<?= $j; ?>" name="image-<?= $j; ?>" type="file" class="<?= (session('errors.image-<?=$j;?>') ? 'is-invalid' : ''); ?>" onchange="previewImg('image-<?= $j; ?>','image-preview-<?= $j; ?>')" />
                    <div class="invalid-feedback text-center">
                      <?= $validation->getError("image-" . $j); ?>
                    </div>
                  </div>
                  <p class="">Gambar <?= $j; ?></p>
                </div>
              <?php endfor; ?>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="sport_id" class="col-sm-2 col-form-label">Olahraga<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <select class="custom-select" id="sport_id" name="sport_id">
              <option selected>Pilih salah satu...</option>
              <?php foreach ($sports as $sport) : ?>
                <option <?= $sport['id']==$arena['sport_id']?'selected':''; ?>  value="<?= $sport['id']; ?>"><?= $sport['sport_name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="active" class="col-sm-2 col-form-label">Status<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <select class="custom-select" id="active" name="active">
              <option selected>Pilih salah satu...</option>
              <option <?= $arena['active']==1?'selected':''; ?> value="1">Aktif</option>
              <option <?= $arena['active']!=1?'selected':''; ?> value="0">Non Aktif</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="description" class="col-sm-2 col-form-label">Deskripsi</label>
          <div class="col-sm-10">
            <textarea class="form-control" name="description" id="description" cols="30" rows="4"><?= old('description') ? old('description') : ''; ?><?= $arena['description']; ?></textarea>
          </div>
        </div>
        <div class="text-right" width="100%">
          <a href="/admin/arena" class="btn btn-secondary btn-sm">Kembali</a>
          <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</section>
<?= $this->endSection(); ?>