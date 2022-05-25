<?= $this->extend('templates/dashboard'); ?>



<?= $this->section('content'); ?>

<section class="my-5">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Data Jadwal</h6>
      <!-- <a href="/venue/arena/field/schedule/main/add/" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-plus-square"></i>
        </span>
        <span class="text">Tambah Jadwal</span>
      </a> -->
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
                    <a href="/admin/schedule/main/detail/<?= $schedule['id']; ?>" class="btn btn-info btn-sm"><i class="d-lg-none fa fa-pencil-alt"></i><span class="d-none d-lg-inline">Detail</span></a>
                    <a href="/admin/schedule/main/edit/<?= $schedule['id']; ?>" class="btn btn-warning btn-sm"><i class="d-lg-none fa fa-pencil-alt"></i><span class="d-none d-lg-inline">Edit</span></a>
                    <form action="/admin/schedule/main/<?= $schedule['id']; ?>" method="POST" class="d-inline form-delete">
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