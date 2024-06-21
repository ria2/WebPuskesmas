<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
   
</div>
<?php echo $this->session->userdata("success"); ?>

<!-- Content Row -->
<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Website</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $webpuskesmas; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-globe fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Total Super Admin</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $admin; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <!-- Earnings (Monthly) Card Example -->
 <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Berita</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $berita; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pengaduan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$umpan_balik?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Content Row -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-center align-items-top-center" style="height: 50vh;">
                                <div class="col-md-7">
                                    <canvas id="chartCanvas"></canvas>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nilai</th>
                                            <th>Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($survey_reason->result() as $row): ?>
                                            <tr>
                                                <td><?= ucfirst($row->type) ?></td>
                                                <td><?= ucfirst($row->reason) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
    </div>
</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var surveyData = {
        labels: ['Puas', 'Cukup', 'Kurang'],
        datasets: [{
            data: [<?=$survey->puas?>, <?=$survey->cukup?>, <?=$survey->kurang?>],
            backgroundColor: ['#007bff', '#28a745', '#dc3545']
        }]
    };

    var options = {
        responsive: true
    };

    var ctx = document.getElementById('chartCanvas').getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: surveyData,
        options: options
    });
</script>

<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Include SweetAlert2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Periksa apakah pengguna harus mengganti kata sandi
function periksaGantiKataSandi() {
// Ambil nilai 'privasi' dari sesi pengguna
    var nilaiUbahPass = "<?php echo $this->session->userdata('privasi'); ?>"; // Tambahkan tanda kutip
        if (nilaiUbahPass === '0') {
            tampilkanPopupGantiKataSandi();
        }
}

// Tampilkan popup yang memberi tahu pengguna untuk mengganti kata sandi
function tampilkanPopupGantiKataSandi() {
    Swal.fire({
    title: 'Pemberitahuan Privasi dan Keamanan',
    text: 'Anda belum mengganti kata sandi. Silakan perbarui!',
    icon: 'info',
    showCloseButton: true,
    confirmButtonText: '<a id="linkGantiKataSandi">Ganti Kata Sandi</a>',
    confirmButtonColor: '#005700', // Atur warna hijau di sini
    });

    // Tambahkan event listener untuk tautan "Ganti Kata Sandi"
    const linkGantiKataSandi = document.getElementById('linkGantiKataSandi');
    linkGantiKataSandi.addEventListener('click', function (event) {
    event.preventDefault();
    const url = "<?= site_url("SuperAdmin/Content/UpdateAdmin/" . $this->session->userdata('id_user')) ?>";
    // Redirect ke URL yang dihasilkan saat tombol "Ganti Kata Sandi" diklik
    window.location.href = url;
    });
}

// Panggil fungsi untuk memeriksa apakah pengguna harus mengganti kata sandi saat halaman dimuat
    window.onload = periksaGantiKataSandi;
</script>