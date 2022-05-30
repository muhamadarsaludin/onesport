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
<?= $this->section('content');?>

<div class="row mt-4">
<?php if(in_groups('admin')):; ?>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total User</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_user; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas  fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Venue</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_venue; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas  fa-store fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Arena</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_arena; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-landmark-flag fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Lapangan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_lapangan; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-futbol fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Pemasukan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp<?= number_format($total_earnings, 0, ',', '.'); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-wallet fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Transaksi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_transaksi; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-receipt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Transaksi Berhasil</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_trans_success; ?></div>
                    </div>
                    <div class="col-auto">
                    <i class="fa-solid fa-receipt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Transaksi Down payment</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_trans_dp; ?></div>
                    </div>
                    <div class="col-auto">
                    <i class="fa-solid fa-receipt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Menunggu Pembayaran</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_trans_pending; ?></div>
                    </div>
                    <div class="col-auto">
                    <i class="fa-solid fa-receipt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Transaksi Dibatalkan!</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_trans_cancel; ?></div>
                    </div>
                    <div class="col-auto">
                    <i class="fa-solid fa-receipt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Transaksi Gagal!</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_trans_failed; ?></div>
                    </div>
                    <div class="col-auto">
                    <i class="fa-solid fa-receipt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection();?>



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