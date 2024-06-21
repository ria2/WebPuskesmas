<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold ">Data Website</h6>
        </div>
        <div class="card-body">
            <form class="user" method="post" action="<?=site_url('SuperAdmin/SuperAdmin/Generate')?>" enctype="multipart/form-data" onsubmit="return validatePassword()">
            <div class="mb-3">
                    <input type="text" class="form-control" name="kode_puskesmas" placeholder="Kode Puskesmas" required>
                </div>
                <?php echo $this->session->userdata("kode_message"); ?>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon3">Puskesmas</span>
                        <input type="text" name="lokasi" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4" pattern="[A-Za-z]+" maxlength="20" placeholder="Masukan Puskesmas" required>
                        
                    </div>
                    <div class="form-text" id="basic-addon4"> Contoh : Lembang</div>
                    <?php echo $this->session->userdata("lokasi_message"); ?>
                </div>
                <div class="input-group mb-3">
                    <select class="form-control" name="kecamatan" required>
                        <option value="" disabled selected>Select Kecamatan</option>
                        <option value="Batujajar">Batujajar</option>
                        <option value="Cikalongwetan">Cikalongwetan</option>
                        <option value="Cihampelas">Cihampelas</option>
                        <option value="Cililin">Cililin</option>
                        <option value="Cipatat">Cipatat</option>
                        <option value="Cipeundeuy">Cipeundeuy</option>
                        <option value="Cipongkor">Cipongkor</option>
                        <option value="Cisarua">Cisarua</option>
                        <option value="Gununghalu">Gununghalu</option>
                        <option value="Lembang">Lembang</option>
                        <option value="Ngamprah">Ngamprah</option>
                        <option value="Padalarang">Padalarang</option>
                        <option value="Parongpong">Parongpong</option>
                        <option value="Rongga">Rongga</option>
                        <option value="Sindangkerta">Sindangkerta</option>
                        <option value="Saguling">Saguling</option>
                    </select>
                </div>

                <div class="input-group">
                    <textarea class="form-control" aria-label="With textarea"  name="alamat" placeholder="Alamat" required></textarea>
                </div>
                <br>
                <div class="input-group">
                    <textarea class="form-control" aria-label="With textarea"  name="alamat_map" placeholder="Alamat Google Maps" required></textarea>
                </div>
                <div class="form-text" id="basic-addon4"> Sematkan Link Google Maps</div>
                <br>
                <div class="input-group mb-3">
                    <span class="input-group-text fas fa-envelope" ></span>
                    <input type="email" class="form-control" name="email" placeholder="Alamat Email" required>
                    
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text fas fa-user"></span>
                    <input type="number" class="form-control" name="no_hp" maxlength="12" placeholder="No Telpon" required>
                    
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text fas fa-map"></span>
                    
                    <input type="number" class="form-control" name="kode_pos" placeholder="Kode Post" required>
                    
                </div>
                <div class="input-group">
                    <textarea class="form-control" aria-label="With textarea" name="deskripsi"  placeholder="Deskripsi" required></textarea>
                </div>
                <br>
                <div class="mb-3">
                    <input type="text" class="form-control" name="meta_keyword" placeholder="Meta Keyword">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="meta_deskripsi" placeholder="Deskripsi Meta Keyword">
                </div>
                
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold ">Admin Puskesmas</h6>
                </div>
                <hr>
                <div class="mb-3">
                    <input type="text" class="form-control" name="username" placeholder="Username"  maxlength="10" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password" id="password" required>
                </div>
                
                <hr>
                <button type="submit" class="btn btn-success btn-user btn-block">Buat Website</button>
            </form>
        </div>
    </div>

</div>
 <!-- Include SweetAlert2 JavaScript -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function validatePassword() {
            var password = document.getElementById("password").value;

            if (password.length < 6) {
                Swal.fire({
                title: 'Password harus memiliki setidaknya 6 karakter!',
                icon: 'info',
                confirmButtonText: 'Ok',
                confirmButtonColor: '#005700', 
                });
                            
                return false;
            }
            if (!/\d/.test(password)) {
                Swal.fire({
                title: 'Password harus mengandung setidaknya satu angka.!',
                icon: 'info',
                confirmButtonText: 'Ok',
                confirmButtonColor: '#005700', 
                });
                return false;
            }
            if (!/[a-zA-Z]/.test(password)) {
                Swal.fire({
                    title: 'Password harus mengandung setidaknya satu huruf!',
                    icon: 'info',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#005700', 
                });
                return false;
            }

            return true;
        }
    </script>