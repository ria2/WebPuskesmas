
            <!DOCTYPE html>
            <html lang="en">
            <head>
            <meta charset="utf-8">
                <meta content="width=device-width, initial-scale=1.0" name="viewport">
                <meta content="Free HTML Templates" name="keywords">
                <meta content="Free HTML Templates" name="description">
                <title><?=$title?></title>
                <!-- Favicon -->
                <link href="<?php echo base_url('asset/assets_user/img/favicon.ico'); ?>" rel="icon">

                <!-- Google Web Fonts -->
                <link rel="preconnect" href="https://fonts.gstatic.com">
                <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"> 

                <!-- Icon Font Stylesheet -->
                <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

                <!-- Libraries Stylesheet -->
                <link href = "<?php echo base_url(); ?>asset/assets_user/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
                <link href = "<?php echo base_url(); ?>asset/assets_user/lib/animate/animate.min.css" rel="stylesheet">
                <link href = "<?php echo base_url(); ?>asset/assets_user/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
                <link href = "<?php echo base_url(); ?>asset/assets_user/lib/twentytwenty/twentytwenty.css" rel="stylesheet" />

                <!-- Customized Bootstrap Stylesheet -->
                <link href = "<?php echo base_url(); ?>asset/assets_user/css/bootstrap.min.css" rel="stylesheet"> 

                <!-- Template Stylesheet -->
                <link href = "<?php echo base_url(); ?>asset/assets_user/css/style.css" rel="stylesheet"> 
                <link rel="icon" href="<?php echo base_url('asset/img/logodefault.png'); ?>" type="image/x-icon">
                <meta name="description" content="Puskesmas Padalarang Kabupaten Bandung Barat">

                <style>
                    .map-responsive {
                        overflow: hidden;
                        padding-bottom: 56.25%;
                        position: relative;
                        height: 0;
                    }
                
                    .map-responsive iframe {
                        left: 0;
                        top: 0;
                        height: 100%;
                        width: 100%;
                        position: absolute;
                    }
                    #carouselExampleIndicators {
                        max-width: 1600px; /* Adjust the max-width as needed */
                        margin: 0 auto; /* Center the carousel */
                    }
                    
                    .carousel-inner {
                        max-height: 500px; /* Adjust the max-height as needed */
                    }
                    
                    .carousel-inner img {
                        max-height: 100%; /* Make the images fill the carousel height */
                        object-fit: cover; /* Maintain aspect ratio and cover the carousel */
                    }
                </style>
            </head>
            <body>
                <!-- Navbar Start -->
                <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm px-5 py-3 py-lg-0">
                <a href="<?= site_url('Padalarang/Padalarang')?>" class="navbar-brand p-0">
                <?php
                foreach ($Padalarang_visi_misi->result() as $row) {?>
                <img src="<?=$row->logo?>" alt="" width="30" height="40" class="d-inline-block align-text-mid">
                <?php }?>
                    Puskesmas Padalarang
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="<?= site_url('Padalarang/Padalarang')?>" class="nav-item nav-link">Beranda</a>
                        <a href="<?=site_url('Padalarang/Padalarang/Pendaftaran')?>" class="nav-item nav-link">Pendaftaran Online</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Profile</a>
                            <div class="dropdown-menu m-0">
                                <a href="<?=site_url('Padalarang/Padalarang/Sejarah')?>" class="dropdown-item">Sejarah</a>
                                <a href="<?=site_url('Padalarang/Padalarang/Visi')?>" class="dropdown-item">Visi & Misi</a>
                                <a href="<?=site_url('Padalarang/Padalarang/Tatanilai')?>" class="dropdown-item">Tata Nilai</a>
                                <a href="<?=site_url('Padalarang/Padalarang/Struktur')?>" class="dropdown-item">Struktur Ogranisasi</a>
                                <a href="<?=site_url('Padalarang/Padalarang/Datapegawai')?>" class="dropdown-item">Data Pegawai</a>
                                <a href="<?=site_url('Padalarang/Padalarang/Lokasi')?>" class="dropdown-item">Lokasi & Kontak</a>
                                <a href="<?=site_url('Padalarang/Padalarang/Maklumat')?>" class="dropdown-item">Maklumat</a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Layanan Publik</a>
                            <div class="dropdown-menu m-0">
                                <a href="<?=site_url('Padalarang/Padalarang/Mekanisme')?>" class="dropdown-item">Mekanisme & Prosedur</a>
                                <a href="<?=site_url('Padalarang/Padalarang/Sarana')?>" class="dropdown-item">Sarana & Prasarana</a>
                                <a href="<?=site_url('Padalarang/Padalarang/Fasilitas')?>" class="dropdown-item">Fasilitas</a>
                                <a href="<?=site_url('Padalarang/Padalarang/Tarif')?>" class="dropdown-item">Produk & Tarif Layanan</a>
                                <a href="<?=site_url('Padalarang/Padalarang/Kompensasi')?>" class="dropdown-item">Kompensasi Pelayanan</a>
                                <a href="<?=site_url('Padalarang/Padalarang/Standar')?>" class="dropdown-item">Standar Pelayanan Minimal</a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Layanan Khusus</a>
                            <div class="dropdown-menu m-0">
                                <a href="<?php echo site_url('Padalarang/Padalarang/VisiPelayanan'); ?>" class="dropdown-item">Visi & Pelayanan</a>
                                <a href="<?php echo site_url('Padalarang/Padalarang/Atribut'); ?>" class="dropdown-item">Atribut</a>
                                <a href="<?php echo site_url('Padalarang/Padalarang/Layanan'); ?>" class="dropdown-item">Layanan Terpadu</a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pengaduan</a>
                            <div class="dropdown-menu m-0">
                                <a href="<?php echo site_url('Padalarang/Padalarang/Pengaduan'); ?>" class="dropdown-item">Pengaduan Pasien</a>
                                <a href="<?php echo site_url('Padalarang/Padalarang/Kepuasan'); ?>" class="dropdown-item">Kepuasan Pasien</a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Berita</a>
                            <div class="dropdown-menu m-0">
                                <a href="<?php echo site_url('Padalarang/Padalarang/Agenda'); ?>" class="dropdown-item">Agenda Kegiatan</a>
                                <a href="<?php echo site_url('Padalarang/Padalarang/Artikel'); ?>" class="dropdown-item">Artikel & Berita</a>
                            </div>
                        </div>
                    </div>
                    <a href="<?=site_url('Padalarang/Auth')?>" class="btn btn-primary py-2 px-4 ms-3">Login</a>
                </div>
                </nav>
                <!-- Navbar End -->


            