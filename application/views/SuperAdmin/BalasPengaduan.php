<div class="container-fluid">
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold ">Balas Pesan Pengaduan</h6>
        </div>
        <div class="card-body">
            <form class="user" method="post" action="<?=site_url('SuperAdmin/Content/BalasPesan')?>" enctype="multipart/form-data">
           
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" value="<?=$umpan_balik->email?>" readonly  required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="subject" value="<?=$umpan_balik->subject?>" readonly  required>
                </div>
                <div class="mb-3">
                    <textarea type="text" class="form-control" name="pesan" value="<?=$umpan_balik->pesan?>" readonly  required><?=$umpan_balik->pesan?></textarea>
                </div>
                <div class="mb-3">
                    <label>Subject</label>
                    <input type="text" class="form-control" name="subjectbalas"  placeholder="Masukan Subject Pesan" required>
                </div>
                <div class="mb-3">
                    <label>Balasan</label>
                    <textarea type="text" class="form-control" name="balas" placeholder="Masukan Pesan Balasan" required></textarea>
                </div>
                
 
                <hr>
                <button type="submit" class="btn btn-success btn-user btn-block">Balas</button>
            </form>
        </div>
    </div>

</div>
</div>

