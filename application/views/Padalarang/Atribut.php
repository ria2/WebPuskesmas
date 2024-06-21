
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
                         <h1 class="display-3 text-white animated zoomIn">Atribut</h1>
                     </div>
                 </div>
             </div>
             <!-- Hero End -->
         
             <!-- Isi Konten 1 -->
             <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
                 <div class="container">
                     <div class="row g-5">
                         <div class="col-lg-5" style="min-height: 250px;">
                             <div class="position-relative h-100">
                                 <img class="position-absolute w-100 h-100 rounded wow zoomIn" data-wow-delay="0.9s" src="<?php echo base_url('asset/assets_user/img/team.png'); ?>" style="object-fit: contain;">
                             </div>
                         </div>
                         <div class="col-lg-7">
                             <div class="section-title mb-4">
                                 <h5 class="position-relative d-inline-block text-primary text-uppercase">Atribut Pegawai dan Ruangan</h5>
                                 <h1 class="display-5 mb-0">Atribut yang dipakai</h1>
                             </div>
                             <ul class ="mb-4">
                             <?php
                             foreach ($Padalarang_layanankhusus->result() as $row) {
                                 echo $row->atribut; // Use echo to display the content
                             }
                             ?>
                         </ul>
                         </div>
                     </div>
                 </div>
             </div>
             </div>
             <br>
             <!-- Isi Konten 1 end -->
         
               
            