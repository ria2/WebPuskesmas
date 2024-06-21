
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Update Layanan Khusus</h6>
                    </div>
                    <div class="card-body">
                        <form class="user" method="post" action="<?=site_url('Padalarang/Padalarang_admin/prosesUpdateLayananKhusus/' .$Padalarang_layanankhusus->id_layanankhusus)?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Editor Visi -->
                                    <div class="mb-3">
                                        <label for="visi">Visi</label>
                                        <div id="visiEditor"></div>
                                        <input type="hidden" class="form-control" name="visi" id="visiInput" required>
                                    </div>

                                    <!-- Editor Atribut -->
                                    <div class="mb-3">
                                        <label for="atribut">Attribut</label>
                                        <div id="atributEditor"></div>
                                        <input type="hidden" class="form-control" name="atribut" id="atributInput" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <!-- Editor Misi -->
                                    <div class="mb-3">
                                        <label for="misi">Misi</label>
                                        <div id="misiEditor"></div>
                                        <input type="hidden" class="form-control" name="misi" id="misiInput" required>
                                    </div>

                                    <!-- Editor Layanan Terpadu -->
                                    <div class="mb-3">
                                        <label for="layananterpadu">Layanan Terpadu</label>
                                        <div id="layananterpaduEditor"></div>
                                        <input type="hidden" class="form-control" name="layananterpadu" id="layananterpaduInput" required>
                                    </div>
                                </div>
                            </div>

                            
                            <hr>
                            <button type="submit" class="btn btn-success btn-user btn-block">Update Layanan Khusus</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
                <script>
                    var templateParagrafLayanan0 = `<?=$Padalarang_layanankhusus->visi?>`;
                    var templateParagrafLayanan01 = `<?=$Padalarang_layanankhusus->misi?>`;
                    var templateParagrafLayanan1 = `<?=$Padalarang_layanankhusus->atribut?>`;
                    var templateParagrafLayanan2 = `<?=$Padalarang_layanankhusus->layananterpadu?>`;

                    var visiEditor = new Quill('#visiEditor', {
                        theme: 'snow'
                    });
                    visiEditor.root.innerHTML = templateParagrafLayanan0;
                    var misiEditor = new Quill('#misiEditor', {
                        theme: 'snow'
                    });
                    misiEditor.root.innerHTML = templateParagrafLayanan01;

                    var atributEditor = new Quill('#atributEditor', {
                        theme: 'snow'
                    });
                    atributEditor.root.innerHTML = templateParagrafLayanan1;

                    var layananterpaduEditor = new Quill('#layananterpaduEditor', {
                        theme: 'snow'
                    });
                    layananterpaduEditor.root.innerHTML = templateParagrafLayanan2;
                    
                    var submitBtn = document.querySelector('form.user button[type="submit"]');

                    submitBtn.addEventListener('click', function() {
                        document.getElementById('visiInput').value = visiEditor.root.innerHTML;
                        document.getElementById('misiInput').value = misiEditor.root.innerHTML;
                        document.getElementById('atributInput').value = atributEditor.root.innerHTML;
                        document.getElementById('layananterpaduInput').value = layananterpaduEditor.root.innerHTML;
                    });
                </script>



            