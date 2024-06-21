
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
                          <h1 class="display-3 text-white animated zoomIn">Pengaduan Pasien</h1>
                      </div>
                  </div>
              </div>
              <!-- Hero End -->
          
              
              <!-- Form Pengaduan -->
              <div class="appointment-form h-100 d-flex flex-column justify-content-center text-center p-5 wow zoomIn" data-wow-delay="0.6s">
              <?php echo $this->session->userdata("success"); ?>
              <form  method="post" action="<?=site_url('Padalarang/Padalarang/IsiPesan')?>">
                  <div class="row g-3">
                      <div class="col-12">
                          <input type="text" class="form-control border-0 bg-light px-4" name ="nama" placeholder="Masukan Nama" style="height: 55px;" required>
                      </div>
                      <div class="col-12">
                          <input type="email" class="form-control border-0 bg-light px-4" name ="email" placeholder="Masukan Alamat Email" style="height: 55px;" required>
                      </div>
                      <div class="col-12">
                          <input type="text" class="form-control border-0 bg-light px-4" name ="subject" placeholder="Subjek" style="height: 55px;" required>
                      </div>
                      <div class="col-12">
                          <textarea class="form-control border-0 bg-light px-4 py-3" rows="5" name ="pesan" placeholder="Masukan Pesan" required></textarea>
                      </div>
                      <?php echo $captcha['image']; ?>
                      <div class="col-12">
                          <input type="text" class="form-control border-0 bg-light px-4" name="captcha" placeholder="Masukan Captcha" style="height: 55px;" required>
                      </div>
                      <div class="col-12" style="display: none;">
                        <input type="text" class="form-control border-0 bg-light px-4" name="puskesmas" style="height: 55px;" value="Padalarang" readonly>
                    </div>
                      <div class="col-12">
                          <button class="btn btn-dark w-100 py-3" type="submit">Kirim</button>
                      </div>
                  </div>
              </form>
              </div>
              <br>
              <br>
              <br>
              <br>
              <br>
            
          
              <!-- Form Pengaduan end -->
              <!-- Include SweetAlert2 CSS -->
              <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                <!-- Include SweetAlert2 JavaScript -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>Swal.fire ({title:"Bagian ini dikerjakan oleh kelompok lain!", confirmButtonColor: '#005700'}); </script>
            