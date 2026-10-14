<?php
require 'koneksi.php';

function h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function rupiah($value)
{
    return 'Rp ' . number_format((float) $value, 0, ',', '.');
}

$id = (int) ($_GET['id'] ?? 0);

$stmt = mysqli_prepare($conn, 'SELECT * FROM scooter WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$scooter = mysqli_fetch_assoc($hasil);

if (!$scooter) {
    http_response_code(404);
    exit('Scooter tidak ditemukan. <a href="index.php">Kembali ke katalog</a>.');
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Scooter — ScootHub</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="topbar">
        <a class="brandmark" href="index.php">scoot<span>hub.</span></a>

        <nav class="navlinks">
            <a href="index.php">Katalog</a>
            <a href="tambah.php">Tambah Scooter</a>
        </nav>
    </header>

    <main class="wrap">
        <p class="eyebrow">Scooter details</p>
        <h1 class="page-title">Detail scooter</h1>

        <section class="panel">
            <div class="detail-grid">
                <div class="detail-art" aria-hidden="true">🏍</div>

                <div>
                    <span class="pill">
                        <?= h($scooter['tipe_scooter']) ?>
                    </span>

                    <h2 class="page-title" style="font-size: 30px; margin-top: 12px;">
                        <?= h($scooter['nama_scooter']) ?>
                    </h2>

                    <p class="meta">
                        <?= h($scooter['merek_scooter']) ?>
                    </p>

                    <p class="price">
                        <?= rupiah($scooter['harga_scooter']) ?>
                    </p>

                    <dl class="detail-list">
                        <dt>Kode scooter</dt>
                        <dd><?= h($scooter['kode_scooter']) ?></dd>

                        <dt>Tipe scooter</dt>
                        <dd><?= h($scooter['tipe_scooter']) ?></dd>

                        <dt>Jenis mesin</dt>
                        <dd><?= h($scooter['jenis_mesin']) ?></dd>

                        <dt>Stok</dt>
                        <dd><?= (int) $scooter['stok_scooter'] ?> unit</dd>

                        <dt>Deskripsi</dt>
                        <dd><?= nl2br(h($scooter['deskripsi_scooter'])) ?></dd>
                    </dl>

                    <div class="actions">
                        <a class="btn" href="edit.php?id=<?= (int) $scooter['id'] ?>">
                            Edit scooter
                        </a>

                        <a class="btn secondary" href="index.php">
                            Kembali ke katalog
                        </a>

                        <a class="btn secondary" href="hapus.php?id=<?= (int) $scooter['id'] ?>">
                            Hapus
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        ScootHub · Praktikum PAW Modul 2
    </footer>
</body>

</html>