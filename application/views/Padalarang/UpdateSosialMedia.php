
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Data Sosial Media</h6>
                    </div>
                    <div class="card-body">
                        <form class="user" method="post" action="<?=site_url('Padalarang/Padalarang_admin/prossesUpdateSosialMedia/'. $Padalarang_sosialmedia->id_sosialmedia)?>" enctype="multipart/form-data">
                            
                            <!-- Input Email -->
                            <div class="input-group mb-3">
                                <span class="input-group-text fas fa-envelope"></span>
                                <input type="email" class="form-control" name="email" placeholder="Alamat Email" value="<?=$Padalarang_sosialmedia->email?>" required>
                            </div>
                            
                            <!-- Input No Telpon -->
                            <div class="input-group mb-3">
                                <span class="input-group-text fas fa-user"></span>
                                <input type="number" class="form-control" name="no_hp" placeholder="No Telpon" value="<?=$Padalarang_sosialmedia->no_hp?>" required>
                            </div>
                            
                            <!-- Input Kode Pos -->
                            <div class="input-group mb-3">
                                <span class="input-group-text fas fa-map"></span>
                                <input type="number" class="form-control" name="kode_pos" placeholder="Kode Post" value="<?=$Padalarang_sosialmedia->kode_pos?>" required>
                            </div>
                            
                            <!-- Input Instagram -->
                            <div class="input-group mb-3">
                                <span class="input-group-text fab fa-instagram"></span>
                                <input type="text" class="form-control" name="instagram" placeholder="Instagram Link" value="<?=$Padalarang_sosialmedia->instagram?>" required>
                            </div>
                            
                            <!-- Input Facebook -->
                            <div class="input-group mb-3">
                                <span class="input-group-text fab fa-facebook"></span>
                                <input type="text" class="form-control" name="facebook" placeholder="Facebook Link" value="<?=$Padalarang_sosialmedia->facebook?>" required>
                            </div>
                            
                            <!-- Input Twitter -->
                            <div class="input-group mb-3">
                                <span class="input-group-text fab fa-twitter"></span>
                                <input type="text" class="form-control" name="twiter" placeholder="Twitter Link" value="<?=$Padalarang_sosialmedia->twiter?>" required>
                            </div>
                            
                            <hr>
                            <button type="submit" class="btn btn-success btn-user btn-block">Update Sosial Media</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            