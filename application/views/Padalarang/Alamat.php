
            <!-- Alamat Peta -->
            <div class="container mt-5">
                <h2 class="center">Alamat</h2>
                <div class="row map-responsive">
                <?php
                    foreach ($Padalarang_sejarah->result() as $row) {?>
                    <div class="col-md-12 ">
                    <?php echo $row->alamat_map?> 
                    <?php } ?>
                    </div>
                </div>
            </div>
            