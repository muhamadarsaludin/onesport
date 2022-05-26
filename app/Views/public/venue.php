<?= $this->extend('templates/main'); ?>

<?= $this->section('banner'); ?>
<nav aria-label="breadcrumb pt-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><?= $venue['venue_name']; ?></li>
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
        <div class="card-body">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-2">
                    <img src="/img/venue/logos/<?= $venue['logo']; ?>" alt="" class="w-100">
                </div>
                <div class="col-lg-10">
                    <h5 class="m-0 font-weight-bold d-inline mr-2 text-gray-700"><?= $venue['venue_name']; ?></h5><span class="badge badge-primary"><?= $venue['level_name']; ?></span>
                    <p class="m-0 mt-1"><?= $venue['address']; ?></p>
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
            </div>
            <hr class="sidebar-divider">
            <h6 class="text-pirmary font-weight-bold">Deskripsi</h6>
            <p><?= $venue['description']; ?></p>
        </div>
    </div>

    <?php foreach ($arenas as $arena) : ?>
        <!-- Show All Arena -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= $arena['sport_name']; ?></h6>
            </div>
        </div>
        <div class="row mb-4">
        <?php foreach ($fields as $field) : ?>
            <?php if ($arena['id'] == $field['arena_id']) : ?>
                    <div class="col-12 col-lg-3">
                        <a href="/main/field/<?= $field['slug']; ?>" class="clear-style">
                            <div class="card shadow text-gray-600">
                                <img class="card-img-top img-card-arena" src="/img/venue/arena/fields/main-images/<?= $field['field_image']; ?>">
                                <div class="card-body">
                                    <h6 class="m-0 font-weight-bold d-inline mr-2 text-gray-700"><?= $field['field_name']; ?></h6><span class="badge badge-primary"></span>
                                    <p class="mt-1"><span class="text-xs">start from</span> <span class="card-price text-primary font-weight-bold text-lg">Rp<?= number_format(150000, 0, ',', '.'); ?>,-</span></p>
                                    <div class="rating">
                                        <span class="fa fa-star text-warning"></span>
                                        <span class="fa fa-star text-warning"></span>
                                        <span class="fa fa-star text-warning"></span>
                                        <span class="fa fa-star text-warning"></span>
                                        <span class="fa fa-star text-secondary"></span>
                                        <span class="text-xs">4.2 | 200 Penilaian</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>

    <?php endforeach; ?>

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