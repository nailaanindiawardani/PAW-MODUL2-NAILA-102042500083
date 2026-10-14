<?php
require 'koneksi.php';

function h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
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

if (isset($_POST['hapus'])) {
    $stmt = mysqli_prepare($conn, 'DELETE FROM scooter WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $id);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: index.php?pesan=1');
        exit;
    }

    $pesan = 'Scooter gagal dihapus. Silakan coba kembali.';
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hapus Produk — ScootHub</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="topbar">
        <a class="brandmark" href="index.php">
            scoot<span>hub.</span>
        </a>

        <nav class="navlinks">
            <a href="index.php">Katalog</a>
            <a href="tambah.php">Tambah Scooter</a>
        </nav>
    </header>

    <main class="wrap">
        <p class="eyebrow">Konfirmasi tindakan</p>
        <h1 class="page-title">Hapus scooter?</h1>

        <section class="panel">
            <div class="product-art" aria-hidden="true">🏍</div>

            <h2>
                <?= h($scooter['nama_scooter']) ?>
            </h2>

            <p class="meta">
                <?= h($scooter['merek_scooter']) ?>
                ·
                <?= h($scooter['kode_scooter']) ?>
            </p>

            <p>
                Produk ini akan dihapus dari katalog.
                Data yang sudah dihapus tidak bisa dikembalikan.
            </p>

            <?php if (isset($pesan)): ?>
                <div class="error">
                    <?= h($pesan) ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="actions">
                    <button class="btn danger" type="submit" name="hapus">
                        Ya, hapus scooter
                    </button>

                    <a class="btn secondary" href="detail.php?id=<?= $id ?>">
                        Batal
                    </a>
                </div>
            </form>
        </section>
    </main>

    <footer class="footer">
        ScootHub · Praktikum PAW Modul 2
    </footer>
</body>

</html>