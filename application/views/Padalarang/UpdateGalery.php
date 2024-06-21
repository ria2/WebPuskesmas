
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Update Galeri</h6>
                    </div>
                    <div class="card-body">
                    <?php echo $this->session->userdata("error"); ?>
                        <form class="user" method="post" action="<?=site_url('Padalarang/Padalarang_admin/prosesUpdateGalery/'.$Padalarang_galery->id_galery)?>" enctype="multipart/form-data">
                            <!-- Editor Galery -->
                            <div class="mb-3">
                                <label for="kegiatan">Kegiatan</label>
                                <div id="kegiatanEditor"></div>
                                <input type="hidden" name="kegiatan" id="kegiatanInput" required>
                            </div>

                            <div class="mb-3">
                                <label for="gambar" class="col-sm-2 control-label">Gambar</label>
                                <div class="col-sm-12">
                                    <img src="<?=$Padalarang_galery->gambar?>" width="50" height="60">
                                    <input type="file" id="foto" name="gambar">
                                </div>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-success btn-user btn-block">Update Galeri</button>
                        </form>
                    </div>
                </div>
                </div>
            </div>
            <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
            <script>
                var templateParagrafGalery = `<?=$Padalarang_galery->kegiatan?>`;
                var kegiatanEditor = new Quill('#kegiatanEditor', {
                    theme: 'snow'
                });
                kegiatanEditor.root.innerHTML = templateParagrafGalery;
                
                var submitBtn = document.querySelector('form.user button[type="submit"]');

                submitBtn.addEventListener('click', function() {
                    document.getElementById('kegiatanInput').value = kegiatanEditor.root.innerHTML;
                });
            </script>


            