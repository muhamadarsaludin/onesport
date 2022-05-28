<?= $this->extend('templates/dashboard'); ?>


<?= $this->section('content'); ?>

<section class="my-5">
  <div class="flash-data" data-flashdata="<?= session()->getFlashdata('message'); ?>"></div>
  <?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success" role="alert">
      <?= session()->getFlashdata('message'); ?>
    </div>
  <?php endif; ?>
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Detail Jadwal <?= $schedule['day']; ?></h6>
      <a href="/venue/arena/field/schedule/detail/add/<?= $schedule['id']; ?>" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-plus-square"></i>
        </span>
        <span class="text">Tambah Jam Oprasional</span>
      </a>
    </div>
    <div class="card-body">    
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Waktu</th>
              <th>Harga</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>No</th>
              <th>Waktu</th>
              <th>Harga</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php $i = 1; ?>
            <?php foreach ($details as $detail) : ?>

              <tr>
                <td><?= $i++; ?></td>
                <td><?= $detail['start_time'] ?>-<?= $detail['end_time']; ?></td>
                <td>Rp<?= number_format($detail['price'], 0, ',', '.'); ?>,-</td>
                <td><?= $detail['active'] == 1 ? 'Active' : 'Non Active'; ?></td>
                <td class="text-center">
                  <a href="/venue/arena/field/schedule/detail/edit/<?= $detail['id']; ?>" class="btn btn-warning btn-sm"><i class="d-lg-none fa fa-pencil-alt"></i><span class="d-none d-lg-inline">Edit</span></a>
                  <form action="/venue/arena/field/schedule/detail/<?= $detail['id']; ?>" method="POST" class="d-inline form-delete">
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
      <div class="text-right mt-4" width="100%">
        <a href="/venue/arena/field/Main/detail/<?= $field['slug']; ?>" class="btn btn-secondary btn-sm">Kembali</a>
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