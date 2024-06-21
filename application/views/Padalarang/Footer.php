
            <!-- Footer Start -->
            <div class="container-fluid bg-dark text-light py-5 wow fadeInUp" data-wow-delay="0.3s" style="margin-top: -75px;">
                    <div class="container pt-5">
                        <div class="row g-5 pt-4">
                            <div class="col-lg-3 col-md-6">
                            
                                <h3 class="text-white mb-4">Kontak Kami</h3>
                                <?php
                                    foreach ($Padalarang_sejarah->result() as $row) {?>
                                <p class="mb-2"><i class="bi bi-geo-alt text-primary me-2"></i><?php echo $row->alamat?></p>
                                <?php }?>
                                <?php
                                    foreach ($Padalarang_sosialmedia->result() as $row) {?>
                                <p class="mb-2"><i class="bi bi-envelope-open text-primary me-2"></i><?php echo $row->email?></p>
                                <p class="mb-0"><i class="bi bi-telephone text-primary me-2"></i><?php echo $row->no_hp?></p>
                                <?php }?>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <h3 class="text-white mb-4">Tautan</h3>
                                <div class="d-flex flex-column justify-content-start">
                                    <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Kabupaten Bandung Barat</a>
                                    <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Dinkes KBB</a>
                                    <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Diskominfotik KBB</a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <h3 class="text-white mb-4">Jam Pelayanan</h3>
                                <div class="d-flex flex-column justify-content-start">
                                <p class="text-white mb-2">Jam Pelayanan Puskesmas <br>
                                                            Senin-Kamis : 07.00 - 15.00 <br>
                                                            Jumat : 07.00 - 11.00 <br>
                                                            Unit Pelayanan Bersalin 24 Jam <br>
                                                            Info lebih lanjut silahkan lihat  dibagian Layanan pada tab Layanan <br>
                                </p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <h3 class="text-white mb-4">Sosial Media Kami</h3>
                                <div class="d-flex">
                                <?php
                                    foreach ($Padalarang_sosialmedia->result() as $row) {?>
                                    <a class="btn btn-lg btn-dark btn-lg-square rounded me-2" href="<?php echo $row->twiter?>"><i class="fab fa-twitter fw-normal"></i></a>
                                    <a class="btn btn-lg btn-dark btn-lg-square rounded me-2" href="<?php echo $row->facebook?>"><i class="fab fa-facebook-f fw-normal"></i></a>
                                    <a class="btn btn-lg btn-dark btn-lg-square rounded" href="<?php echo $row->instagram?>"><i class="fab fa-instagram fw-normal"></i></a>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="container-fluid text-light py-4" style="background: #27ae60;">
                    <div class="container">
                        <div class="row g-0">
                            <div class="col-md-6 text-center text-md-start">
                                <p class="mb-md-0">&copy; <a class="text-white border-bottom" href="#">2023</a>: Diskominfotik Kabupaten Bandung Barat</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer End -->

                <!-- JavaScript Libraries -->
            <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="<?php echo base_url('asset/assets_user/lib/wow/wow.min.js'); ?>"></script>
            <script src="<?php echo base_url('asset/assets_user/lib/easing/easing.min.js'); ?>"></script>
            <script src="<?php echo base_url('asset/assets_user/lib/waypoints/waypoints.min.js'); ?>"></script>
            <script src="<?php echo base_url('asset/assets_user/lib/owlcarousel/owl.carousel.min.js'); ?>"></script>
            <script src="<?php echo base_url('asset/assets_user/lib/tempusdominus/js/moment.min.js'); ?>"></script>
            <script src="<?php echo base_url('asset/assets_user/lib/tempusdominus/js/moment-timezone.min.js'); ?>"></script>
            <script src="<?php echo base_url('asset/assets_user/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js'); ?>"></script>
            <script src="<?php echo base_url('asset/assets_user/lib/twentytwenty/jquery.event.move.js'); ?>"></script>
            <script src="<?php echo base_url('asset/assets_user/lib/twentytwenty/jquery.twentytwenty.js'); ?>"></script>


            <!-- Template Javascript -->
            <script src="<?php echo base_url('asset/assets_user/js/main.js'); ?>"></script>
            </body>
            </html>
            