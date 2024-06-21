<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold ">Update Admin Puskesmas <?=$webpuskesmas->lokasi?></h6>
        </div>
        <div class="card-body">
            <form class="user" method="post" action="<?=site_url('SuperAdmin/Admin/prosesUpdateAdmin/'.$admin->id_login.'/'.$webpuskesmas->kode_puskesmas)?>" enctype="multipart/form-data" onsubmit="return validatePassword()">
                <!-- Bagian username -->
                <div class="mb-3">
                    <input type="text" class="form-control" name="username" placeholder="Username" maxlength="10" required value="<?php echo $admin->username; ?>">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="email" placeholder="Email" maxlength="50" required value="<?php echo $admin->email; ?>">
                </div>
                <!-- Bagian password -->
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                </div>
                    <?php if(isset($_GET['username_error'])) { ?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Error:</strong> <?php echo $_GET['username_error']; ?>
                        </div>
                    <?php } ?>
        
                    <?php if(isset($_GET['email_error'])) { ?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Error:</strong> <?php echo $_GET['email_error']; ?>
                        </div>
                    <?php } ?>
  
                <hr>
                <button type="submit" class="btn btn-success btn-user btn-block">Update Admin</button>
            </form>
        </div>
    </div>
</div>
</div>

    <!-- Include SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function validatePassword() {
        var password = document.getElementById("password").value;

        // Periksa apakah bidang kata sandi tidak kosong sebelum melakukan pemeriksaan
        if (password.trim() !== "") {
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
        }

        return true;
    }
</script>
