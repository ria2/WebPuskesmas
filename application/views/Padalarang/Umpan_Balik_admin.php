
            <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text">Data Pengaduan</h6>
                </div>
                <div class="card-body">
                    <div class="box">
        
                        <div class="box-body">
                            <div class="table-responsive">
                            <?php echo $this->session->userdata("success"); ?>
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama </th>
                                            <th>Email</th>
                                            <th>Subject</th>
                                            <th>Pesan</th>
                                            <th>Tanggal</th>
                                            <th>Balas</th>
                                            
                                        </tr>
                                    </thead>
        
                                    <tbody>
                                    <?php
                                        foreach ($umpan_balik->result() as $row) {
                                            if ($row->puskesmas == 'Padalarang') {
                                                $hapus = '<a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#deleteModal_' . $row->id_umpan_balik . '"><i class="fas fa-trash"></i></a>';
                                                $balas = '<a class="btn btn-warning btn-sm " href="' . site_url("Padalarang/Padalarang_admin/BalasPengaduan/" . $row->id_umpan_balik) . '"><i class="fas fa-share"></i></a>';
                                                echo "<tr>";
                                                echo "<td>" . $row->nama . "</td>";
                                                echo "<td>" . $row->email . "</td>";
                                                echo "<td>" . $row->subject . "</td>";
                                                echo "<td>" . $row->pesan . "</td>";
                                                echo "<td>" . $row->tanggal . "</td>";
                                                echo "<td>" . $balas . "</td>";
                                                echo "</tr>";
                                            }
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
        

            