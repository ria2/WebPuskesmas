
            <?php
            $current_page = basename($_SERVER['PHP_SELF']); // Mengambil nama file halaman saat ini
            ?>
            <!DOCTYPE html>
            <html lang="en">

            <head>

                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <meta name="description" content="">
                <meta name="author" content="">

                <title><?=$title?></title>

                <!-- Custom fonts for this template-->
                <link href="<?php echo base_url('asset/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
                <link
                    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
                    rel="stylesheet">
                <!-- Custom styles for this template-->
                <link href="<?php echo base_url('asset/') ?>css/sb-admin-2.min.css" rel="stylesheet">
                <!-- tambahan -->
                <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
                <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
                <link rel="icon" href="<?php echo base_url('asset/img/logodefault.png'); ?>" type="image/x-icon">
                <style>
                    .label {
                        display: inline-block;
                        width: 150px; 
                        font-weight: bold;
                    }
                    .bg-gradient-green-sea {
                    background: #034419;
                
                    }   
                    .btn-success {
                        background-color: #005700; 
                        border-color: #005700; 
                    }
                    .btn-danger {
                        background-color: #7F0000; 
                        border-color: #7F0000; 
                    }
                </style>
            </head>

            <body id="page-top">

                <!-- Page Wrapper -->
                <div id="wrapper">

                    <!-- Sidebar -->
                    <ul class="navbar-nav bg-gradient-green-sea sidebar sidebar-dark accordion" id="accordionSidebar">

                        <!-- Sidebar - Brand -->
                        <div class="sidebar-brand d-flex align-items-center justify-content-center mt-3">
                                <img src="<?php echo base_url('asset/img/logodefault.png'); ?>" width="50" height="60"></img>
                            </div> 
                        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?=site_url('Padalarang/Padalarang_admin')?>">
                                <div class="sidebar-brand-text mx-2">Puskesmas Admin Padalarang</div>
                        </a>

                        <!-- Divider -->
                        <hr class="sidebar-divider my-0">

                        <!-- Nav Item - Dashboard -->
                        <li class="nav-item <?php echo (site_url('Padalarang/Padalarang_admin') === current_url()) ? 'active' : ''; ?>">
                            <a class="nav-link" href="<?=site_url('Padalarang/Padalarang_admin')?>">
                                <i class="fas fa-fw fa-tachometer-alt"></i>
                                <span>Dashboard</span></a>
                        </li>

                        <!-- Divider -->
                        <hr class="sidebar-divider">

                        <!-- Heading -->
                        <div class="sidebar-heading">
                            User Management
                        </div>
                        <!-- Nav Item - Charts -->
                        <li class="nav-item <?php echo (site_url('Padalarang/Padalarang_admin/Pendaftaran') === current_url()) ? 'active' : ''; ?>">
                            <a class="nav-link" href="<?=site_url('Padalarang/Padalarang_admin/Pendaftaran')?>">
                                <i class="fas fa-fw fa-folder"></i>
                                <span>Data Pendaftaran</span></a>
                        </li>
                        <li class="nav-item <?php echo (site_url('Padalarang/Padalarang_admin/DataPegawai') === current_url()) ? 'active' : ''; ?>">
                            <a class="nav-link" href="<?=site_url('Padalarang/Padalarang_admin/DataPegawai')?>">
                                <i class="fas fa-database"></i>
                                <span>Data Pegawai</span></a>
                        </li>
                        <li class="nav-item <?php echo (site_url('Padalarang/Padalarang_admin/Organisasi') === current_url()) ? 'active' : ''; ?>">
                            <a class="nav-link" href="<?=site_url('Padalarang/Padalarang_admin/Organisasi')?>">
                                <i class="fas  fa-sitemap"></i>
                                <span>Organisasi</span></a>
                        </li>
                        <li class="nav-item <?php echo (site_url('Padalarang/Padalarang_admin/Feed') === current_url()) ? 'active' : ''; ?>">
                            <a class="nav-link" href="<?=site_url('Padalarang/Padalarang_admin/Feed')?>">
                                <i class="fas fa-fw fa-comments"></i>
                                <span>Pengaduan</span></a>
                        </li>

                        

                        <!-- Divider -->
                        <hr class="sidebar-divider">

                        <!-- Heading -->
                        <div class="sidebar-heading">
                            Setting
                        </div>
                        <!-- Nav Item - Utilities Collapse Menu -->
                        <li class="nav-item <?php echo (site_url('Padalarang/Padalarang_admin/Corousel') === current_url() || 
                        site_url('Padalarang/Padalarang_admin/VisiMisi') === current_url()|| site_url('Padalarang/Padalarang_admin/Sejarah') === current_url()|| 
                        site_url('Padalarang/Padalarang_admin/Sejarah') === current_url()|| 
                        site_url('Padalarang/Padalarang_admin/SosialMedia') === current_url()|| 
                        site_url('Padalarang/Padalarang_admin/Berita') === current_url()|| site_url('Padalarang/Padalarang_admin/Galery') === current_url()) ? 'active' : ''; ?>">
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                                aria-expanded="true" aria-controls="collapseUtilities">
                                <i class="fas fa-fw fa-wrench"></i>
                                <span>Konten</span>
                            </a>
                            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                                data-parent="#accordionSidebar">
                                <div class="bg-white py-2 collapse-inner rounded">
                                    <h6 class="collapse-header">Isi Konten:</h6>
                                    <a class="collapse-item" href="<?=site_url('Padalarang/Padalarang_admin/Corousel')?>">Slide Show</a>
                                    <a class="collapse-item" href="<?=site_url('Padalarang/Padalarang_admin/VisiMisi')?>">Visi & Misi</a>
                                    <a class="collapse-item" href="<?=site_url('Padalarang/Padalarang_admin/Sejarah')?>">Sejarah & Maklumat</a>
                                    <a class="collapse-item" href="<?=site_url('Padalarang/Padalarang_admin/SosialMedia')?>">Sosial Media</a>
                                    <a class="collapse-item" href="<?=site_url('Padalarang/Padalarang_admin/Berita')?>">Berita</a>
                                    <a class="collapse-item" href="<?=site_url('Padalarang/Padalarang_admin/Galery')?>">Galeri</a>
                                </div>
                            </div>
                        </li>

                        <!-- Nav Item - Charts -->
                        <!-- Nav Item - Utilities Collapse Menu -->
                        <li class="nav-item <?php echo (site_url('Padalarang/Padalarang_admin/LayananPublik') === current_url() || site_url('Padalarang/Padalarang_admin/LayananKhusus') === current_url()) ? 'active' : ''; ?>">
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities1"
                                aria-expanded="true" aria-controls="collapseUtilities">
                                <i class="fas fa-fw fa-tag"></i>
                                <span>Layanan</span>
                            </a>
                            <div id="collapseUtilities1" class="collapse" aria-labelledby="headingUtilities"
                                data-parent="#accordionSidebar">
                                <div class="bg-white py-2 collapse-inner rounded">
                                    <h6 class="collapse-header">Isi Layanan:</h6>
                                    <a class="collapse-item" href="<?=site_url('Padalarang/Padalarang_admin/LayananPublik')?>">Layanan Publik</a>
                                    <a class="collapse-item" href="<?=site_url('Padalarang/Padalarang_admin/LayananKhusus')?>">Layanan Khusus</a>
                                    
                                </div>
                            </div>
                        </li>

                        

                        <!-- Divider -->
                        <hr class="sidebar-divider d-none d-md-block">

                        <!-- Sidebar Toggler (Sidebar) -->
                        <div class="text-center d-none d-md-inline">
                            <button class="rounded-circle border-0" id="sidebarToggle"></button>
                        </div>



                    </ul>
                    <!-- End of Sidebar -->

                    <!-- Content Wrapper -->
                    <div id="content-wrapper" class="d-flex flex-column">

                        <!-- Main Content -->
                        <div id="content">

                            <!-- Topbar -->
                            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow ">

                                <!-- Sidebar Toggle (Topbar) -->
                                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                                    <i class="fa fa-bars"></i>
                                </button>

                                <!-- Topbar Search -->
                                

                                <!-- Topbar Navbar -->
                                <ul class="navbar-nav ml-auto">

                                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                                    <li class="nav-item dropdown no-arrow d-sm-none">
                                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-search fa-fw"></i>
                                        </a>
                                        <!-- Dropdown - Messages -->
                                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                            aria-labelledby="searchDropdown">
                                            <form class="form-inline mr-auto w-100 navbar-search">
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-light border-0 small"
                                                        placeholder="Search for..." aria-label="Search"
                                                        aria-describedby="basic-addon2">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-success" type="button">
                                                            <i class="fas fa-search fa-sm"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </li>




                                    <div class="topbar-divider d-none d-sm-block"></div>

                                    <!-- Nav Item - User Information -->
                                    <li class="nav-item dropdown no-arrow">
                                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo ucfirst($this->session->userdata('username')); ?></span>
                                            <i class="fas fa-user-circle fa-2x"></i>
                                        </a>
                                        <!-- Dropdown - User Information -->
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                            aria-labelledby="userDropdown">
                                            
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                                Logout
                                            </a>
                                        </div>
                                    </li>

                                </ul>

                            </nav>
                            <!-- End of Topbar -->





            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                    <i class="fas fa-angle-up"></i>
                </a>

                <!-- Logout Modal-->
                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Anda yakin melakukan Logout?</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <a class="btn btn-success" href="<?=site_url('Padalarang/Auth/logout')?>">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>


            