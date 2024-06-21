
            
            <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text">Data Galeri</h6>
                </div>
                <div class="card-body">
                    <div class="box">
                    <div class="box-header d-flex justify-content-between">
                        
                        <a href="<?php echo site_url('Padalarang/Padalarang_admin/TambahGalery'); ?>" class="btn btn-success mb-3">Tambah Galeri</a>
                    </div>

                        <div class="box-body">
                            <div class="table-responsive">
                            <?php echo $this->session->userdata("success"); ?>
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Kegiatan</th>
                                            <th>Gambar</th>
                                            <th>Di Edit</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                        foreach ($Padalarang_galery->result() as $row) {
                                            $edit = '<a class="btn btn-success  btn-sm" href="' . site_url("Padalarang/Padalarang_admin/UpdateGalery/" . $row->id_galery) . '"><i class="fas fa-edit"></i></a>';
                                            $hapus = '<a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#deleteModal_' . $row->id_galery . '"><i class="fas fa-trash"></i></a>';
                                            echo "<tr>";
                                            echo "<td>" . substr($row->kegiatan, 0, 200) . "</td>";
                                            echo "<td><img src='" . $row->gambar . "' width='100px' height='100px'></img></td>";
                                            echo "<td>" .$row->date_create . "</td>";
                                            echo "<td>" . $edit . "<br><br> " . $hapus . "</td>";
                                            echo "</tr>";

                                            // Modal konfirmasi hapus
                                            echo '<div class="modal fade" id="deleteModal_' . $row->id_galery . '" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">';
                                            echo '    <div class="modal-dialog">';
                                            echo '        <div class="modal-content">';
                                            echo '            <div class="modal-header">';
                                            echo '                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>';
                                            echo '                <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                                            echo '                    <span aria-hidden="true">&times;</span>';
                                            echo '                </button>';
                                            echo '            </div>';
                                            echo '            <div class="modal-body">';
                                            echo '                Apakah Anda yakin ingin menghapus galeri' . $row->kegiatan .'?';
                                            echo '            </div>';
                                            echo '            <div class="modal-footer">';
                                            echo '                <a href="' . site_url("Padalarang/Padalarang_admin/deleteGalery/" . $row->id_galery) . '" class="btn btn-danger">Ya</a>';
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



            