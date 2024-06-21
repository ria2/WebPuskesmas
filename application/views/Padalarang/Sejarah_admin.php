
            
            <div class="container-fluid">
                        

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-">Data Sejarah & Maklumat</h6>
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
                                            <th>Sejarah</th>
                                            <th>Maklumat</th>
                                            <th>Alamat</th>                
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                        foreach ($Padalarang_sejarah->result() as $row) {
                                            // tambahan
                                            $edit = '<a class="btn btn-success btn-sm" href="' . site_url("Padalarang/Padalarang_admin/UpdateSejarah/" . $row->id_sejarah) . '"><i class="fas fa-edit"></i></a>';
                                    
                                            echo "<tr>";
                                            echo "<td>" . $row->sejarah . "</td>";
                                            echo "<td><img src='" . $row->maklumat . "' width='100px' height='100px'></img></td>";
                                            echo "<td>" . $row->alamat . "</td>";
                                            
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


            