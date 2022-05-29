<?= $this->extend('templates/main'); ?>

<!-- CONTENT -->
<?= $this->section('content'); ?>
<section class="py-2">
  <div class="flash-data" data-flashdata="<?= session()->getFlashdata('message'); ?>"></div>
  <?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success" role="alert">
      <?= session()->getFlashdata('message'); ?>
    </div>
  <?php endif; ?>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Review Transaksi</h6>
    </div>
    <div class="card-body">
      <h2 class="font-weight-bold text-primary"><?= $transaction['transaction_code']; ?></h2>
      
      <div class="card shadow mb-4">
        <div class="card-body">
          <img src="/img/venue/arena/fields/main-images/<?= $transaction['field_image']; ?>" alt="" style="height: 280px;" class="w-100 img-responsive rounded mb-4">
          <h3 class="font-weight-bold d-inline mr-2 text-gray-700"><?= $transaction['field_name']; ?></h3>
          <form action="/transaction/savereview/<?= $transaction['transaction_code']; ?>" method="POST" class="mt-4">
          <input type="hidden" class="form-control form-control-user <?= (session('errors.transaction_id') ? 'is-invalid' : ''); ?>" id="transaction_id" name="transaction_id" value="<?= $transaction['id']; ?>" >
          <input type="hidden" class="form-control form-control-user <?= (session('errors.user_id') ? 'is-invalid' : ''); ?>" id="user_id" name="user_id" value="<?= $transaction['user_id']; ?>" >
          <input type="hidden" class="form-control form-control-user <?= (session('errors.field_id') ? 'is-invalid' : ''); ?>" id="field_id" name="field_id" value="<?= $transaction['field_id']; ?>" >
          <input type="hidden" class="form-control form-control-user <?= (session('errors.venue_id') ? 'is-invalid' : ''); ?>" id="venue_id" name="venue_id" value="<?= $transaction['venue_id']; ?>" >
          <div class="form-group row">
            <label for="rating" class="col-sm-2 col-form-label">Rating</label>
            <div class="col-sm-10">
              <div id="start-wrapper">
                <i class="fa-solid fa-star" onclick="giveRating(1)"></i>
                <i class="fa-solid fa-star" onclick="giveRating(2)"></i>
                <i class="fa-solid fa-star" onclick="giveRating(3)"></i>
                <i class="fa-solid fa-star" onclick="giveRating(4)"></i>
                <i class="fa-solid fa-star" onclick="giveRating(5)"></i>
              </div>
              <input type="hidden" class="form-control form-control-user <?= (session('errors.rating') ? 'is-invalid' : ''); ?>" id="rating" name="rating" value="<?= old('rating') ? old('rating') : ''; ?>">
              <div class="invalid-feedback">
                <?= $validation->getError('rating'); ?>
              </div>
            </div>
          </div>  

            <div class="form-group row">
              <label for="review" class="col-sm-2 col-form-label">Review</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="review" id="review" cols="30" rows="4"><?= old('review') ? old('review') : ''; ?></textarea>
              </div>
          </div>
          <div class="text-right" width="100%">
            <a href="/transaction" class="btn btn-secondary btn-sm">Kembali</a>
            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>



</section>
<?= $this->endSection(); ?>
<!-- END CONTENT -->

<?= $this->section('script'); ?>
<script>  
  

  function giveRating(starValue) {
    document.getElementById('rating').value = starValue;
    templates = '';
      for (let i = 0; i < starValue; i++) {
        templates +=`<i class="fa-solid fa-star text-warning"  onclick="giveRating(${i+1})"></i>`        
      }
      for (let i = starValue; i < 5; i++) {
        templates +=`<i class="fa-solid fa-star"  onclick="giveRating(${i+1})"></i>` 
      }
      let startWrapper = document.getElementById('start-wrapper');
      startWrapper.innerHTML = templates
  }

</script>
<?= $this->endSection(); ?>