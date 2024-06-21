<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Antrian</title>
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

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 8px;
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
    Laporan Pendaftar Puskesmas Padalarang
</p>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nik</th>
            <th>Nama</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>Pekerjaan</th>
            <th>Layanan</th>
            <th>Tanggal Daftar</th>
            <!-- Add more columns based on your database fields -->
        </tr>
    </thead>
    <tbody>
        <?php
        $counter = 1;
        $layananCount = array(); // Array to store the count of each service
        foreach ($allantrian as $row):
            // Increment the count for the specific service
            if (isset($layananCount[$row->layanan])) {
                $layananCount[$row->layanan]++;
            } else {
                $layananCount[$row->layanan] = 1;
            }
        ?>
            <tr>
                <td><?= $counter++ ?></td>
                <td><?= $row->nik?></td>
                <td><?= $row->nama ?></td>
                <td><?= $row->tempat_lahir ?></td>
                <td><?= $row->tanggal_lahir ?></td>
                <td><?= $row->jk ?></td>
                <td><?= $row->alamat ?></td>
                <td><?= $row->pekerjaan ?></td>
                <td><?= $row->layanan ?></td>
                <td><?= $row->tanggal ?></td>
                <!-- Add more cells based on your database fields -->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Display the count of each service -->
<h2>Jumlah Layanan:</h2>
<ul>
    <?php foreach ($layananCount as $layanan => $count): ?>
        <li><?= $layanan ?>: <?= $count ?></li>
    <?php endforeach; ?>
</ul>
<?php date_default_timezone_set('Asia/Jakarta'); ?>
<p style="text-align: right; color: #666; font-size: 12px;">Dicetak pada <?= date('d-m-Y H:i:s') ?></p>

</body>
</html>
