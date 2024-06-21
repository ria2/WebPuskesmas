<div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text">Jadwal Pegawai</h6>
                </div>
                <div class="card-body">
                    <div class="box">
                        <div class="box-header d-flex justify-content-between">
                            <a href="<?php echo site_url('Padalarang/Padalarang_admin/DataPegawai'); ?>" class="btn btn-success mb-3">Halaman Pegawai</a>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                            <?php echo $this->session->userdata("success"); ?>
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Unit Kerja</th>
                                            <th>Jam Masuk</th>
                                            <th>Jam Keluar</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        foreach ($Padalarang_pegawai->result() as $row) {
                                            $edit = '<a class="btn btn-success btn-sm" href="' . site_url("Padalarang/Padalarang_admin/UpdateJadwal/" . $row->id_pegawai) . '"><i class="fas fa-edit"></i></a>';
                                            echo "<tr>";
                                            echo "<td>" . $row->nama . "</td>";
                                            echo "<td>" . $row->jabatan . "</td>";
                                            echo "<td>" . $row->jammasuk . "</td>";
                                            echo "<td>" . $row->jamkeluar . "</td>";
                                            echo "<td>" . $edit . "</td>";
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
        </div>