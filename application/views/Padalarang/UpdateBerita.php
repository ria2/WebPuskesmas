
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Update Berita</h6>
                    </div>
                    <div class="card-body">
                    <?php echo $this->session->userdata("error"); ?>
                        <form class="user" method="post" action="<?=site_url('Padalarang/Padalarang_admin/prosesUpdateBerita/'.$berita->id_berita)?>" enctype="multipart/form-data">
                            <!-- Input Judul -->
                            <div class="input-group mb-3">
                                <label for="judul">Judul</label>
                                <div class="col-sm-12">
                                <input type="text" class="form-control" name="judul" placeholder="Masukan Judul" value="<?=$berita->judul?>" required>
                                </div>
                            </div>
                            
                            <!-- Editor Misi -->
                            <div class="mb-3">
                                <label for="deskripsi">Deskripsi</label>
                                <div id="deskripsiEditor"></div>
                                <input type="hidden" name="deskripsi" id="deskripsiInput"required>
                            </div>
                            <!-- Input Penulis -->
                            <div class="input-group mb-3">
                                <label for="penulis">Penulis</label>
                                <div class="col-sm-12">
                                <input type="text" class="form-control" name="penulis" placeholder="Masukan penulis" value="<?=$berita->penulis?>" required>
                                </div>
                            </div>
                            <!-- Input Sumber -->
                            <div class="input-group mb-3">
                               <label for="sumber">Sumber</label>
                               <div class="col-sm-12">
                               <input type="text" class="form-control" name="sumber" placeholder="Masukan Link sumber" value="<?=$berita->sumber?>" >
                               </div>
                           </div>
                            <div class="mb-3">
                                <label for="gambar" class="col-sm-2 control-label">Gambar</label>
                                <div class="col-sm-12">
                                        <img src="<?=$berita->gambar?>" weight="50" height="60">
                                        <input type="file" id="foto" name="gambar" >
                                    </div>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-success btn-user btn-block">Update Berita</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
            <script>
                var templateParagrafBerita = `<?=$berita->deskripsi?>`;
                var deskripsiEditor = new Quill('#deskripsiEditor', {
                    theme: 'snow'
                });
                deskripsiEditor.root.innerHTML = templateParagrafBerita;
                
                var submitBtn = document.querySelector('form.user button[type="submit"]');

                submitBtn.addEventListener('click', function() {
                    document.getElementById('deskripsiInput').value = deskripsiEditor.root.innerHTML;
                });
            </script>


            