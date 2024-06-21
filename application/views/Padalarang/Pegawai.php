
            <!-- Spinner Start -->
            <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                    <div class="spinner-grow text-primary m-1" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-grow text-dark m-1" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-grow text-secondary m-1" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <!-- Spinner End -->

                <!-- Hero Start -->
                <div class="container-fluid bg-primary py-5 hero-header mb-5">
                    <div class="row py-3">
                        <div class="col-12 text-center">
                            <h1 class="display-3 text-white animated zoomIn">Data Pegawai</h1>
                        </div>
                    </div>
                </div>
                <!-- Hero End -->

                <!-- Team Start -->
                <div class="container-fluid py-5">
                    <div class="container">
                        <div class="row g-5">
                            <div class="col-lg-4 wow slideInUp" data-wow-delay="0.1s">
                                <div class="section-title bg-light rounded h-100 p-5">
                                    <h5 class="position-relative d-inline-block text-primary text-uppercase">Pegawai Kami</h5>
                                    <h1 class="display-6 mb-4">Temui Tenaga Kesehatan Bersertifikat & Berpengalaman Kami</h1>
                                </div>
                            </div>
                            <?php foreach ($Padalarang_pegawai->result() as $row) { ?>
                            <div class="col-lg-4 wow slideInUp" data-wow-delay="0.3s">
                                <div class="team-item">
                                    <div class="position-relative rounded-top" style="z-index: 1;">
                                        <img class="img-fluid rounded-top w-100" src="<?=$row->foto ?>" alt="" style="height: 300px; object-fit: cover;">
                                        <!-- Adjust height as needed and use object-fit to control image display -->
                                    </div>
                                    <div class="team-text position-relative bg-light text-center rounded-bottom p-4 pt-5">
                                        <h4 class="mb-2"><?=$row->nama ?></h4>
                                        <p class="text-primary mb-0"><?=$row->jabatan ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- Team End -->
            