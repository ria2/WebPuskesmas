
            <!-- Spinner Start -->
            <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                  <div class="spinner-grow text-primary m-1" role="status">
                      <span class="sr-only">Loading...</span>
                  </div>
                  <div class="spinner-grow text-dark m-1" role="status">
                      <span class="sr-only">Loading...</span>
                  </div>
                  <div class="spinner-grow text-secondary m-1" role="status">
                      <span class="sr-only">Loading...</span>
                  </div>
              </div>
              <!-- Spinner End -->
          
              <!-- Hero Start -->
              <div class="container-fluid bg-primary py-5 hero-header mb-5">
                  <div class="row py-3">
                      <div class="col-12 text-center">
                          <h1 class="display-3 text-white animated zoomIn">Pendaftaran Pasien</h1>
                      </div>
                  </div>
              </div>
              <!-- Hero End -->
          
              
              <!-- Form Pengaduan -->
              <div class="appointment-form h-100 d-flex flex-column justify-content-center text-center p-5 wow zoomIn" data-wow-delay="0.6s">
              <?php echo $this->session->userdata("success"); ?>
              <div class="d-flex justify-content-center align-items-center vh-1">
                  <div class="card" style="width: 18rem;">
                      <img src="<?php echo $Padalarang_pendaftaran->qr_code; ?>" class="card-img-top" alt="QR Code">
                      <div class="card-body">
                          <h5 class="card-title"><?php echo $Padalarang_pendaftaran->nama; ?></h5>
                          <p class="card-text">Tanggal Lahir: <?php echo $Padalarang_pendaftaran->tanggal_lahir; ?></p>
                          <p class="card-text">No Antrian: <?php echo $Padalarang_pendaftaran->nomor_pendaftaran; ?></p>
                          <a href="<?php echo $Padalarang_pendaftaran->qr_code; ?>" class="btn btn-primary" download="gambar.png">Cetak Gambar</a>
                      </div>
                  </div>
              </div>
              <br>
              <hr>
              <a href="<?=site_url('Padalarang/Padalarang')?>" class="btn btn-primary">Kembali Ke Beranda</a>
          </div>
              <br>
              <br>
              <br>
              <br>
              <br>
            
          
              <!-- Form Pengaduan end -->
            