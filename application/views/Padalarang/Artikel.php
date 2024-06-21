
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
                           <h1 class="display-3 text-white animated zoomIn">Artikel & Berita</h1>
                       </div>
                   </div>
               </div>
               <!-- Hero End -->
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
                <h2 class="text-center">Artikel</h2>
                
                <div class="row row-cols-1 row-cols-md-3">
                    <?php 
                    $counter = 0; // Inisialisasi counter berita yang ditampilkan
                    
                    // Urutkan data berita berdasarkan tanggal secara descending (baru ke lama)
                    $sorted_berita = array_reverse($berita->result());
            
                    foreach ($sorted_berita as $row) {
                        if ($counter >= 10) {
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
            <!-- Include SweetAlert2 CSS -->
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
            <!-- Include SweetAlert2 JavaScript -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>Swal.fire ({title:"Bagian ini dikerjakan oleh kelompok lain!", confirmButtonColor: '#005700'}); </script>

        

           
            