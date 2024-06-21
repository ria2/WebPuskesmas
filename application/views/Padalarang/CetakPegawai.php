<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Pegawai</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
            margin-top: -10px; 
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 12px;
        }

        th {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        h2 {
            margin-top: 20px;
            color: #333;
        }
        .logo1 {
            float: left;
            margin-right: 10px;
            width: 50px; 
            height: auto; 
        }
        .logo2 {
            float: right; 
            margin-left: 10px; 
            width: 160px; 
            height: auto; 
            margin-top: 10px; 
        }
    </style>
</head>
<body>
<img src="<?= base_url('asset/img/logodefault.png') ?>" alt="Logo" class="logo1">
<img src="<?= base_url('asset/img/dinkes.png') ?>" alt="Logo" class="logo2">
<h1>Puskesmas Padalarang</h1>
<p style="font-size: 14px; text-align: left; font-weight: bold; margin-bottom: 10px;">
    Data Pegawai Puskesmas Padalarang
</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Nik</th>
            <th>No HP</th>
            <th>Unit Kerja</th>
            <th>Jenis Kelamin</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Alamat</th>
            <th>Agama</th>
            <th>Pendidikan Terakhir</th>
            <th>Status Perkawinan</th>
            <th>Status Kepegawaian</th>
            <!-- Add more columns based on your database fields -->
        </tr>
    </thead>
    <tbody>
        <?php $counter = 1; ?>
        <?php foreach ($allpegawai as $row): ?>
            <tr>
                <td><?= $counter++ ?></td>
                <td><?= $row->nama?></td>
                <td><?= $row->nik_pegawai ?></td>
                <td><?= $row->no_hp ?></td>
                <td><?= $row->jabatan ?></td>
                <td><?= $row->jenis_kelamin ?></td>
                <td><?= $row->tempatlahir ?></td>
                <td><?= $row->tgl_lahir ?></td>
                <td><?= $row->alamat ?></td>
                <td><?= $row->agama ?></td>
                <td><?= $row->pendidikan ?></td>
                <td><?= $row->perkawinan ?></td>
                <td><?= $row->status ?></td>
                <!-- Add more cells based on your database fields -->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php date_default_timezone_set('Asia/Jakarta'); ?>
<p style="text-align: right; color: #666; font-size: 12px;">Dicetak pada <?= date('d-m-Y H:i:s') ?></p>

</body>
</html>
