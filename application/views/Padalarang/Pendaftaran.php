
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
          
              <!-- Header pendaftaran online --> 
              <div class="container-fluid bg-primary py-5 hero-header mb-5">
                  <div class="row py-3">
                      <div class="col-12 text-center">
                          <h1 class="display-3 text-white animated zoomIn">Pendaftaran Pasien</h1>
                      </div>
                      <h5 class="display-6 text-white animated zoomIn text-center">Terdaftar : <?=$antrian?></h5> 
                        <h5 class="display-6 text-white animated zoomIn text-center">Sisa pendaftaran : <?=$sisa?></h5> 
                  </div>
              </div>
              <!-- Header End -->
          
              
              <!-- Form Pendaftaran -->
              <div class="appointment-form h-100 d-flex flex-column justify-content-center text-center p-5 wow zoomIn" data-wow-delay="0.6s">
              <?php echo $this->session->userdata("success"); ?>
              <form  method="post" action="<?=site_url('Padalarang/Padalarang/Daftar')?>">
                  <div class="row g-3">
                    <div class="col-12">
                    <div class="col-12">
                            <input type="number" class="form-control border-0 bg-light px-4" name="nik" placeholder="Masukan NIK" style="height: 55px;" required 
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" 
                                maxlength="16" 
                                min="1000000000000000" 
                                max="9999999999999999"
                                onblur="validateNIK(this)">
                            <div id="nikError" style="color: white;"></div>
                        </div>
                        <script>
                            function validateNIK(input) {
                                var nik = input.value;
                                var errorElement = document.getElementById("nikError");

                                if (nik.length !== 16 || isNaN(nik) || nik < 1000000000000000 || nik > 9999999999999999) {
                                    errorElement.textContent = "NIK tidak valid. Harap masukkan NIK yang benar!";
                                    input.value = ""; // Clear the input field
                                } else {
                                    errorElement.textContent = ""; // Clear the error message if NIK is valid
                                }
                            }
                        </script>
                      </div>
                      <div class="col-12">
                          <input type="text" class="form-control border-0 bg-light px-4" name ="nama" placeholder="Masukan Nama" style="height: 55px;" required>
                      </div>
                      <div class="col-12">
                          <input type="text" class="form-control border-0 bg-light px-4" name ="tempat_lahir" placeholder="Masukan Tempat Lahir" style="height: 55px;" required>
                      </div>
                      <div class="col-12">
                      <span class="input-group-text fas fa-calendar" >Tanggal Lahir</span>
                          <input type="date" class="form-control border-0 bg-light px-4" name ="tanggal_lahir" placeholder="Masukan Tanggal" style="height: 55px;" required>
                      </div>
                      <div class="form-group">
                      <form>
                        <select name="jk" class="form-control" style="height: 55px;" required>
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        </form>
                      </div>
                      <div class="col-12">
                          <textarea class="form-control border-0 bg-light px-4 py-3" rows="5" name ="alamat" placeholder="Masukan Alamat" required></textarea>
                      </div>
                      <div class="col-12">
                          <textarea class="form-control border-0 bg-light px-4 py-3" rows="5" name ="pekerjaan" placeholder="Masukan Pekerjaan" style="height: 55px;" required></textarea>
                      </div>
                      <div class="form-group">
                      <select class="form-control " name="layanan" style="height: 55px;" required>
                              <?php
                               foreach ($Padalarang_layananpublik->result() as $row) { //untuk memilih layanan poli
                                  echo '<option value="'.$row->produk.'"'.$selected.'>'.$row->produk.'</option>';
                              }
                              ?>
                          </select>
                  </div>
                      <div class="col-12">
                          <button class="btn btn-dark w-100 py-3" type="submit">Daftar</button>
                      </div>
                  </div>
              </form>
              </div>
              <br>
              <br>
              <br>
              <br>
              <br>
            
          
              <!-- Form Pendaftaran end -->

            