
            
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Update Layanan Publik</h6>
                    </div>
                    <div class="card-body">
                    <?php echo $this->session->userdata("error"); ?>
                        <form class="user" method="post" action="<?=site_url('Padalarang/Padalarang_admin/prosesUpdateLayananPublik/' .$Padalarang_layananpublik->id_layananpublik)?>" enctype="multipart/form-data">
                       
                            <div class="mb-2">
                                <label for="produk">Produk Layanan</label>
                                <input type="text" class="form-control" name="produk" placeholder="Masukan Produk Layanan" value="<?=$Padalarang_layananpublik->produk?>"  required>
                            </div>
                            <div class="mb-2">
                                <label for="biaya">Biaya</label>
                                <input type="number" class="form-control" name="biaya" placeholder="Masukan Biaya"  value="<?=$Padalarang_layananpublik->biaya?>" required>
                            </div>
                           
                            <hr>
                            <button type="submit" class="btn btn-success btn-user btn-block mb-3">Update Layanan Publik</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>

            