
            
            <div class="container-fluid">
                        

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-">Data Sosial Media</h6>
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
                                            <th>Instagram</th>
                                            <th>Facebook</th>
                                            <th>Twitter</th>
                                            <th>Email</th>
                                            <th>No HP</th>
                                            <th>Kode POS</th>
                                            
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                        foreach ($Padalarang_sosialmedia->result() as $row) {
                                            // tambahan
                                            $edit = '<a class="btn btn-success btn-sm" href="' . site_url("Padalarang/Padalarang_admin/UpdateSosialMedia/" . $row->id_sosialmedia) . '"><i class="fas fa-edit"></i></a>';
                                    
                                            echo "<tr>";
                                            echo "<td>" . $row->instagram . "</td>";
                                            echo "<td>" . $row->facebook . "</td>";
                                            echo "<td>" . $row->twiter . "</td>";
                                            echo "<td>" . $row->email . "</td>";
                                            echo "<td>" . $row->no_hp . "</td>";
                                            echo "<td>" . $row->kode_pos . "</td>";
                                            
                                            echo "<td>" . $edit. "</td>";
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


            