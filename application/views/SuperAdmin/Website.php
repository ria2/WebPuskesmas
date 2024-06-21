<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text">Data Website</h6>
        </div>
        <div class="card-body">
            <div class="box">
                <div class="box-header d-flex justify-content-between">
                    <a href="<?php echo site_url('SuperAdmin/SuperAdmin/Generator'); ?>" class="btn btn-success mb-3 ">Tambah Website</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                    <?php echo $this->session->userdata("success"); ?>
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama Aplikasi</th>
                                    <th>Deskripsi</th>
                                    <th>Kabupaten</th>
                                    <th>Url</th>
                                    <th>Create</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach ($webpuskesmas->result() as $row) {
                                    $edit = '<a class="btn btn-warning btn-sm" href="' . site_url("SuperAdmin/Content/Adminpuskesmas/" . $row->kode_puskesmas) . '"><i class="fas fa-cog"></i></a>';
                                    $hapus = '<a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#deleteModal_' . $row->kode_puskesmas . '"><i class="fas fa-trash"></i></a>';
                                    $detail = '<a class="btn btn-primary btn-sm" href="' . site_url("SuperAdmin/Content/DetailWeb/" . $row->kode_puskesmas) . '"><i class="fas fa-eye"></i></a>';
                                    echo "<tr>";
                                    echo "<td>" . $row->nama_aplikasi . "</td>";
                                    echo "<td>" . $row->deskripsi . "</td>";
                                    echo "<td>" . $row->kecamatan . "</td>";
                                    echo "<td><a href='" . $row->domain . "'>" . $row->domain . "</a></td>";
                                    echo "<td>" . $row->create . "</td>";
                                    echo "<td class='text-center'>" . $detail . "<hr> ". $edit . "<hr> ". $hapus . "</td>";
                                    echo "</tr>";

                                    // Modal konfirmasi hapus
                                    echo '<div class="modal fade" id="deleteModal_' . $row->kode_puskesmas . '" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">';
                                    echo '    <div class="modal-dialog">';
                                    echo '        <div class="modal-content">';
                                    echo '            <div class="modal-header">';
                                    echo '                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>';
                                    echo '                <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                                    echo '                    <span aria-hidden="true">&times;</span>';
                                    echo '                </button>';
                                    echo '            </div>';
                                    echo '            <div class="modal-body">';
                                    echo '                Apakah Anda yakin ingin menghapus website ini?';
                                    echo '            </div>';
                                    echo '            <div class="modal-footer">';
                                    echo '                <a href="' . site_url("SuperAdmin/SuperAdmin/delete/" . $row->kode_puskesmas) . '" class="btn btn-danger">Ya</a>';
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