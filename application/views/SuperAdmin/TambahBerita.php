<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Buat Berita</h6>
        </div>
        <div class="card-body">
        <?php echo $this->session->userdata("error"); ?>
            <form class="user" method="post" action="<?=site_url('SuperAdmin/Content/prosesTambahBerita')?>" enctype="multipart/form-data">
                <!-- Input Judul -->
                <div class="input-group mb-3">
                    <label for="deskripsi">Judul</label>
                    <div class="col-sm-12">
                    <input type="judul" class="form-control" name="judul" placeholder="Masukan Judul"  required>
                    </div>
                </div>
                
                <!-- Editor Misi -->
                <div class="mb-3">
                    <label for="deskripsi">Deskripsi</label>
                    <div id="deskripsiEditor"></div>
                    <input type="hidden" class="form-control" name="deskripsi" id="deskripsiInput" required>
                </div>
                 <!-- Input Judul -->
                 <div class="input-group mb-3">
                    <label for="penulis">Penulis</label>
                    <div class="col-sm-12">
                    <input type="text" class="form-control" name="penulis" placeholder="Masukan Penulis"  required>
                    </div>
                </div>
                 <!-- Input Sumber -->
                 <div class="input-group mb-3">
                                <label for="sumber">Sumber</label>
                                <div class="col-sm-12">
                                <input type="text" class="form-control" name="sumber" placeholder="Masukan Link sumber" >
                                </div>
                            </div>
                <div class="mb-3">
                    <label for="gambar" class="col-sm-2 control-label">Gambar</label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control" id="gambar" name="gambar">
                        </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-success btn-user btn-block">Buat Berita</button>
            </form>
        </div>
    </div>
</div>
</div>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
   

    var deskripsiEditor = new Quill('#deskripsiEditor', {
        theme: 'snow'
    });
    
    var submitBtn = document.querySelector('form.user button[type="submit"]');

    submitBtn.addEventListener('click', function() {
        document.getElementById('deskripsiInput').value = deskripsiEditor.root.innerHTML;
        
    });
</script>
