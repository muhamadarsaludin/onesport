  <!-- Topbar -->
  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <!-- <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
      <i class="fa fa-bars"></i>
    </button> -->

    <a class="navbar-brand" href="/">
      <img src="<?= base_url("/img/logos/logo.svg") ?>" class="" width="120" alt="Onesport Logo">
    </a>

    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
      <div class="input-group">
        <input type="text" class="form-control bg-light border-0 small" placeholder="Mau main futsal dimana...?" aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search fa-sm"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

      <!-- Nav Item - Search Dropdown (Visible Only XS) -->
      <li class="nav-item dropdown no-arrow d-sm-none">
        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-search fa-fw"></i>
        </a>
        <!-- Dropdown - Messages -->
        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
          <form class="form-inline mr-auto w-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Nav Item - Alerts -->
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw"></i>
          <!-- Counter - Alerts -->
          <?php if(logged_in() && notif()) :?>
            <span class="badge badge-danger badge-counter"><?= count(notif())<5?count(notif()):'4+'; ?></span>
          <?php endif; ?>
        </a>
        <!-- Dropdown - Alerts -->
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
          <h6 class="dropdown-header">
            Notifikasi
          </h6>
          <?php if(logged_in() && notif()) :?>
          <?php foreach (notif() as $notif ) : ?>
          <a class="dropdown-item d-flex align-items-center" href="<?= $notif['link']; ?>">
            <div class="mr-3">
              <div class="icon-circle bg-success">
                <i class="fa-solid fa-file-invoice-dollar text-white"></i>
              </div>
            </div>
            <div>
              <div class="small text-gray-500"><?= date("d F Y", strtotime($notif['created_at'])); ?></div>
              <span class="text-truncate"><?= $notif['message']; ?></span>
            </div>
          </a>
          <?php endforeach; ?>
          <a class="dropdown-item text-center small text-gray-500" href="/notification">Lihat semua notifikasi!</a>
          <?php endif; ?>
        </div>
      </li>

      <!-- Nav Item - Messages -->
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa-solid fa-receipt fa-fw"></i>
          <!-- Counter - Messages -->
          <?php if(logged_in() && transaction()): ?>
          <span class="badge badge-danger badge-counter"><?= count(transaction()); ?></span>
          <?php endif; ?>
        </a>
        <!-- Dropdown - Messages -->
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
          <h6 class="dropdown-header">
            Transaksi
          </h6>
          <?php if(logged_in() && transaction()): ?>
          <?php foreach(transaction() as $transaction) : ?>
          <a class="dropdown-item d-flex align-items-center" href="/transaction/detail/<?= $transaction['transaction_code']; ?>">
            <div class="mr-3">
              <div class="icon-circle bg-primary">
                <i class="fa-solid fa-receipt text-white"></i>
              </div>
            </div>
            <div>
              <div class="text-truncate"><?= $transaction['transaction_code']; ?></div>
              <div class="small text-gray-500"><?= $transaction['transaction_status']?$transaction['transaction_status']:'Failed'; ?></div>
            </div>
          </a>
          <?php endforeach; ?>
          <a class="dropdown-item text-center small text-gray-500" href="/transaction">Lihat semua transaksi!</a>
          <?php endif; ?>
        </div>
      </li>

      <div class="topbar-divider d-none d-sm-block"></div>
      <!-- Nav Item - Venue  -->
      <?php if (logged_in()) : ?>
        <li class="d-none d-lg-block nav-item dropdown no-arrow">

          <?php if (venue()) : ?>
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img class="img-profile rounded-circle mr-2" src="/img/venue/logos/<?= venue()->logo ? venue()->logo : 'default.png'; ?>">
              <span class="d-none d-lg-inline text-gray-600 small"><?= venue() ? venue()->venue_name : 'Nama Venue Belum diatur'; ?></span>
            </a>
          <?php else : ?>
            <a class="nav-link" href="/main/venueregister" id="">
              <img class="img-profile rounded-circle mr-2" src="/img/venue/logos/default.png">
              <span class="d-none d-lg-inline text-gray-600 small">Become a Venue</span>
            </a>
          <?php endif; ?>
          <!-- Dropdown - User Information -->
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <?php if (venue()) : ?>
              <a class="dropdown-item" href="/dashboard">
                <i class="fas fa-sm fa-fw fa-tachometer-alt mr-2 text-gray-400"></i>
                Dasboard
              </a>
              <a class="dropdown-item" href="/venue/upgrade">
                <i class="fas fa-sm fa-fw fa-rocket mr-2 text-gray-400"></i>
                Upgrade Venue
              </a>
            <?php endif; ?>
          </div>
        </li>
      <?php endif; ?>



    <?php if(logged_in()): ?>
      <!-- Nav Item - User Information -->
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img class="img-profile rounded-circle mr-2" src="/img/users/<?= logged_in() ? my_info()->user_image : 'default.png'; ?>">
          <span class="d-none d-lg-inline text-gray-600 small"><?= user() ? user()->username : ''; ?></span>
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <!-- <a class="dropdown-item" href="#">
              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
              Profile
            </a>
            <a class="dropdown-item" href="#">
              <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
              Settings
            </a>
             -->
            <!-- <div class="dropdown-divider"></div> -->
            <?php if(in_groups('admin')):; ?>
            <a class="dropdown-item" href="/dashboard">
              <i class="fas fa-sm fa-fw fa-tachometer-alt mr-2 text-gray-400"></i>
              Dashboard
            </a>
            <?php endif; ?>
            <a class="dropdown-item" href="/logout" data-toggle="modal" data-target="#logoutModal">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Logout
            </a>
        </div>
      </li>
    <?php else: ?>
      <li class="nav-item no-arrow">
          <div class="nav-link">
              <a class="btn btn-outline-primary" href="<?= base_url('login'); ?>">Login</a>
          </div>
      </li>
      <li class="nav-item no-arrow">
          <div class="nav-link">
              <a class="btn btn-primary" href="<?= base_url('register'); ?>">Register</a>
          </div>
      </li>
    <?php endif; ?>
    </ul>

  </nav>
  <!-- End of Topbar -->