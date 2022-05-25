<?= $this->extend('templates/dashboard'); ?>

<?= $this->section('banner'); ?>

<nav aria-label="breadcrumb pt-4">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    <li class="breadcrumb-item"><a href=""><?= $arena['venue_name']; ?></a></li>
    <li class="breadcrumb-item">Arena <?= $arena['sport_name']; ?></li>
  </ol>
</nav>

<div class="flash-data" data-flashdata="<?= session()->getFlashdata('message'); ?>"></div>
<?php if (session()->getFlashdata('message')) : ?>
  <div class="alert alert-success" role="alert">
    <?= session()->getFlashdata('message'); ?>
  </div>
<?php endif; ?>

<div class="banner-container row">
  <div class="col-12">
    <img class="banner-img w-100 rounded" src="/img/venue/arena/main-images/<?= $arena['arena_image']; ?>">
  </div>
  <?php foreach ($images as $image) : ?>
    <div class="col-12">
      <img class="banner-img w-100 rounded" src="/img/venue/arena/other-images/<?= $image['image']; ?>">
    </div>
  <?php endforeach; ?>
</div>
<?= $this->endSection(); ?>

<!-- End Banner -->
<?= $this->section('content'); ?>

<!-- Page Heading -->
<section class="py-2">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Detail Arena</h6>
    </div>
    <div class="card-body">
      <form action="/admin/arena/update/<?= $arena['id']; ?>" method="post" class="user" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="form-group row">
          <label for="venue_slug" class="col-sm-2 col-form-label">Kode Venue<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-user <?= (session('errors.venue_slug') ? 'is-invalid' : ''); ?>" id="venue_slug" name="venue_slug" value="<?= old('venue_slug') ? old('venue_slug') : $arena['venue_slug']; ?>" placeholder="Kode Venue" readonly>
            <div class="invalid-feedback">
              <?= $validation->getError('venue_slug'); ?>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="sport_id" class="col-sm-2 col-form-label">Olahraga<sup class="text-danger font-weight-bold">*</sup></label>
          <div class="col-sm-10">
            <select class="custom-select" id="sport_id" name="sport_id" disabled>
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
            <select class="custom-select" id="active" name="active" disabled>
              <option selected>Pilih salah satu...</option>
              <option <?= $arena['active']==1?'selected':''; ?> value="1">Aktif</option>
              <option <?= $arena['active']!=1?'selected':''; ?> value="0">Non Aktif</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="description" class="col-sm-2 col-form-label">Deskripsi</label>
          <div class="col-sm-10">
            <textarea class="form-control" name="description" id="description" cols="30" rows="4" readonly><?= old('description') ? old('description') : ''; ?><?= $arena['description']; ?></textarea>
          </div>
        </div>
        <div class="text-right" width="100%">
          <a href="/admin/arena" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
      </form>
    </div>
  </div>

  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="row align-items-center justify-content-between">
        <div class="col-lg-2">
          <img src="/img/venue/logos/<?= $arena['logo']; ?>" alt="" class="w-100">
        </div>
        <div class="col-lg-7">
          <h5 class="m-0 font-weight-bold d-inline mr-2 text-gray-700"><?= $arena['venue_name']; ?></h5><span class="badge badge-primary"><?= $arena['level_name']; ?></span>
          <p class="m-0 mt-1"><?= $arena['address']; ?></p>
          <p class="mt-2 mb-0"><span class="small">start from</span> <span class="card-price text-primary font-weight-bold text-lg">Rp<?= number_format(150000, 0, ',', '.'); ?>,-</span></p>
          <div class="rating">
            <span class="fa fa-star text-warning"></span>
            <span class="fa fa-star text-warning"></span>
            <span class="fa fa-star text-warning"></span>
            <span class="fa fa-star text-warning"></span>
            <span class="fa fa-star text-secondary"></span>
            <span class="small">4.2 | 200 Penilaian</span>
          </div>
        </div>
        <div class="col-lg-3 text-right">
          <a href="" class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-fw fa-door-open"></i>
            </span>
            <span class="text">Kunjungi Venue</span>
          </a>
        </div>
      </div>
      <hr class="sidebar-divider">
      <h6 class="text-pirmary font-weight-bold">Fasilitas</h6>
      <?php if (session()->getFlashdata('facility-message')) : ?>
        <div class="alert alert-success" role="alert">
          <?= session()->getFlashdata('facility-message'); ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<!-- Initialize Swiper -->
<script>
  $(document).ready(function() {
    $('#dataTable').DataTable();
  });

  $('.banner-container').slick({
    slidesToShow: 1,
    dots: true,
    autoplay: true,
    infinite: true,
  });


  // checkbox
  $(".facilityCheckbox").on("click", function() {
    const facilityId = $(this).data("facility");
    const arenaId = $(this).data("arena");
    console.log(facilityId, arenaId);

    $.ajax({
      url: "<?= base_url('/venue/arena/facilities/addFacility') ?>",
      type: 'post',
      data: {
        'facilityId': facilityId,
        'arenaId': arenaId
      },
      success: function() {
        console.log('success add or remove facility');
        document.location.href = "<?= base_url('/venue/arena/main/detail/' . $arena['slug']); ?>";
      }
    })

  });
</script>
<?= $this->endSection(); ?>