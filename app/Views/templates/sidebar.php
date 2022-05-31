<ul class="navbar-nav bg-white sidebar sidebar-light accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
    <div class="sidebar-brand-icon">
      <img src="/img/logos/logo.svg" alt="" class="img-responsive" width="70%" alt="Onesport Logo">
    </div>

  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
    <a class="nav-link" href="/dashboard">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">
<?php if(in_groups('admin')):; ?>
  <!-- Heading -->
  <div class="sidebar-heading">
    Admin
  </div>
  <!-- Nav Item Sport -->
  <li class="nav-item">
    <a class="nav-link" href="<?= base_url('admin/sports'); ?>">
      <i class="fas fa-fw fa-futbol"></i>
      <span>Olahraga</span></a>
  </li>
  <!-- Nav Item Fasilitas -->
  <li class="nav-item">
    <a class="nav-link" href="<?= base_url('admin/facilities'); ?>">
      <i class="fas fa-fw fa-hand-holding-heart"></i>
      <span>Fasilitas</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="<?= base_url('admin/specifications'); ?>">
      <i class="fas fa-fw fa-clipboard-list"></i>
      <span>Spesifikasi</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="<?= base_url('admin/banners'); ?>">
      <i class="fas fa-fw fa-bullhorn"></i>
      <span>Banner Informasi</span></a>
  </li>
  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser" aria-expanded="true" aria-controls="collapseUser">
      <i class="fas fa-fw fa-user"></i>
      <span>Data User</span>
    </a>
    <div id="collapseUser" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Data Master User</h6>
        <a class="collapse-item" href="<?= base_url('admin/users/main'); ?>">Daftar User</a>
        <a class="collapse-item" href="<?= base_url('admin/users/groups'); ?>">Group User</a>
      </div>
    </div>
  </li>

  <!-- Nav Item - Utilities Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVendor" aria-expanded="true" aria-controls="collapseVendor">
      <i class="fas fa-fw fa-store"></i>
      <span>Data Venue</span>
    </a>
    <div id="collapseVendor" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Data Master Venue</h6>
        <a class="collapse-item" href="<?= base_url('admin/venue/main'); ?>">Daftar Venue</a>
        <a class="collapse-item" href="<?= base_url('admin/venue/levels'); ?>">Level Venue</a>
      </div>
    </div>
  </li>

  <!-- Nav Item - Utilities Collapse Menu -->

  <li class="nav-item">
    <a class="nav-link" href="<?= base_url('admin/arena'); ?>">
    <i class="fa-solid fa-landmark-flag"></i>
      <span>Arena Olahraga</span></a>
  </li>


  <li class="nav-item">
    <a class="nav-link" href="<?= base_url('admin/field'); ?>">
      <i class="fas fa-fw fa-futbol"></i>
      <span>Lapangan</span></a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseArena" aria-expanded="true" aria-controls="collapseArena">
    <i class="fa-solid fa-calendar"></i>
      <span>Data Jadwal</span>
    </a>
    <div id="collapseArena" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Data Master Arena</h6>
        <a class="collapse-item" href="/admin/schedule/day">Hari Operasional</a>
        <a class="collapse-item" href="/admin/schedule/main">Data Jadwal</a>
        <a class="collapse-item" href="/admin/schedule/detail">Data Detail Jadwal</a>
      </div>
    </div>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTransaction" aria-expanded="true" aria-controls="collapseTransaction">
    <i class="fa-solid fa-receipt fa-fw"></i>
      <span>Transaksi</span>
    </a>
    <div id="collapseTransaction" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Data Transaksi</h6>
        <a class="collapse-item" href="/admin/transaction">Data Semua Transaksi</a>
        <a class="collapse-item" href="/admin/transaction/downpayment">Data Downpayment</a>
        <a class="collapse-item" href="/admin/transaction/canceled">Pembatalan Transaksi</a>
        <a class="collapse-item" href="/admin/transaction/failed">Data Transaksi Gagal</a>
        <a class="collapse-item" href="/admin/transaction/report_view">Laporan Transaksi</a>
      </div>
    </div>
  </li>
  <!-- Nav Item - Utilities Collapse Menu -->

 
  
  

  <!-- Divider -->
  <hr class="sidebar-divider">

  <?php endif; ?>
  <?php if(in_groups('venue')):; ?>
  <!-- Heading -->
  <div class="sidebar-heading">
    Venue
  </div>
  <!-- Nav Item - Utilities Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMyVendor" aria-expanded="true" aria-controls="collapseMyVendor">
      <i class="fas fa-fw fa-store"></i>
      <span>Venue Saya</span>
    </a>
    <div id="collapseMyVendor" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Menu Venue Saya</h6>
        <a class="collapse-item" href="/venue/myvenue/main">Profile Venue</a>
        <a class="collapse-item" href="/venue/myvenue/banners/main/index">Banner Venue</a>
        <!-- <a class="collapse-item" href="#">Upgrade Venue</a> -->
      </div>
    </div>
  </li>
  <!-- Nav Item - Utilities Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseArenaVendor" aria-expanded="true" aria-controls="collapseArenaVendor">
      <i class="fas fa-fw fa-futbol"></i>
      <span>Arena</span>
    </a>
    <div id="collapseArenaVendor" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Menu Arena</h6>
        <a class="collapse-item" href="/venue/arena/main">Daftar Arena</a>
      </div>
    </div>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTransactionVenue" aria-expanded="true" aria-controls="collapseTransactionVenue">
    <i class="fa-solid fa-receipt fa-fw"></i>
      <span>Transaksi</span>
    </a>
    <div id="collapseTransactionVenue" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Data Transaksi</h6>
        <a class="collapse-item" href="/venue/transaction">Data Semua Transaksi</a>
        <a class="collapse-item" href="/venue/transaction/downpayment">Data Downpayment</a>
        <a class="collapse-item" href="/venue/transaction/canceled">Pembatalan Transaksi</a>
        <a class="collapse-item" href="/venue/transaction/failed">Data Transaksi Gagal</a>
        <a class="collapse-item" href="/venue/transaction/report_view">Laporan Transaksi</a>
      </div>
    </div>
  </li>
  <!-- Nav Item - Pesanana Collapse Menu -->
  <!-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePesanan" aria-expanded="true" aria-controls="collapsePesanan">
      <i class="fas fa-fw fa-shopping-cart"></i>
      <span>Pesanan</span>
    </a>
    <div id="collapsePesanan" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Menu Pesanan</h6>
        <a class="collapse-item" href="utilities-color.html">Pesanan Saya</a>
        <a class="collapse-item" href="utilities-color.html">Pembatalan</a>
      </div>
    </div>
  </li> -->
  <!-- Nav Item - Keuangan Collapse Menu -->
  <!-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKeuangan" aria-expanded="true" aria-controls="collapseKeuangan">
      <i class="fas fa-fw fa-dollar-sign"></i>
      <span>Keuangan</span>
    </a>
    <div id="collapseKeuangan" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Menu Keuangan</h6>
        <a class="collapse-item" href="utilities-color.html">Saldo Saya</a>
        <a class="collapse-item" href="utilities-color.html">Rekening Bank</a>
      </div>
    </div>
  </li> -->



  <!-- Nav Item - Tables -->
  <!-- <li class="nav-item">
    <a class="nav-link" href="tables.html">
      <i class="fas fa-fw fa-percentage"></i>
      <span>Promosi</span></a>
  </li> -->

  <!-- Nav Item - Charts -->
  <!-- <li class="nav-item">
    <a class="nav-link" href="charts.html">
      <i class="fas fa-fw fa-cash-register"></i>
      <span>POS</span></a>
  </li> -->
  <?php endif; ?>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>