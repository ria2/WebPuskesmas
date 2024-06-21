
            <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text">Data Organisasi</h6>
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
                                            <th>Keterangan</th>
                                            <th>Gambar</th>
                                            <th>Di Edit</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                        foreach ($Padalarang_organisasi->result() as $row) {
                                            $edit = '<a class="btn btn-success  btn-sm" href="' . site_url("Padalarang/Padalarang_admin/UpdateOrganisasi/" . $row->id_organisasi) . '"><i class="fas fa-edit"></i></a>';
                                            
                                            echo "<tr>";
                                            echo "<td>" . $row->keterangan . "</td>";
                                            echo "<td><img src='" . $row->gambar . "' width='100px' height='100px'></img></td>";
                                            echo "<td>" .$row->date_create . "</td>";
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


            