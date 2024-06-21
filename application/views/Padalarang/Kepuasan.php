
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
                           <h1 class="display-3 text-white animated zoomIn">INDEKS KEPUASAN MASYARAKAT</h1>
                       </div>
                   </div>
               </div>
               <!-- Hero End -->
               
               <!-- Tombol Survey -->
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
               <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
               <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
               <style type="text/css">
                   .box{
                       padding: 30px 40px;
                       border-radius: 5px;
                   }
                   .feedback-btn {
                   cursor: pointer;
               }
           
               .feedback-img {
                   width: 100px;
               }
                 
              
               </style>
              
           <div class="container">
               <div class="card wow zoomIn data-wow-delay=0.6s">
                   <div class="card-body">
                   <?php echo $this->session->userdata("success"); ?>
                       <div class="alert alert-warning" role="alert">
                           Perhatian!!! Untuk memberikan penilaian silakan klik Emoji
                       </div>
                       <div class="row text-center">
           
                           <!-- Tombol "Puas" -->
                           <div class="col-md-4">
                               <div class="bg-primary box text-white">
                                   <div class="feedback-btn" data-toggle="modal" data-target="#puasModal">
                                   <div class="row">
                                       <div class="col-md-6">
                                           <h5>MEMUASKAN</h5>
                                           <h2 id="data-mati"> [ <?=$survey->puas?> ] </h2>
                                           <h5>suara </h5>
                                       </div>
                                       <div class="col-md-4">
                                               <img src="<?=base_url('asset/puas.png')?>" class="feedback-img" alt="Puas">
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
           
                           <!-- Modal "Puas" -->
                           <div class="modal fade" id="puasModal" tabindex="-1" role="dialog" aria-labelledby="puasModalLabel" aria-hidden="true">
                               <div class="modal-dialog" role="document">
                                   <div class="modal-content">
                                       <div class="modal-header">
                                           <h5 class="modal-title" id="puasModalLabel">Alasan Puas</h5>
                                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                               <span aria-hidden="true">&times;</span>
                                           </button>
                                       </div>
                                       <div class="modal-body">
                                           <form action="<?=site_url('Padalarang/Padalarang/submit_penilaian/puas');?>" method="post">
                                               <input type="hidden" name="alasan_type" value="puas">
                                               <textarea name="alasan_puas" class="form-control" placeholder="Berikan alasan Anda..."></textarea>
                                               <button type="submit" class="btn btn-primary mt-3">Kirim</button>
                                           </form>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <!-- Modal "Cukup" -->
                           <div class="modal fade" id="cukupModal" tabindex="-1" role="dialog" aria-labelledby="cukupModalLabel" aria-hidden="true">
                               <div class="modal-dialog" role="document">
                                   <div class="modal-content">
                                       <div class="modal-header">
                                           <h5 class="modal-title" id="cukupModalLabel">Alasan Cukup</h5>
                                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                               <span aria-hidden="true">&times;</span>
                                           </button>
                                       </div>
                                       <div class="modal-body">
                                           <form action="<?=site_url('Padalarang/Padalarang/submit_penilaian/cukup');?>" method="post">
                                               <input type="hidden" name="alasan_type" value="cukup">
                                               <textarea name="alasan_cukup" class="form-control" placeholder="Berikan alasan Anda..."></textarea>
                                               <button type="submit" class="btn btn-primary mt-3">Kirim</button>
                                           </form>
                                       </div>
                                   </div>
                               </div>
                           </div>
           
                           <!-- Tombol "Cukup" -->
                           <div class="col-md-4">
                               <div class="bg-success box text-white">
                                   <div class="feedback-btn" data-toggle="modal" data-target="#cukupModal">
                                   <div class="row">
                                       <div class="col-md-6">
                                           <h5>CUKUP</h5>
                                           <h2 id="data-mati"> [ <?=$survey->cukup?> ] </h2>
                                           <h5>suara </h5>
                                       </div>
                                       <div class="col-md-4">
                                               <img src="<?=base_url('asset/cukup.png')?>" class="feedback-img" alt="Cukup">
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
           
                           <!-- Modal "Kurang" -->
                           <div class="modal fade" id="kurangModal" tabindex="-1" role="dialog" aria-labelledby="kurangModalLabel" aria-hidden="true">
                               <div class="modal-dialog" role="document">
                                   <div class="modal-content">
                                       <div class="modal-header">
                                           <h5 class="modal-title" id="kurangModalLabel">Alasan Kurang</h5>
                                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                               <span aria-hidden="true">&times;</span>
                                           </button>
                                       </div>
                                       <div class="modal-body">
                                           <form action="<?=site_url('Padalarang/Padalarang/submit_penilaian/kurang');?>" method="post">
                                               <input type="hidden" name="alasan_type" value="kurang">
                                               <textarea name="alasan_kurang" class="form-control" placeholder="Berikan alasan Anda..."></textarea>
                                               <button type="submit" class="btn btn-primary mt-3">Kirim</button>
                                           </form>
                                       </div>
                                   </div>
                               </div>
                           </div>
           
                           <!-- Tombol "Kurang" -->
                           <div class="col-md-4">
                               <div class="bg-danger box text-white">
                                   <div class="feedback-btn" data-toggle="modal" data-target="#kurangModal">
                                   <div class="row">
                                       <div class="col-md-6">
                                           <h5>KURANG</h5>
                                           <h2 id="data-mati"> [ <?=$survey->kurang?> ] </h2>
                                           <h5>suara </h5>
                                       </div>
                                       <div class="col-md-4">
                                               <img src="<?=base_url('asset/kurang.png')?>" class="feedback-img" alt="Kurang">
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
          <!-- Include SweetAlert2 CSS -->
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
            <!-- Include SweetAlert2 JavaScript -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>Swal.fire ({title:"Bagian ini dikerjakan oleh kelompok lain!", confirmButtonColor: '#005700'}); </script>
           

            