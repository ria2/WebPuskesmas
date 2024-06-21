
            <style>
                .news-card {
                    height: 100%;
                }

                .news-image {
                    height: 150px; /* Sesuaikan ukuran gambar yang diinginkan */
                    object-fit: cover;
                }
            </style>
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
             <div class="container mt-5">
             <div class="row">
                 <div class="col-md-8">
                     <div class="card wow zoomIn" data-wow-delay="0.6s">
                         <div class="card-body">
                             <h1 class="card-title"><?=$berita->judul?></h1>
                             <p class="card-text" style="text-transform: capitalize;">Berita ini ditulis oleh <?=$berita->penulis?></p>
                             <hr>
                             <div class="d-flex justify-content-center">
                                 <img src="<?=$berita->gambar?>" class="card-img-top" style="max-width: 100%;" alt="">
                             </div>
                             <p class="card-text"><?=$berita->deskripsi?></p>
                             <br>
                             <hr>
                             <p class="card-text">Penulis : <?=$berita->penulis?></p>
                             <hr>
                             <p class="card-text">Sumber: <a href="<?=$berita->sumber?>"><?=$berita->sumber?></a></p>
         
                             <hr>
                             <p class="card-text">Publish : <?=$berita->date_create?></p>
                         </div>
                     </div>
                 </div>
                 <div class="col-md-4"> <!-- Galeri sisi -->
                     <?php 
                     $counter = 0;
                     $sorted_berita_data = array_reverse($berita_data->result());
             
                     foreach ($sorted_berita_data as $row) {
                         if ($counter >= 3) {
                             break; 
                         }
                     ?>
                     <div class=" ">
                         <div class="card news-card">
                             <img src="<?=$row->gambar?>" class="card-img-top news-image" alt="News Image">
                             <div class="card-body">
                                 <p class="card-text">
                                     <?=substr($row->deskripsi,0,100)?>
                                 </p>
                                 <a href="<?=site_url('Padalarang/Padalarang/ArtikelLengkap/'. $row->id_berita)?>" class="btn btn-success">Selengkapnya</a>
                             </div>
                         </div>
                     </div>
                     <?php 
                         $counter++;
                     }?>
                 
                 <br>
                 <?php 
                 $counter = 0;
                 $sorted_galery = array_reverse($Padalarang_galery->result());
         
                 foreach ($sorted_galery as $row) {
                     if ($counter >= 2) {
                         break; 
                     }
                 ?>
                 <div class=" ">
                     <div class="card news-card">
                         <img src="<?=$row->gambar?>" class="card-img-top news-image" alt="News Image">
                         <div class="card-body">
                             <p class="card-text">
                                 <?=substr($row->kegiatan,0,100)?>
                             </p>
                         </div>
                     </div>
                 </div>
                 <?php 
                     $counter++;
                 }?>
             </div>
             </div>
             </div>
         
           
            