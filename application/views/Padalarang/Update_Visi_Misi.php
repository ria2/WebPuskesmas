
            <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Data Profile</h6>
                </div>
                <div class="card-body">
                    <form class="user" method="post" action="<?=site_url('Padalarang/Padalarang_admin/prossesUpdateVisi/'. $Padalarang_visi_misi->id_visi)?>" enctype="multipart/form-data">
                    <div class="row">
                            <div class="col-md-6">    
                    <!-- Input Visi -->
                        <div class="mb-3">
                            <label for="visi">Visi</label>
                            <div id="visiEditor"></div>
                            <input type="hidden" name="visi" id="visiInput" required>
                        </div>
                        
                        <!-- Editor Misi -->
                        <div class="mb-3">
                            <label for="misi">Misi</label>
                            <div id="misiEditor"></div>
                            <input type="hidden" name="misi" id="misiInput" required>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <!-- Input Motto -->
                        <div class="mb-3">
                            <label for="motto">Motto</label>
                            <div id="mottoEditor"></div>
                            <input type="hidden" name="motto" id="mottoInput" required>
                        </div>
                         <!-- Input Tatanilai -->
                         <div class="mb-3">
                            <label for="tatanilai">Tata Nilai</label>
                            <div id="tatanilaiEditor"></div>
                            <input type="hidden" name="tatanilai" id="tatanilaiInput" required>
                        </div>
                         <!-- Input Logo -->
                         <div class="mb-3">
                         <label>Logo</label>
                                <input type="file" class="form-control" name="logo" placeholder="Foto">
                                <div class="form-text" id="basic-addon4"> Format : (.png/.jpg/.gif)  Size min : 1 MB , Dimension Recomended : 500 x 450 </div>
                        </div>
                        </div>
                        
                        <hr>
                        <button type="button" class="btn btn-success btn-user btn-block" id="submitBtn">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
            <script>
                var templateParagrafvisi = `<?=$Padalarang_visi_misi->visi?>`;
                var templateParagrafmisi = `<?=$Padalarang_visi_misi->misi?>`;
                var templateParagrafmotto = `<?=$Padalarang_visi_misi->motto?>`;
                var templateParagraftatanilai = `<?=$Padalarang_visi_misi->tatanilai?>`;
        
                var visiEditor = new Quill('#visiEditor', {
                theme: 'snow'
            });
            visiEditor.clipboard.dangerouslyPasteHTML(templateParagrafvisi);
        
            var misiEditor = new Quill('#misiEditor', {
                theme: 'snow'
            });
            misiEditor.clipboard.dangerouslyPasteHTML(templateParagrafmisi);
        
            var mottoEditor = new Quill('#mottoEditor', {
                theme: 'snow'
            });
            mottoEditor.clipboard.dangerouslyPasteHTML(templateParagrafmotto);
        
            var tatanilaiEditor = new Quill('#tatanilaiEditor', {
                theme: 'snow'
            });
            tatanilaiEditor.clipboard.dangerouslyPasteHTML(templateParagraftatanilai);
        
            var submitBtn = document.getElementById('submitBtn');
        
            submitBtn.addEventListener('click', function() {
                document.getElementById('visiInput').value = visiEditor.root.innerHTML;
                document.getElementById('misiInput').value = misiEditor.root.innerHTML;
                document.getElementById('mottoInput').value = mottoEditor.root.innerHTML;
                document.getElementById('tatanilaiInput').value = tatanilaiEditor.root.innerHTML;
                document.querySelector('form.user').submit(); // Submit the form
            });
            </script>
        
            