<div class="container-fluid">
    <?php echo $this->session->userdata("success"); ?>
    <?php
        foreach ($admin->result() as $row) {
            if($row->username == $this->session->userdata('username')){

    ?>
    <div class="card mb-3">
        <div class="row no-gutters">
            <div class="col-md-3">
                <img src="<?=$row->foto?>" class="card-img" alt="...">
            </div>
            <div class="col-md-7">
                <div class="card-body">
                    
                    <h5 class="card-title"><?=$row->nama?></h5>
                    <p class="card-text"><strong>Username:</strong> <?=$row->username?></p>
                    <p class="card-text"><strong>Email:</strong> <?=$row->email?></p>
                    <p class="card-text"><strong>No HP:</strong> <?=$row->no_hp?></p>
                    <br>
                    <br>
                    <a href="<?= site_url("Auth/UpdateAdmin/" . $row->id_user)?>" class="btn btn-success">Update Profile <i class="fas fa-edit"></i></a>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php } ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-">Data Super Admin</h6>
        </div>
        <div class="card-body">
            <div class="box">
                <div class="box-header d-flex justify-content-between">
                    <a href="<?php echo site_url('Auth/TambahAdmin'); ?>" class="btn btn-success mb-3">Tambah Super Admin</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>NO HP</th>
                                    <th>Username</th>
                                    <th>Foto</th>
                                    <th>Di Edit</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($admin->result() as $row) {
                                    if($row->username !== $this->session->userdata('username')){
                                   
                                    $hapus = '<a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#deleteModal_' . $row->id_user . '"><i class="fas fa-trash"></i></a>';
                                    echo "<tr>";
                                    echo "<td>" . $row->nama . "</td>";
                                    echo "<td>" . $row->email . "</td>";
                                    echo "<td>" . $row->no_hp . "</td>";
                                    echo "<td>" . $row->username . "</td>";
                                    echo "<td><img src='" . $row->foto . "' width='100px' height='100px'></img></td>";
                                    echo "<td>" . $row->date_create . "</td>";
                                    
                                    echo "<td class='text-center'> " . $hapus;
                                    }
                                    
                                    echo "</td>";
                                    echo "</tr>";
                                    // Modal konfirmasi hapus
                                    echo '<div class="modal fade" id="deleteModal_' . $row->id_user . '" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">';
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
                                    echo '                <a href="' . site_url("Auth/deleteAdmin/" . $row->id_user) . '" class="btn btn-danger">Ya</a>';
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
