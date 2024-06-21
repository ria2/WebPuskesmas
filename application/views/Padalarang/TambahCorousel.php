
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Buat SlideShow</h6>
                    </div>
                    <div class="card-body">
                    <?php echo $this->session->userdata("error"); ?>
                        <form class="user" method="post" action="<?=site_url('Padalarang/Padalarang_admin/prosesTambahCorousel')?>" enctype="multipart/form-data">
                            <!-- Input Judul -->
                            <div class="input-group mb-3">
                                <label for="judul">Judul</label>
                                <div class="col-sm-12">
                                <input type="text" class="form-control" name="judul" placeholder="Masukan Judul"  required>
                                </div>
                            </div>
                            <!-- Input Judul -->
                            <div class="input-group mb-3">
                                <label for="keterangan">Keterangan</label>
                                <div class="col-sm-12">
                                <input type="text" class="form-control" name="keterangan" placeholder="Masukan Keterangan"  required>
                                </div>
                            </div>
                        
                            <!-- Input Gambar -->
                            <div class="mb-3">
                                <label for="gambar" class="col-sm-2 control-label">Gambar</label>
                                    <div class="col-sm-12">
                                        <input type="file" class="form-control" id="gambar" name="gambar">
                                        <div class="form-text" id="basic-addon4"> Format : (.png/.jpg/.gif)  Size min : 63,8 KB, Dimension Rekomended : 2048 x 1150 Lanscape</div>
                                    </div>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-success btn-user btn-block">Buat SlideShow</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>



            