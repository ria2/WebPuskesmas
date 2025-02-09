<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?=$title?></title>
    <!-- Custom fonts for this template -->
    <link href="<?=base_url('asset/')?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?=base_url('asset/')?>css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-success">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" method="post" action="<?=site_url('Auth/prosesBuatAkun')?>" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="Nama"
                                        name="nama" placeholder="Masukan Nama" required>
                                    <?=form_error('nama', '<small class="text-danger pl-3">', '</small>')?>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="Email"
                                        name="email" placeholder="Masukan Email" required>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-user" id="No_HP"
                                        name="no_hp" placeholder="Masukan No HP" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="Username"
                                        name="username" placeholder="Masukan Username" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            name="password1" id="Password1" placeholder="Password" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                        name="password2" id="Password2" placeholder="Konfirmasi Password" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="gambar" class="col-sm-2 control-label">Foto</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" id="foto" name="gambar">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-user btn-block">
                                    Buat Akun
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="<?=base_url('asset/')?>vendor/jquery/jquery.min.js"></script>
    <script src="<?=base_url('asset/')?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript -->
    <script src="<?=base_url('asset/')?>vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages -->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>
