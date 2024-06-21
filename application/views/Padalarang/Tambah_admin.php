
            <div class="container-fluid">
    
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold ">Tambah Admin</h6>
                </div>
                <div class="card-body">
                    <form class="user" method="post" action="<?=site_url('Padalarang/Auth/prosesTambahAdmin')?>" enctype="multipart/form-data">
                   
                        <div class="mb-3">
                            <input type="text" class="form-control" name="username" placeholder="Username" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        
                        <?php if(isset($_GET['username_error'])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $_GET['username_error']; ?>
                            </div>
                        <?php } ?>
        
                        <?php if(isset($_GET['email_error'])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $_GET['email_error']; ?>
                            </div>
                        <?php } ?>
        
                        <hr>
                        <button type="submit" class="btn btn-success btn-user btn-block">Tambah</button>
                    </form>
                </div>
            </div>
        
        </div>
        

            