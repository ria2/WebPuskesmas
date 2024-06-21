
            <!-- Isi content -->

            <style>
            .carousel-caption {
                background-color: rgba(0, 0, 0, 0.5); /* Warna hitam dengan tingkat transparansi 0.5 */
                color: white; /* Warna teks putih */
            }
        </style>
        
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php
                $indicatorIndex = 0;
                foreach ($Padalarang_corousel->result() as $row) {
                    $indicatorClass = ($indicatorIndex === 0) ? 'class="active"' : '';
                    echo '<li data-target="#carouselExampleIndicators" data-slide-to="' . $indicatorIndex . '" ' . $indicatorClass . '></li>';
                    $indicatorIndex++;
                }
                ?>
            </ol>
            <div class="carousel-inner">
                <?php
                $itemIndex = 0;
                foreach ($Padalarang_corousel->result() as $row) {
                    $itemClass = ($itemIndex === 0) ? 'carousel-item active' : 'carousel-item';
                    echo '<div class="' . $itemClass . '">';
                    echo '<img class="d-block w-100" src="' . $row->gambar . '" alt="Slide ' . $itemIndex . '">';
                    echo '<div class="carousel-caption">'; // Add a div for the caption
                    echo '<br>'; 
                    echo '<br>'; 
                    echo '<br>'; 
                    echo '<br>'; 
                    echo '<br>'; 
                    echo '<br>'; 
                    echo '<p class="display-4 text-white">' . $row->judul . '</p>'; // Display the title from the data
                    echo '<p class="display-6 text-white">' . $row->keterangan . '</p>'; // Display the description from the data
                    echo '</div>'; // Close the caption div
                    echo '</div>';
                    $itemIndex++;
                }
                ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" ariahidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
                
                <!-- Include jQuery and Bootstrap JS -->
                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
                
                <script>
                    $(document).ready(function() {
                        $('#carouselExampleIndicators').carousel();
                    });
                </script>
            