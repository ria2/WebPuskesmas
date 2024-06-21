
            <style>
            .news-card {
                height: 100%;
            }
        
            .news-image {
                max-height: 200px; /* Sesuaikan ukuran gambar yang diinginkan */
                object-fit: cover;
            }
            </style>
            <div class="container mt-5">
                <h2 class="text">Galeri</h2>
                <div class="row">
                <?php 
                    $counter = 0;
                    $sorted_galery = array_reverse($Padalarang_galery->result());
            
                    foreach ($sorted_galery as $row) {
                        if ($counter >= 5) {
                            break; 
                        }
                    ?>
                    <div class="col-md-4 mb-4">
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
            
            