<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
           
            
        </div>
        <div class="card-body">
            <div class="box">
            <div class="box-header d-flex justify-content-between">
            </div>
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Detail Website</h1>
                <a href="<?=$webpuskesmas->domain;?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                        class="fas fa-download fa-globe text-white-50"></i> Preview Web</a>
            </div>
            <div class="row">
                <div class="col-md-3.5">
                    <div class="card">
                        <img class="card-img-top" src="<?=$webpuskesmas->logo;?>" alt="" style="width: 200px; height: 235px;">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <h5 class="card-title"></h5>
                            <!-- <a href="#" class="btn btn-success mt-3"><i class="fas fa-sync-alt"></i> Update Icon</a> -->
                        </div>
                    </div>
                </div>



                    <div class="col-md-10">
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <span class="label">Nama Aplikasi</span> : <?=$webpuskesmas->nama_aplikasi; ?>
                                </li>
                                <li class="list-group-item">
                                    <span class="label">Deskripsi</span> : <?=$webpuskesmas->deskripsi; ?>
                                </li>
                                <li class="list-group-item">
                                    <span class="label">Kecamatan</span> : <?=$webpuskesmas->kecamatan; ?>
                                </li>
                                <li class="list-group-item">
                                    <span class="label">URL</span> : <?=$webpuskesmas->domain; ?>
                                </li>
                                <li class="list-group-item">
                                    <span class="label">Meta-Keyword</span> : <?=$webpuskesmas->meta_keyword; ?>
                                </li>
                                <li class="list-group-item">
                                    <span class="label">Meta-Deskripsi</span> : <?=$webpuskesmas->meta_deskripsi; ?>
                                </li>
                                <li class="list-group-item">
                                    <span class="label">Create</span> : <?=$webpuskesmas->create; ?>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>