
            
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text">Data Layanan Publik</h6>
                    </div>
                    <div class="card-body">
                        <div class="box">
                        <div class="box-header d-flex justify-content-between">
                            
                            <a href="<?php echo site_url('Padalarang/Padalarang_admin/TambahLayananPublik'); ?>" class="btn btn-success mb-3">Tambah Layanan Publik</a>
                        </div>

                            <div class="box-body">
                                <div class="table-responsive">
                                <?php echo $this->session->userdata("success"); ?>
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Produk Layanan</th>
                                                <th>Biaya</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                            foreach ($Padalarang_layananpublik->result() as $row) {
                                                $edit = '<a class="btn btn-success  btn-sm" href="' . site_url("Padalarang/Padalarang_admin/UpdateLayananPublik/" . $row->id_layananpublik) . '"><i class="fas fa-edit"></i></a>';
                                                $hapus = '<a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#deleteModal_' . $row->id_layananpublik . '"><i class="fas fa-trash"></i></a>';
                                                echo "<tr>";
                                                echo "<td>" . $row->produk . "</td>";
                                                echo "<td>" . 'Rp.' . number_format($row->biaya) . "</td>";
                                                echo "<td class='text-center'>" . $edit . " " . $hapus . "</td>";
                                                echo "</tr>";
                                                // Modal konfirmasi hapus
                                                echo '<div class="modal fade" id="deleteModal_' . $row->id_layananpublik . '" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">';
                                                echo '    <div class="modal-dialog">';
                                                echo '        <div class="modal-content">';
                                                echo '            <div class="modal-header">';
                                                echo '                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>';
                                                echo '                <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                                                echo '                    <span aria-hidden="true">&times;</span>';
                                                echo '                </button>';
                                                echo '            </div>';
                                                echo '            <div class="modal-body">';
                                                echo '                Apakah Anda yakin ingin menghapus Layanan ' . $row->produk .'?';
                                                echo '            </div>';
                                                echo '            <div class="modal-footer">';
                                                echo '                <a href="' . site_url("Padalarang/Padalarang_admin/deleteLayananPublik/" . $row->id_layananpublik) . '" class="btn btn-danger">Ya</a>';
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

            
            
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text">Mekanisme & Prosedur</h6>
                    </div>
                    <div class="card-body">
                        <div class="box">
                            <div class="box-body">
                                <div class="table-responsive">
                                <?php echo $this->session->userdata("success_edit"); ?>
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Standar <br>Pelayanan <br>Masyarakat</th>
                                                <th>Konpensasi</th>
                                                <th>Mekanisme & Prosedur</th>
                                                <th>Sarana</th>
                                                <th>Fasilitas</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                            foreach ($Padalarang_layanan->result() as $row) {
                                                $edit = '<a class="btn btn-success  btn-sm" href="' . site_url("Padalarang/Padalarang_admin/UpdateLayanan/" . $row->id_layanan) . '"><i class="fas fa-edit"></i></a>';
                                                echo "<tr>";
                                                echo "<td><img src='" . $row->spm . "' width='100px' height='100px'></img></td>";
                                                echo "<td><img src='" . $row->konpensasi . "' width='100px' height='100px'></img></td>";
                                                echo "<td>" . substr($row->mekanisme, 0, 150) . "</td>";
                                                echo "<td>" . substr($row->sarana, 0, 150) . "</td>";
                                                echo "<td>" . $row->fasilitas . "</td>";
                                                echo "<td class='text-center'>" . $edit . "</td>";
                                                echo "</tr>";
                                               
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
                  
            