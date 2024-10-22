<body>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand" href="../adm?id">
          <img src="../assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
        <div class="ml-auto">
          <!-- Sidenav toggler -->
          <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <!-- <li class="nav-item">
              <a class="nav-link" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="ni ni-ungroup text-orange"></i>
                <span class="nav-link-text">Examples</span>
              </a>
              <div class="collapse" id="navbar-examples">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="../pages/examples/pricing.html" class="nav-link">Pricing</a>
                  </li>
                  <li class="nav-item">
                    <a href="../pages/examples/login.html" class="nav-link">Login</a>
                  </li>
                  <li class="nav-item">
                    <a href="../pages/examples/register.html" class="nav-link">Register</a>
                  </li>
                  <li class="nav-item">
                    <a href="../pages/examples/lock.html" class="nav-link">Lock</a>
                  </li>
                  <li class="nav-item">
                    <a href="../pages/examples/timeline.html" class="nav-link">Timeline</a>
                  </li>
                  <li class="nav-item">
                    <a href="../pages/examples/profile.html" class="nav-link">Profile</a>
                  </li>
                </ul>
              </div>
            </li> -->
            <!-- <li class="nav-item">
              <a class="nav-link" href="#navbar-components" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-components">
                <i class="ni ni-ui-04 text-info"></i>
                <span class="nav-link-text">Components</span>
              </a>
              <div class="collapse" id="navbar-components">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="../pages/components/buttons.html" class="nav-link">Buttons</a>
                  </li>
                  <li class="nav-item">
                    <a href="../pages/components/cards.html" class="nav-link">Cards</a>
                  </li>
                  <li class="nav-item">
                    <a href="../pages/components/grid.html" class="nav-link">Grid</a>
                  </li>
                  <li class="nav-item">
                    <a href="../pages/components/notifications.html" class="nav-link">Notifications</a>
                  </li>
                  <li class="nav-item">
                    <a href="../pages/components/icons.html" class="nav-link">Icons</a>
                  </li>
                  <li class="nav-item">
                    <a href="../pages/components/typography.html" class="nav-link">Typography</a>
                  </li>
                  <li class="nav-item">
                    <a href="#navbar-multilevel" class="nav-link" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-multilevel">Multi level</a>
                    <div class="collapse show" id="navbar-multilevel">
                      <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                          <a href="#!" class="nav-link ">Third level menu</a>
                        </li>
                        <li class="nav-item">
                          <a href="#!" class="nav-link ">Just another link</a>
                        </li>
                        <li class="nav-item">
                          <a href="#!" class="nav-link ">One last link</a>
                        </li>
                      </ul>
                    </div>
                  </li>
                </ul>
              </div>
            </li> -->
            <!-- <li class="nav-item">
              <a class="nav-link" href="#navbar-forms" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-forms">
                <i class="ni ni-single-copy-04 text-pink"></i>
                <span class="nav-link-text">Forms</span>
              </a>
              <div class="collapse" id="navbar-forms">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="../pages/forms/elements.html" class="nav-link">Elements</a>
                  </li>
                  <li class="nav-item">
                    <a href="../pages/forms/components.html" class="nav-link">Components</a>
                  </li>
                  <li class="nav-item">
                    <a href="../pages/forms/validation.html" class="nav-link">Validation</a>
                  </li>
                </ul>
              </div>
            </li> -->
            <li class="nav-item">
              <a class="nav-link <?php echo ($parentpage == "dashboard" ? "active" : "") ?>" href="../adm?id">
                <i class="ni ni-shop text-primary"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($parentpage == "akun" ? "active" : "") ?>" href="#navbar-dataakun" data-toggle="collapse" role="button" aria-expanded="<?php echo ($parentpage == "akun" ? "true" : "false") ?>" aria-controls="navbar-dataakun">
                <i class="ni ni-money-coins text-danger"></i>
                <span class="nav-link-text">Data Akun</span>
              </a>
              <div class="collapse <?php echo ($parentpage == "akun" ? "show" : "") ?>" id="navbar-dataakun">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="data_admin" class="nav-link  <?php echo ($childpage == "data_admin" ? "active" : "") ?>">Admin</a>
                  </li>
                  <li class="nav-item">
                    <a href="data_penyeleksi" class="nav-link <?php echo ($childpage == "data_penyeleksi" ? "active" : "") ?>">Penyeleksi</a>
                  </li>
                  <li class="nav-item">
                    <a href="mahasiswa" class="nav-link <?php echo ($childpage == "mahasiswa" ? "active" : "") ?>">Mahasiswa</a>
                  </li>

                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($parentpage == "master" ? "active" : "") ?>" href="#navbar-masterdata" data-toggle="collapse" role="button" aria-expanded="<?php echo ($parentpage == "master" ? "true" : "false") ?>" aria-controls="navbar-masterdata">
                <i class="ni ni-money-coins text-primary"></i>
                <span class="nav-link-text">Data Master</span>
              </a>
              <div class="collapse <?php echo ($parentpage == "master" ? "show" : "") ?>" id="navbar-masterdata">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="data_fakultas" class="nav-link <?php echo ($childpage == "data_fakultas" ? "active" : "") ?>">Data Fakultas</a>
                  </li>
                  <li class="nav-item">
                    <a href="data_prodi" class="nav-link <?php echo ($childpage == "data_prodi" ? "active" : "") ?>">Data Program Studi</a>
                  </li>
                  <li class="nav-item">
                    <a href="data_role" class="nav-link <?php echo ($childpage == "data_role" ? "active" : "") ?>">Data Hak Akses</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($parentpage == "beasiswa" ? "active" : "") ?>" href="#navbar-masterdata2" data-toggle="collapse" role="button" aria-expanded="<?php echo ($parentpage == "beasiswa" ? "true" : "false") ?>" aria-controls="navbar-masterdata2">
                <i class="ni ni-hat-3 text-warning"></i>
                <span class="nav-link-text">Beasiswa</span>
              </a>
              <div class="collapse <?php echo ($parentpage == "beasiswa" ? "show" : "") ?>" id="navbar-masterdata2">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="list_beasiswa" class="nav-link <?php echo ($childpage == "list_beasiswa" ? "active" : "") ?>">List Beasiswa</a>
                  </li>
                  <li class="nav-item">
                    <a href="list_persyaratan_beasiswa" class="nav-link <?php echo ($childpage == "list_persyaratan_beasiswa" ? "active" : "") ?>">List Persyaratan Beasiswa</a>
                  </li>
                  <li class="nav-item">
                    <a href="budget" class="nav-link <?php echo ($childpage == "budget" ? "active" : "") ?>">Budget Beasiswa</a>
                  </li>
                </ul>
              </div>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="../pages/widgets.html">
                <i class="ni ni-archive-2 text-green"></i>
                <span class="nav-link-text">Widgets</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../pages/charts.html">
                <i class="ni ni-chart-pie-35 text-info"></i>
                <span class="nav-link-text">Charts</span>
              </a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link <?php echo ($parentpage == "pengajuan" ? "active" : "") ?>" href="#navbar-masterdata3" data-toggle="collapse" role="button" aria-expanded="<?php echo ($parentpage == "pengajuan" ? "true" : "false") ?>" aria-controls="navbar-masterdata3">
                <i class="ni ni-archive-2 text-info"></i>
                <span class="nav-link-text">Pengajuan</span>
              </a>
              <div class="collapse <?php echo ($parentpage == "pengajuan" ? "show" : "") ?>" id="navbar-masterdata3">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="#navbar-multilevel1" class="nav-link" data-toggle="collapse" role="button" aria-expanded="<?php echo ($subchildpage == "validasi" ? "true" : "false") ?>" aria-controls="navbar-multilevel1">Validasi Penerima</a>
                    <div class="collapse <?php echo ($subchildpage == "validasi" ? "show" : "") ?>" id="navbar-multilevel1" style="">
                      <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                          <a href="validasi_pinjaman" class="nav-link <?php echo ($childpage == "validasi_pinjaman" ? "active" : "") ?>">Pinjaman Registrasi</a>
                        </li>
                        <li class="nav-item">
                          <a href="validasi_kebutuhan" class="nav-link <?php echo ($childpage == "validasi_kebutuhan" ? "active" : "") ?>">Beasiswa Kebutuhan</a>
                        </li>
                      </ul>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a href="riwayat_pengajuan_exp?tahun=&semester=" class="nav-link <?php echo ($childpage == "export_data_penerima" ? "active" : "") ?>">Export Data Penerima</a>
                  </li>
                  <li class="nav-item">
                    <a href="riwayat_pengajuan" class="nav-link <?php echo ($childpage == "riwayat_pengajuan" ? "active" : "") ?>">Riwayat Pengajuan</a>
                  </li>
                  <li class="nav-item">
                    <a href="riwayat_pembayaran" class="nav-link <?php echo ($childpage == "riwayat_pembayaran" ? "active" : "") ?>">Riwayat Pembayaran</a>
                  </li>

                </ul>
              </div>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link <?php echo ($page == "riwayat_pengajuan" ? "active" : "") ?>" href="riwayat_pengajuan">
                <i class="ni ni-archive-2 text-info"></i>
                <span class="nav-link-text">Riwayat Pengajuan</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($page == "riwayat_pembayaran" ? "active" : "") ?>" href="riwayat_pembayaran">
                <i class="ni ni-archive-2 text-success"></i>
                <span class="nav-link-text">Riwayat Pembayaran</span>
              </a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link <?php echo ($page == "kalender" ? "active" : "") ?>" href="kalender">
                <i class="ni ni-calendar-grid-58 text-red"></i>
                <span class="nav-link-text">Kalender</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($page == "userlog" ? "active" : "") ?>" href="userlog">
                <i class="fas fa-history text-primary"></i>
                <span class="nav-link-text">Riwayat Login User</span>
              </a>
            </li>
          </ul>
          <!-- Divider -->
          <hr class="my-3">
          <!-- Heading -->
          <h6 class="navbar-heading p-0 text-muted">Eksternal Link</h6>
          <!-- Navigation -->
          <ul class="navbar-nav mb-md-4">
            <li class="nav-item">
              <a class="nav-link" href="https://www.ukdw.ac.id/" target="_blank">
                <i class="fas fa-globe-asia"></i>
                <span class="nav-link-text">Website UKDW</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://eclass.ukdw.ac.id/id/" target="_blank">
                <i class="ni ni-laptop"></i>
                <span class="nav-link-text">E-class</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="http://ssat.ukdw.ac.id/" target="_blank">
                <i class="fab fa-envira"></i>
                <span class="nav-link-text">SSAT</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="http://eq.ukdw.ac.id/" target="_blank">
                <i class="fas fa-scroll"></i>
                <span class="nav-link-text">eqUKDW<strong>+</strong></span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>