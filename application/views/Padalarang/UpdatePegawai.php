
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Edit Pegawai</h6>
                    </div>
                    <div class="card-body">
                    <?php echo $this->session->userdata("error"); ?>
                        <form class="user" method="post" action="<?= site_url('Padalarang/Padalarang_admin/prossesUpdatePegawai/'.$Padalarang_pegawai->id_pegawai) ?>" enctype="multipart/form-data">
                        <div class="mb-3">
                                <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" value="<?= $Padalarang_pegawai->nama ?>" required>
                            </div>
                            <div class="mb-3">
                                <input type="number" class="form-control" name="nik_pegawai" placeholder="Masukan NIK" value="<?= $Padalarang_pegawai->nik_pegawai ?>" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="16">
                            </div>
                            <div class="mb-3">
                                <input type="number" class="form-control" name="no_hp" placeholder="No Telepon" value="<?= $Padalarang_pegawai->no_hp ?>" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="jabatan" placeholder="Unit Kerja" value="<?= $Padalarang_pegawai->jabatan ?>" required>
                            </div>
                            <div class="form-group">
                                <select name="jenis_kelamin" class="form-control" required>
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="tempatlahir" placeholder="Tempat Lahir"  value="<?= $Padalarang_pegawai->tempatlahir ?>" required>
                            </div>
                            <div class="mb-3">
                                <span class="input-group-text fas fa-calendar" >Tanggal Lahir</span>
                                <input type="date" class="form-control" name ="tgl_lahir" value="<?= $Padalarang_pegawai->tgl_lahir ?>">
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="alamat" placeholder="Alamat" value="<?= $Padalarang_pegawai->tempatlahir ?>" style="height: 100px;" required>
                            </div>
                            <div class="form-group">
                                <select name="agama" class="form-control" required>
                                    <option value="" disabled selected>Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="pendidikan" class="form-control" required>
                                    <option value="" disabled selected>Pilih Pendidikan Terakhir</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA/SMK">SMA/SMK</option>
                                    <option value="Diploma">Diploma</option>
                                    <option value="Sarjana">Sarjana (S1)</option>
                                    <option value="Magister">Magister (S2)</option>
                                    <option value="Doktor">Doktor (S3)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="perkawinan" class="form-control" required>
                                    <option value="" disabled selected>Pilih Status Perkawinan</option>
                                    <option value="Belum Menikah">Belum Menikah</option>
                                    <option value="Menikah">Menikah</option>
                                    <option value="Pernah Menikah">Pernah Menikah</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <select name="status" class="form-control" required>
                                    <option value="" disabled selected>Pilih Status Kepegawaian</option>
                                    <option value="Orientasi">Orientasi</option>
                                    <option value="Kontrak">Kontrak</option>
                                    <option value="Tetap">Tetap</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Foto</label>
                                <img src="<?= $Padalarang_pegawai->foto ?>" width="50" height="60">
                                <input type="hidden" name="default_foto" value="<?= $Padalarang_pegawai->foto ?>">
                                <input type="file" class="form-control" name="foto" placeholder="Foto">
                                <div class="form-text" id="basic-addon4"> Format : (.png/.jpg/.gif)  Size min : 1 MB , Dimension Recomended : 500 x 450</div>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-success btn-user btn-block">Update</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>

            