<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold ">Riset Admin Website</h6>
        </div>
        <div class="card-body">
            <form class="user" method="post" action="<?=site_url('SuperAdmin/SuperAdmin/Update/'.$webpuskesmas->kode_puskesmas)?>" enctype="multipart/form-data">
                <!-- Bagian username -->
                <div class="mb-3">
                    <input type="text" class="form-control" name="username" placeholder="Username">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="email" placeholder="Email">
                </div>
                <!-- Bagian password -->
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
  
                <hr>
                <button type="submit" class="btn btn-success btn-user btn-block">Riset Admin</button>
            </form>
        </div>
    </div>
</div>
</div>
