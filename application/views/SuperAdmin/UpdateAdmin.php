<body class="bg-gradient-success">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <?php echo $this->session->userdata("error"); ?>
                <div class="row">
                    
                    <div class="col-lg-12">
                        <div class="p-5">
                            
                            <form class="user" method="post" action="<?=site_url('Auth/prosesUpdateAdmin/'.$admin->id_user)?>" enctype="multipart/form-data" onsubmit="return validatePassword()">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="Nama"
                                        name="nama" placeholder="Masukan Nama" pattern="[A-Za-z\s]+" required value="<?=$admin->nama?>">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="Email"
                                        name="email" placeholder="Masukan Email" required value="<?=$admin->email?>">
                                </div>
                                <?php echo $this->session->userdata("email_message"); ?>
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-user" id="No_HP"
                                        name="no_hp" placeholder="Masukan No HP" maxlength="12" required value="<?=$admin->no_hp?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="Username"
                                        name="username" placeholder="Masukan Username" required value="<?=$admin->username?>">
                                </div>
                                <?php echo $this->session->userdata("username_message"); ?>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            name="password1" id="Password1" placeholder="Password"  >
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                        name="password2" id="Password2" placeholder="Konfirmasi Password"  >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="gambar" class="col-sm-2 control-label">Foto</label>
                                    <div class="col-sm-10">
                                        <img src="<?=$admin->foto?>" weight="60px" height="60px">
                                        <input type="file"  id="foto" name="gambar" value="<?=$admin->foto?>">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-user btn-block">
                                    Update Akun
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Include SweetAlert2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function validatePassword() {
            var password1 = document.getElementById("Password1").value;
            var password2 = document.getElementById("Password2").value;

            if (password1.trim() !== "" || password2.trim() !== "") {
                if (password1.length < 6 || password2.length < 6) {
                    Swal.fire({
                    title: 'Password harus memiliki setidaknya 6 karakter !',
                    icon: 'info',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#005700', 
                    });
                                
                    return false;
                }
                if (!/\d/.test(password1) || !/\d/.test(password2)) {
                    Swal.fire({
                    title: 'Password harus mengandung setidaknya satu angka. !',
                    icon: 'info',
                    iconColor: 'danger',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#005700', 
                    });
                    return false;
                }

                if (password1 !== password2) {
                    Swal.fire({
                    title: 'Kedua Password harus cocok !',
                    icon: 'info',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#005700', 
                    });
                    return false;
                }
                if (!/[a-zA-Z]/.test(password1) || !/[a-zA-Z]/.test(password2)) {
                    Swal.fire({
                        title: 'Password harus mengandung setidaknya satu huruf!',
                        icon: 'info',
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#005700', 
                    });
                    return false;
                }
            }

            return true;
        }
    </script>