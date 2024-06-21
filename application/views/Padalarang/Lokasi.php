
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
                           <h1 class="display-3 text-white animated zoomIn">Lokasi & Kontak</h1>
                       </div>
                   </div>
               </div>
               <!-- Hero End -->
               
               <!-- About Start -->
               <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
                   <div class="container">
                       <div class="row g-5">
                           <div class="col-lg-7">
                               <div class="section-title mb-4">
                                   <h6 class="mb-4">Nama	    : Puskesmas Padalarang</h6>
                                   <?php
                                       foreach ($Padalarang_sejarah->result() as $row) {  ?>
                                   <h6 class="mb-4">Alamat	    : <?=$row->alamat?></h6> 
                                   <?php }?>
                                   <?php
                                       foreach ($Padalarang_sosialmedia->result() as $row) {  ?>
                                   <h6 class="mb-4">Email	    : <?=$row->email?></h6> 
                                   <h6 class="mb-4">Telepon	: <?=$row->no_hp?></h6>
                                   <?php }?>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               <!-- About End -->
           
               <!-- Isi Konten -->
               <div class="map-responsive " data-wow-delay="0.6s">
               <?php
                       foreach ($Padalarang_sejarah->result() as $row) {
                           echo $row->alamat_map; // Use echo to display the content
                       }
                       ?>
               </div>
            