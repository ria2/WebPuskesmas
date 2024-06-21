
           
            <div class="container-fluid">
            <div class="d-flex align-items-center">
                    <form class="col-2 d-flex align-items-center" method="post" action="<?=site_url('Padalarang/Padalarang_admin/UpdateAntrian/'.$antrian->id)?>" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label>Max Antrian</label>
                            <input type="number" class="form-control" name="max_nomber" value="<?=$antrian->max_nomber?>">
                        </div>
                        <button type="submit" class=" btn-success btn-sm"><i class="fas fa-check"></i></button>
                    </form>
                </div>
                <div class="card mt-2">
                    <div class="card-body">
                        <form class="mb-4" method="GET" action="">
                            <div class="row">
                                <div class="col-3">
                                    <input type="date" class="form-control" name="tanggalawal">
                                </div>
                                <div class="col-3">
                                    <input type="date" class="form-control" name="tanggalakhir">
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-success" type="submit"> Cari</button>
                                </div>
                            </div>
                        </form>
                        <?php
                        $tanggalawal = $this->input->get('tanggalawal');
                        $tanggalakhir = $this->input->get('tanggalakhir');
                        ?>
                        <?php if (!$tanggalawal && !$tanggalakhir) : ?>
                            <a href="<?= base_url('Padalarang/Padalarang_admin/mpdfPendaftaran'); ?>" class="btn btn-success ml-2" target="_blank">Cetak Laporan</a>
                            <h4 class="text-center mt-2"> Laporan antrian terkini <?= date('d F Y'); ?> </h4>
                        <?php else : ?>
                            <?php
                            $url = base_url('Padalarang/Padalarang_admin/mpdfPendaftaran') . '?tanggalawal=' . urlencode($tanggalawal) . '&tanggalakhir=' . urlencode($tanggalakhir);
                            ?>
                            <a href="<?= $url; ?>" class="btn btn-success ml-2" target="_blank">Cetak Laporan</a>
                            <h4 class="text-center mt-2"> Laporan antrian periode tanggal <?= $tanggalawal . ' s/d ' . $tanggalakhir; ?> </h4>
                        <?php endif; ?>
                    </div>
                </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-">Data Pendaftaran</h6>
                </div>
                <div class="card-body">
                    <div class="box">
                    <div class="box-header d-flex justify-content-between">
                    </div>
                    <div class="box-body">
                    <div class="table-responsive">
                    <?php echo $this->session->userdata("success"); ?>
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Tempat Lahir</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Alamat</th>
                                            <th>Pekerjaan</th>
                                            <th>Layanan</th>
                                            <th>No Antrian</th>
                                            <th>QR</th>
                                            <th>Tanggal Daftar</th>
                                            <th>Opsi</th>
                                            
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                        foreach ($Padalarang_pendaftaran->result() as $row) {
                                           
                                            $hapus = '<a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#deleteModal_' . $row->id_pendaftaran . '"><i class="fas fa-trash"></i></a>';
                                            echo "<tr>";
                                            
                                            echo "<td>" . $row->nik . "</td>";
                                            echo "<td>" . $row->nama . "</td>";
                                            echo "<td>" . $row->tempat_lahir . "</td>";
                                            echo "<td>" . $row->tanggal_lahir . "</td>";
                                            echo "<td>" . $row->jk . "</td>";
                                            echo "<td>" . $row->alamat . "</td>";
                                            echo "<td>" . $row->pekerjaan . "</td>";
                                            echo "<td>" . $row->layanan . "</td>";
                                            echo "<td>" . $row->nomor_pendaftaran . "</td>";
                                            echo "<td><img src='" . $row->qr_code . "' width='100px' height='100px'></img></td>";
                                            echo "<td>" . $row->tanggal . "</td>";
                                            echo "<td>" . $hapus . "</td>";
                                            echo "</tr>";

                                            // Modal konfirmasi hapus
                                            echo '<div class="modal fade" id="deleteModal_' . $row->id_pendaftaran . '" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">';
                                            echo '    <div class="modal-dialog">';
                                            echo '        <div class="modal-content">';
                                            echo '            <div class="modal-header">';
                                            echo '                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>';
                                            echo '                <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                                            echo '                    <span aria-hidden="true">&times;</span>';
                                            echo '                </button>';
                                            echo '            </div>';
                                            echo '            <div class="modal-body">';
                                            echo '                Apakah Anda yakin ingin menghapus pendaftar' . $row->nama .'?';
                                            echo '            </div>';
                                            echo '            <div class="modal-footer">';
                                            echo '                <a href="' . site_url("Padalarang/Padalarang_admin/deletePendaftaran/" . $row->id_pendaftaran) . '" class="btn btn-danger">Ya</a>';
                                            echo '                <button type="button" class="btn btn-success" data-dismiss="modal">Tidak</button>';
                                            echo '            </div>';
                                            echo '        </div>';
                                            echo '    </div>';
                                            echo '</div>';
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
            </div>

            