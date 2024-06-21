<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Edit Pegawai</h6>
        </div>
        <div class="card-body">
            <?php echo $this->session->flashdata("error"); ?>
            <form class="user" method="post" action="<?= site_url('Padalarang/Padalarang_admin/prossesUpdateJadwal/'.$Padalarang_pegawai->id_pegawai) ?>" enctype="multipart/form-data">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jammasuk">Jam Masuk:</label>
                                <input type="time" class="form-control" name="jammasuk" id="jammasuk" value="<?= $Padalarang_pegawai->jammasuk ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jamkeluar">Jam Keluar:</label>
                                <input type="time" class="form-control" name="jamkeluar" id="jamkeluar" value="<?= $Padalarang_pegawai->jamkeluar ?>">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-success btn-user btn-block">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
