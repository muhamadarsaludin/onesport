<?= $this->extend('templates/main'); ?>


<!-- Banner -->
<?= $this->section('banner'); ?>
<nav aria-label="breadcrumb pt-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/main/venue/<?= $arena['venue_slug']; ?>"><?= $arena['venue_name']; ?></a></li>
        <li class="breadcrumb-item">Arena <?= $arena['sport_name']; ?></li>
    </ol>
</nav>

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

<section class="my-5">

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
                    <a href="/main/venue/<?= $arena['venue_slug']; ?>" class="btn btn-primary btn-icon-split">
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


            <div class="row align-items-center mt-4">
                <?php foreach ($facilities as $facility) : ?>
                    <?php if ($facility['served']) : ?>
                        <div class="col-lg-3 mb-1 row">
                            <div class="col-12">
                                <p><i class="<?= $facility['icon']; ?>"></i> <?= $facility['facility_name']; ?></p>
                            </div>
                        </div>
                    <?php endif ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Lapangan <?= $arena['sport_name']; ?></h6>
        </div>
    </div>
    <?php foreach ($fields as $field) : ?>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-2">
                        <img src="/img/venue/arena/fields/main-images/<?= $field['field_image']; ?>" alt="" class="w-100">
                    </div>
                    <div class="col-lg-7">
                        <h5 class="m-0 font-weight-bold d-inline mr-2 text-gray-700"><?= $field['field_name']; ?></h5>
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
                        <a href="/main/field/<?= $field['slug']; ?>" class="btn btn-primary">
                            <span class="text">Pilih Lapangan</span>
                        </a>
                    </div>
                </div>
            </div>
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