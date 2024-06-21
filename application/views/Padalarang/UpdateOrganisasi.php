
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Update Organisasi</h6>
                    </div>
                    <div class="card-body">
                    <?php echo $this->session->userdata("error"); ?>
                        <form class="user" method="post" action="<?=site_url('Padalarang/Padalarang_admin/prosesUpdateOrganisasi/'.$Padalarang_organisasi->id_organisasi)?>" enctype="multipart/form-data">
                            <!-- Input Judul -->
                            <div class="input-group mb-3">
                                <label for="keterangan">Keterangan</label>
                                <div class="col-sm-12">
                                <input type="text" class="form-control" name="keterangan" placeholder="Masukan Keterangan" value="<?=$Padalarang_organisasi->keterangan?>" required>
                                </div>
                            </div>
                        
                            <!-- Input Gambar -->
                            <div class="mb-3">
                                <label for="gambar" class="col-sm-2 control-label">Gambar</label>
                                    <div class="col-sm-12">
                                    <img src="<?=$Padalarang_organisasi->gambar?>" weight="50" height="60">
                                        <input type="file"  id="gambar" name="gambar">
                                    </div>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-success btn-user btn-block">Update Organisasi</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>

            