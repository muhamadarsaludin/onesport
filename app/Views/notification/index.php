<?= $this->extend('templates/main'); ?>


<?= $this->section('content'); ?>
<div class="container-fluid">
	<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-primary">Notifikasi</h6>
			</div>
			<div class="card-body">
			<div class="flash-data" data-flashdata="<?= session()->getFlashdata('message'); ?>"></div>
			<?php if (session()->getFlashdata('message')) : ?>
				<div class="alert alert-success" role="alert">
					<?= session()->getFlashdata('message'); ?>
				</div>
			<?php endif; ?>
			<?php foreach($notification as $notif) : ?>
				<div class="card shadow p-3 mb-2">
					<a href="<?= $notif['link']; ?>" style="text-decoration: none;">
						<div class="row justify-content-between align-items-center">
							<div class="col-11">
								<span class='small badge badge-primary'><?= date("d F Y", strtotime($notif['created_at'])); ?></span>
								<p class="text-wrap text-black-50 m-0 mt-1"><?= $notif['message']; ?></p>
							</div>
							<div class="col-1">
								<form action="/notification/<?= $notif['id']; ?>" method="POST" class="d-inline form-delete">
									<?= csrf_field(); ?>
									<input type="hidden" name="_method" value="DELETE">
									<button class="btn btn-danger float-right">
										<i class="fa-solid fa-xmark"></i>
									</button>
								</form>
							</div>
						</div>
					</a>
				</div>
			<?php endforeach; ?>
			</div>
	</div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    getItemInUserCart();
</script>
<?= $this->endSection(); ?>
    