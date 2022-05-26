<?= $this->extend('templates/dashboard'); ?>

<?= $this->section('banner'); ?>
<nav aria-label="breadcrumb pt-4">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    <li class="breadcrumb-item"><a href=""><?= $venue['venue_name']; ?></a></li>
  </ol>
</nav>


<?php if ($banners) : ?>
  <div class="banner-container row">
    <?php foreach ($banners as $banner) : ?>
      <div class="col-12">
        <img class="banner-img w-100 rounded" src="/img/banners/<?= $banner['image']; ?>">
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<section class="my-5">

  <div class="card shadow mb-4">
  <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Profile Venue</h6>

      <a href="/venue/myvenue/main/edit" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
          <!-- <i class="fas fa-plus-square"></i> -->
          <i class="fas fa-pencil-alt"></i>
        </span>
        <span class="text">Edit Venue</span>
      </a>
    </div>
    <div class="card-body">
      <div class="row align-items-center justify-content-between">
        <div class="col-lg-3">
          <img src="/img/venue/logos/<?= $venue['logo']; ?>" alt="" class="w-100">
        </div>
        <div class="col-lg-9">
          <h4 class="m-0 font-weight-bold d-inline mr-2 text-gray-700"><?= $venue['venue_name']; ?></h4><span class="badge badge-primary"><?= $venue['level_name']; ?></span>
          <p class="m-0 mt-1"><?= $venue['address']; ?> (<?= $venue['postal_code']; ?>)</p>
          <p class="mb-3"><i class="fa-solid fa-phone"></i> <?= $venue['contact']; ?></p>
          <h6 class="font-weight-bold d-inline text-gray-700">
            Deskripsi
          </h6>
          <p><?= $venue['description']; ?></p>
      </div>
    </div>
  </div>

</section>



<?= $this->endSection(); ?>


<?= $this->section('script'); ?>
<!-- Initialize Swiper -->
<script>
  $('.banner-container').slick({
    slidesToShow: 1,
    dots: true,
    autoplay: true,
    infinite: true,
  });
</script>
<?= $this->endSection(); ?>