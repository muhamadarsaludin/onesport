<?= $this->extend('templates/dashboard'); ?>
<!-- Banner -->
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

<section class="my-5">

  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="row align-items-center justify-content-between">
        <div class="col-lg-2">
          <img src="/img/venue/logos/<?= $arena['logo']?$arena['logo']:'default.png'; ?>" alt="" class="w-100">
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


      <div class="row align-items-center mt-4">
        <?php $i = 1; ?>
        <?php foreach ($facilities as $facility) : ?>
          <div class="col-lg-3 mb-1 row">
            <div class="col-9">
              <p><i class="<?= $facility['icon']; ?>"></i> <?= $facility['facility_name']; ?></p>
            </div>
            <div class="col-3">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" data-facility="<?= $facility['id']; ?>" data-arena="<?= $arena['id']; ?>" class="custom-control-input facilityCheckbox" id="customCheck<?= $i; ?>" <?= $facility['served'] ? 'checked' : ''; ?>>
                <label class="custom-control-label" for="customCheck<?= $i; ?>">&nbsp;</label>
              </div>
            </div>
          </div>
          <?php $i++ ?>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Daftar Lapangan <?= $arena['sport_name']; ?></h6>
      <a href="/venue/arena/field/Main/add/<?= $arena['slug']; ?>" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-plus-square"></i>
        </span>
        <span class="text">Tambah Lapangan</span>
      </a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th width="150">Image</th>
              <th>Nama Lapangan</th>
              <th>Status</th>
              <th>Penilaian</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>No</th>
              <th>Image</th>
              <th>Nama Lapangan</th>
              <th>Status</th>
              <th>penilaian</th>
              <th>Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php $i = 1 ?>
            <?php foreach ($fields as $field) : ?>
              <tr>
                <td><?= $i++; ?></td>
                <td><img src="/img/venue/arena/fields/main-images/<?= $field['field_image']; ?>" alt="" class="w-100"></td>
                <td><?= $field['field_name']; ?></td>
                <td><?= $field['active'] == 1 ? 'Aktif' : 'Non Aktif'; ?></td>
                <td><?= $field['rating'] == null ? 'Belum Ada Penilaian' : $field['rating']; ?></td>
                <td class="text-center">
                  <a href="/venue/arena/field/Main/detail/<?= $field['slug']; ?>" class="btn btn-info btn-sm"><i class="d-lg-none fa fa-pencil-alt"></i><span class="d-none d-lg-inline">Detail</span></a>
                  <a href="/venue/arena/field/Main/edit/<?= $field['slug']; ?>" class="btn btn-warning btn-sm"><i class="d-lg-none fa fa-pencil-alt"></i><span class="d-none d-lg-inline">Edit</span></a>
                  <form action="/venue/arena/field/Main/<?= $field['id']; ?>" method="POST" class="d-inline form-delete">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger btn-sm btn-delete"><span class="d-lg-none fa fa-trash"></span><span class="d-none d-lg-inline">Hapus</span></span></button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>

        </table>
      </div>
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