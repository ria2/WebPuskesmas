
            <div class="container-fluid">
                

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text">Data Visi & Misi</h6>
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
                                                <th>Visi</th>
                                                <th>Misi</th>
                                                <th>Motto</th>
                                                <th>Tata Nilai</th>
                                                <th>Logo</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                            foreach ($Padalarang_visi_misi->result() as $row) {
                                                $edit = '<a class="btn btn-success btn-sm" href="' . site_url("Padalarang/Padalarang_admin/UpdateVisi/" . $row->id_visi) . '"><i class="fas fa-edit"></i></a>';
                                            
                                                echo "<tr>";
                                                echo "<td>" . substr($row->visi, 0, 200) . "</td>";
                                                echo "<td>" . substr($row->misi, 0, 200) . "</td>";
                                                echo "<td>" . substr($row->motto, 0, 200). "</td>";
                                                echo "<td>" . substr($row->tatanilai, 0, 200) . "</td>";
                                                echo "<td>" . substr($row->logo, 0, 200) . "</td>";
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

            