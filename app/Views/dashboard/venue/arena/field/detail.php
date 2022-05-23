<?= $this->extend('templates/dashboard'); ?>
<!-- Banner -->
<?= $this->section('banner'); ?>

<nav aria-label="breadcrumb pt-4">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    <li class="breadcrumb-item"><a href=""><?= $field['field_name']; ?></a></li>
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
    <img class="banner-img w-100 rounded" src="/img/venue/arena/fields/main-images/<?= $field['field_image']; ?>">
  </div>
  <?php foreach ($images as $image) : ?>
    <div class="col-12">
      <img class="banner-img w-100 rounded" src="/img/venue/arena/fields/other-images/<?= $image['image']; ?>">
    </div>
  <?php endforeach; ?>
</div>
<?= $this->endSection(); ?>
<!-- End Banner -->


<?= $this->section('content'); ?>

<section class="my-5">
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="">
        <h3 class="m-0 font-weight-bold d-inline mr-2 text-gray-700"><?= $field['field_name']; ?></h3>
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
      <!-- Spesifikasi -->
      <section>
        <hr class="sidebar-divider">
        <h6 class="text-pirmary font-weight-bold">Spesifikasi</h6>
        <?php if (session()->getFlashdata('spec-message')) : ?>
          <div class="alert alert-success" role="alert">
            <?= session()->getFlashdata('spec-message'); ?>
          </div>
        <?php endif; ?>

        <div class="row">
          <div class="col-12 col-md-6">
            <div class="row mt-2">
              <div class="col-6">Tipe Lantai</div>
              <div class="col-6 text-dark">Vinyl</div>
            </div>
            <div class="row mt-2">
              <div class="col-6">Panjang Lapangan</div>
              <div class="col-6 text-dark">25 Meter</div>
            </div>
            <div class="row mt-2">
              <div class="col-6">Lebar Lapangan</div>
              <div class="col-6 text-dark">15 Meter</div>
            </div>
            <div class="row mt-2">
              <div class="col-6">Ukuran Gawang</div>
              <div class="col-6 text-dark">2x3 Meter</div>
            </div>
          </div>
        </div>


      </section>
      <!-- Deskripsi -->
      <section>
        <hr class="sidebar-divider">
        <h6 class="text-pirmary font-weight-bold">Deskripsi</h6>

        <div class="mt-1">
          <p class="">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolores similique nemo obcaecati consequuntur corrupti omnis eos culpa in vero et maiores ipsa velit, harum inventore provident consequatur corporis delectus cupiditate ipsam iste ab saepe ratione iure earum. Recusandae natus nobis sequi officiis quibusdam culpa eius sed cum maiores magni alias ea error quo quas dolores dolor, quam reprehenderit, perspiciatis velit et. Perspiciatis provident neque rerum suscipit, incidunt magni, officiis minima numquam facere esse nostrum. Magnam odio sequi numquam fugiat assumenda quisquam reprehenderit eaque possimus expedita labore, animi soluta eos, esse sit aliquam deleniti, itaque omnis laborum nemo tenetur at earum!</p>
        </div>
      </section>
    </div>
  </div>

  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Jadwal</h6>
      <a href="/venue/arena/field/schedule/main/add/<?= $field['slug']; ?>" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-plus-square"></i>
        </span>
        <span class="text">Tambah Jadwal</span>
      </a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Hari</th>
              <th>Waktu</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>No</th>
              <th>Hari</th>
              <th>Waktu</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </tfoot>
          <tbody>

            <?php $i = 1; ?>
            <?php foreach ($schedules as $schedule) : ?>
              <?php if ($schedule['served']) : ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $schedule['day']; ?></td>
                  <td><?= $schedule['start_time'] ?>-<?= $schedule['end_time']; ?></td>
                  <td><?= $schedule['active'] == 1 ? 'Active' : 'Non Active'; ?></td>
                  <td class="text-center">
                    <a href="/venue/arena/field/schedule/main/detail/<?= $schedule['id']; ?>" class="btn btn-info btn-sm"><i class="d-lg-none fa fa-pencil-alt"></i><span class="d-none d-lg-inline">Detail</span></a>
                    <a href="/venue/arena/field/schedule/main/edit/<?= $schedule['id']; ?>" class="btn btn-warning btn-sm"><i class="d-lg-none fa fa-pencil-alt"></i><span class="d-none d-lg-inline">Edit</span></a>
                    <form action="/venue/arena/field/schedule/main/<?= $schedule['id']; ?>" method="POST" class="d-inline form-delete">
                      <?= csrf_field(); ?>
                      <input type="hidden" name="_method" value="DELETE">
                      <button type="submit" class="btn btn-danger btn-sm btn-delete"><span class="d-lg-none fa fa-trash"></span><span class="d-none d-lg-inline">Hapus</span></span></button>
                    </form>
                  </td>
                </tr>
              <?php endif; ?>
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
</script>
<?= $this->endSection(); ?>