
        <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text">Data Pegawai</h6>
                </div>
                <div class="card-body">
                    <div class="box">
                        <div class="box-header d-flex justify-content-between">
                            <div>
                                <a href="<?php echo site_url('Padalarang/Padalarang_admin/TambahPegawai'); ?>" class="btn btn-success mb-3">Tambah Pegawai</a>
                                <a href="<?php echo site_url('Padalarang/Padalarang_admin/JadwalPegawai'); ?>" class="btn btn-success mb-3">Jadwal Pegawai</a>
                                <a href="<?php echo site_url('Padalarang/Padalarang_admin/mpdfPegawai'); ?>" class="btn btn-success mb-3" target="_blank"> <i class="fas fa-print"></i></a>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <?php echo $this->session->userdata("success"); ?>
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>NIK</th>
                                            <th>NO HP</th>
                                            <th>Unit Kerja</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tempat Lahir</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Alamat</th>
                                            <th>Agama</th>
                                            <th>Pendidikan Terakhir</th>
                                            <th>Status Perkawinan</th>
                                            <th>Status Kepegawian</th>
                                            <th>Foto</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        foreach ($Padalarang_pegawai->result() as $row) {
                                            $edit = '<a class="btn btn-success btn-sm" href="' . site_url("Padalarang/Padalarang_admin/UpdatePegawai/" . $row->id_pegawai) . '"><i class="fas fa-edit"></i></a>';
                                            $hapus = '<a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#deleteModal_' . $row->id_pegawai . '"><i class="fas fa-trash"></i></a>';
                                            echo "<tr>";
                                            echo "<td>" . $row->nama . "</td>";
                                            echo "<td>" . $row->nik_pegawai . "</td>";
                                            echo "<td>" . $row->no_hp . "</td>";
                                            echo "<td>" . $row->jabatan . "</td>";
                                            echo "<td>" . $row->jenis_kelamin . "</td>";
                                            echo "<td>" . $row->tempatlahir . "</td>";
                                            echo "<td>" . $row->tgl_lahir . "</td>";
                                            echo "<td>" . $row->alamat . "</td>";
                                            echo "<td>" . $row->agama . "</td>";
                                            echo "<td>" . $row->pendidikan . "</td>";
                                            echo "<td>" . $row->perkawinan . "</td>";
                                            echo "<td>" . $row->status . "</td>";
                                            echo "<td><img src='" . $row->foto . "' width='100px' height='100px'></img></td>";
                                            echo "<td>" . $edit . "<br><br> " . $hapus . "</td>";
                                            echo "</tr>";
        
        
                                            // Modal konfirmasi hapus
                                            echo '<div class="modal fade" id="deleteModal_' . $row->id_pegawai. '" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">';
                                            echo '    <div class="modal-dialog">';
                                            echo '        <div class="modal-content">';
                                            echo '            <div class="modal-header">';
                                            echo '                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>';
                                            echo '                <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                                            echo '                    <span aria-hidden="true">&times;</span>';
                                            echo '                </button>';
                                            echo '            </div>';
                                            echo '            <div class="modal-body">';
                                            echo '                  Apakah Anda yakin ingin menghapus ' . $row->nama . '?';
                                            echo '            </div>';
                                            echo '            <div class="modal-footer">';
                                            echo '                <a href="' . site_url("Padalarang/Padalarang_admin/deletePegawai/" . $row->id_pegawai) . '" class="btn btn-danger">Ya</a>';
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
        

            