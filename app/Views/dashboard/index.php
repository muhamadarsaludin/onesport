<?= $this->extend('templates/dashboard'); ?>

<!-- Banner -->
<?= $this->section('banner'); ?>
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
<!-- End Banner -->



<!-- SCRIPT -->
<?= $this->section('script'); ?>
<script>
  $('.banner-container').slick({
    slidesToShow: 1,
    autoplay: true,
    infinite: true,
  });
</script>
<?= $this->endSection(); ?>