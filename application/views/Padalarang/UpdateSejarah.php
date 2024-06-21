
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Data Sejarah & Maklumat</h6>
                    </div>
                    <div class="card-body">
                    <?php echo $this->session->userdata("error"); ?>
                        <form class="user" method="post" action="<?=site_url('Padalarang/Padalarang_admin/prossesUpdateSejarah/'. $Padalarang_sejarah->id_sejarah)?>" enctype="multipart/form-data">
                            <!-- Input Visi -->
                            <div class="mb-3">
                                <label for="sejarah">Sejarah</label>
                                <div id="sejarahEditor"></div>
                                <input type="hidden" name="sejarah" id="sejarahInput" required>
                            </div>
                            
                            <!-- Input alamat -->
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="alamat" placeholder="Alamat " value="<?=$Padalarang_sejarah->alamat?>" required>
                            </div>
                            
                            <div class="mb-3">
                                    <label for="maklumat" class="col-sm-2 control-label">Maklumat</label>
                                    <div class="col-sm-12">
                                        <img src="<?=$Padalarang_sejarah->maklumat?>" width="50" height="60">
                                        <input type="file" id="foto" name="maklumat">
                                    </div>
                                </div>
                            
                            <hr>
                            <button type="button" class="btn btn-success btn-user btn-block" id="submitBtn">Update Sejarah & Maklumat</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
                <script>
                    var templateParagrafsejarah = `<?=$Padalarang_sejarah->sejarah?>`;
                

                    var sejarahEditor = new Quill('#sejarahEditor', {
                    theme: 'snow'
                });
                sejarahEditor.clipboard.dangerouslyPasteHTML(templateParagrafsejarah);

            

                var submitBtn = document.getElementById('submitBtn');

                submitBtn.addEventListener('click', function() {
                    document.getElementById('sejarahInput').value = sejarahEditor.root.innerHTML;
                    document.querySelector('form.user').submit(); // Submit the form
                });
                </script>


            