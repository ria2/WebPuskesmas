
            <style>
                .news-card {
                    height: 100%;
                }

                .news-image {
                    height: 150px; /* Sesuaikan ukuran gambar yang diinginkan */
                    object-fit: cover;
                }
            </style>

            <div class="container mt-5">
                <h2 class="center">Berita</h2>
                
                <div class="row row-cols-1 row-cols-md-3">
                    <?php 
                    $counter = 0; // Inisialisasi counter berita yang ditampilkan
                    
                    // Urutkan data berita berdasarkan tanggal secara descending (baru ke lama)
                    $sorted_berita = array_reverse($berita->result());

                    foreach ($sorted_berita as $row) {
                        if ($counter >= 3) {
                            break; // Hentikan perulangan setelah 3 berita ditampilkan
                        }
                    ?>
                    <div class="col mb-4">
                        <div class="card news-card">
                            <img src="<?=$row->gambar?>" class="card-img-top news-image" alt="News Image">
                            <div class="card-body">
                                <p class="card-text">
                                    <b><?=$row->judul?></b><br>
                                    <?=substr($row->deskripsi, 0, 100)?>...
                                </p>
                                <a href="<?=site_url('Padalarang/Padalarang/ArtikelLengkap/'. $row->id_berita)?>" class="btn btn-success">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <?php 
                        $counter++; // Increment counter setiap kali berita ditampilkan
                    }?>
                    <!-- End of articles items -->
                </div>
            </div>



            