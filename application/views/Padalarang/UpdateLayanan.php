
            <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Update Layanan </h6>
                </div>
                <div class="card-body">
                <?php echo $this->session->userdata("error"); ?>
                    <form class="user" method="post" action="<?=site_url('Padalarang/Padalarang_admin/prosesUpdateLayanan/' .$Padalarang_layanan->id_layanan)?>" enctype="multipart/form-data">
                    <div style="display: flex; gap: 10px;">
                        <div  class="mb-3 col-8">                 
                            <label for="spm">Standar Pelayanan Minimal</label><br>
                            <img src="<?=$Padalarang_layanan->spm?>" width="50" height="60">
                            <input type="file" class="form" name="spm" placeholder="Masukan SPM"   >
                        </div>
                        <div class="mb-3">
                            <label>Konpensasi</label><br>
                            <img src="<?=$Padalarang_layanan->konpensasi?>" width="50" height="60">
                            <input type="file" class="form" name="konpensasi" placeholder="konpensasi"  >
                        </div>
                    </div>
                    <!-- Editor Misi -->
                    <div class="mb-3">
                            <label for="sarana">Sarana & Prasarana</label>
                            <div id="saranaEditor"></div>
                            <input type="hidden" class="form-control" name="sarana" id="saranaInput" required>
                        </div>
                        <!-- Editor Misi -->
                        <div class="mb-3">
                            <label for="fasilitas">Fasilitas</label>
                            <div id="fasilitasEditor"></div>
                            <input type="hidden" class="form-control" name="fasilitas" id="fasilitasInput" required>
                        </div>
                        <!-- Editor Misi -->
                        <div class="mb-3">
                            <label for="mekanisme">Mekanisme & Prosedur</label>
                            <div id="mekanismeEditor"></div>
                            <input type="hidden" class="form-control" name="mekanisme" id="mekanismeInput" required>
                        </div>
                        
                        
                        <hr>
                        <button type="submit" class="btn btn-success btn-user btn-block">Update Layanan </button>
                    </form>
                </div>
            </div>
            </div>
            </div>
            <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
            <script>
            var templateParagrafsarana = `<?=$Padalarang_layanan->sarana?>`;
            var templateParagraffasilitas = `<?=$Padalarang_layanan->fasilitas?>`;
            var templateParagrafmekanisme = `<?=$Padalarang_layanan->mekanisme?>`;


            var saranaEditor = new Quill('#saranaEditor', {
                theme: 'snow'
            });
            saranaEditor.clipboard.dangerouslyPasteHTML(templateParagrafsarana);
            var fasilitasEditor = new Quill('#fasilitasEditor', {
                theme: 'snow'
            });
            fasilitasEditor.clipboard.dangerouslyPasteHTML(templateParagraffasilitas);
            var mekanismeEditor = new Quill('#mekanismeEditor', {
                theme: 'snow'
            });
            mekanismeEditor.clipboard.dangerouslyPasteHTML(templateParagrafmekanisme);

            var submitBtn = document.querySelector('form.user button[type="submit"]');

            submitBtn.addEventListener('click', function() {
                document.getElementById('saranaInput').value = saranaEditor.root.innerHTML;
                document.getElementById('fasilitasInput').value = fasilitasEditor.root.innerHTML;
                document.getElementById('mekanismeInput').value = mekanismeEditor.root.innerHTML;
                
            });
            </script>
            